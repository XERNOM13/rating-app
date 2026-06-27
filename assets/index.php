<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Film & Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="container-fluid py-5">
        <div class="container max-width-container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h1 class="card-title mb-4">Tambah Rating Baru</h1>
                            <form id="ratingForm" class="rating-form">
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-lg" id="judul" name="judul" placeholder="Judul Film/Game" required>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select form-select-lg" id="kategori" name="kategori" required>
                                        <option value="film">Film</option>
                                        <option value="game">Game</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control form-control-lg" id="rating" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Rating</button>
                            </form>
                            <p id="message" class="message alert d-none mt-3 mb-0" role="alert"></p>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h2 class="card-title mb-3">Daftar Rating</h2>
                            <p id="ratingSummary" class="summary text-muted mb-3"></p>
                            <div id="daftarList" class="list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>