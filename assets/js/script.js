document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('ratingForm');
    const list = document.getElementById('daftarList');
    const summary = document.getElementById('ratingSummary');
    const message = document.getElementById('message');

    function renderStars(rating) {
        return '★'.repeat(rating) + '☆'.repeat(5 - rating);
    }

    async function loadData() {
        try {
            const response = await fetch('api.php');
            if (!response.ok) {
                throw new Error('Gagal memuat data.');
            }

            const data = await response.json();
            if (!Array.isArray(data)) {
                throw new Error('Format data tidak sesuai.');
            }

            summary.textContent = `${data.length} item sudah dirating`;

            if (data.length === 0) {
                list.innerHTML = '<p class="empty-state">Belum ada rating yang tersimpan.</p>';
                return;
            }

            list.innerHTML = `
                <div class="card-grid">
                    ${data.map(item => `
                        <article class="rating-card">
                            <div class="card-top">
                                <h3>${item.judul}</h3>
                                <span class="badge">${item.kategori}</span>
                            </div>
                            <p class="stars">${renderStars(Number(item.rating))}</p>
                            <p class="rating-value">${item.rating}/5</p>
                        </article>
                    `).join('')}
                </div>
            `;
        } catch (error) {
            list.innerHTML = `<p class="error">${error.message}</p>`;
        }
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        message.textContent = 'Menyimpan...';
        message.classList.remove('alert-danger');
        message.classList.add('alert', 'd-none');

        try {
            const response = await fetch('api.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (!response.ok || result.status !== 'success') {
                throw new Error(result.message || 'Gagal menyimpan data.');
            }

            form.reset();
            message.textContent = result.message;
            message.classList.remove('d-none');
            message.classList.add('alert-info');
            await loadData();
        } catch (error) {
            message.textContent = error.message;
            message.classList.remove('d-none', 'alert-info');
            message.classList.add('alert-danger');
        } finally {
            submitButton.disabled = false;
        }
    });

    loadData();
});
