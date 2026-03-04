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
 // log aktivitas
 if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Menghapus alat $nama";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "Gagal menghapus alat: " . $e->getMessage();
}
