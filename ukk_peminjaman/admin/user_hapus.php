<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: user.php");
    exit;
}

// =======================
// CEK PINJAMAN AKTIF
// =======================
$cek = mysqli_query($koneksi, "
    SELECT id FROM peminjaman 
    WHERE user_id='$id' 
    AND status IN ('menunggu_peminjaman','dipinjam','menunggu_pengembalian')
");

if (mysqli_num_rows($cek) > 0) {
    header("Location: user.php?msg=gagal_ada_tanggungan");
    exit;
}

mysqli_begin_transaction($koneksi);

try {

    // Ambil username untuk log
    $u = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT username FROM users WHERE id='$id'"));
    $username = $u['username'] ?? 'Unknown';

    // =======================
    // HAPUS DETAIL PEMINJAMAN
    // =======================
    mysqli_query($koneksi,"
        DELETE FROM detail_peminjaman 
        WHERE peminjaman_id IN (
            SELECT id FROM peminjaman WHERE user_id='$id'
        )
    ");

    // =======================
    // HAPUS PENGEMBALIAN
    // =======================
    mysqli_query($koneksi,"
        DELETE FROM pengembalian 
        WHERE peminjaman_id IN (
            SELECT id FROM peminjaman WHERE user_id='$id'
        )
    ");

    // =======================
    // HAPUS PEMINJAMAN
    // =======================
    mysqli_query($koneksi,"
        DELETE FROM peminjaman WHERE user_id='$id'
    ");

    // =======================
    // HAPUS LOG USER (opsional)
    // =======================
    mysqli_query($koneksi,"
        DELETE FROM log_aktivitas WHERE user_id='$id'
    ");

    // =======================
    // HAPUS USER
    // =======================
    mysqli_query($koneksi,"
        DELETE FROM users WHERE id='$id'
    ");

    // =======================
    // LOG ADMIN
    // =======================
    $admin_id = $_SESSION['user_id'];
    $aktivitas = "Menghapus user: $username";

    mysqli_query($koneksi,"
        INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
        VALUES ('$admin_id','$aktivitas',NOW())
    ");

    mysqli_commit($koneksi);

    header("Location: user.php?msg=deleted");
    exit;

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "❌ Gagal menghapus user: " . $e->getMessage();
}