<?php
include 'config.php';
header('Content-Type: application/json; charset=utf-8');

function ensureTable(mysqli $conn): void {
    $sql = "CREATE TABLE IF NOT EXISTS items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(255) NOT NULL,
        kategori VARCHAR(50) NOT NULL,
        rating TINYINT UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!mysqli_query($conn, $sql)) {
        throw new RuntimeException('Gagal membuat tabel items: ' . mysqli_error($conn));
    }
}

try {
    ensureTable($conn);

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    if ($method === 'GET') {
        $result = mysqli_query($conn, "SELECT id, judul, kategori, rating, created_at FROM items ORDER BY created_at DESC");
        $data = [];

        if ($result) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        echo json_encode($data);
        exit;
    }

    if ($method === 'POST') {
        $judul = trim($_POST['judul'] ?? '');
        $kategori = trim($_POST['kategori'] ?? '');
        $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);

        if ($judul === '' || !in_array($kategori, ['film', 'game'], true) || $rating === false || $rating < 1 || $rating > 5) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid.']);
            exit;
        }

        $stmt = mysqli_prepare($conn, 'INSERT INTO items (judul, kategori, rating) VALUES (?, ?, ?)');
        if (!$stmt) {
            throw new RuntimeException('Gagal menyiapkan query: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ssi', $judul, $kategori, $rating);
        if (!mysqli_stmt_execute($stmt)) {
            throw new RuntimeException('Gagal menyimpan data: ' . mysqli_stmt_error($stmt));
        }

        echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
        exit;
    }

    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>