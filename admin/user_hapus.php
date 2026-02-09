<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}

$id = $_GET['id'];

mysqli_begin_transaction($koneksi);

try {
    // 1. Hapus detail peminjaman
    mysqli_query($koneksi,
        "DELETE dp FROM detail_peminjaman dp
         JOIN peminjaman p ON dp.peminjaman_id = p.id
         WHERE p.user_id='$id'"
    );

    // 2. Hapus pengembalian (BERDASARKAN peminjaman)
    mysqli_query($koneksi,
        "DELETE pg FROM pengembalian pg
         JOIN peminjaman p ON pg.peminjaman_id = p.id
         WHERE p.user_id='$id'"
    );

    // 3. Hapus peminjaman
    mysqli_query($koneksi,
        "DELETE FROM peminjaman WHERE user_id='$id'"
    );

    // 4. Terakhir hapus user
    mysqli_query($koneksi,
        "DELETE FROM users WHERE id='$id'"
    );

    mysqli_commit($koneksi);
    header("Location: user.php");

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "Gagal menghapus user: " . $e->getMessage();
}
