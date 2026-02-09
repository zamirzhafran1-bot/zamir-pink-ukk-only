<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}

$id = $_GET['id'];

mysqli_begin_transaction($koneksi);

try {
    // Hapus relasi detail peminjaman
    mysqli_query($koneksi,
        "DELETE FROM detail_peminjaman WHERE alat_id='$id'"
    );

    // Hapus alat
    mysqli_query($koneksi,
        "DELETE FROM alat WHERE id='$id'"
    );

    mysqli_commit($koneksi);
    header("Location: alat.php");

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "Gagal menghapus alat: " . $e->getMessage();
}
