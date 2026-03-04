<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$user_id     = $_POST['user_id'];
$alat_id     = $_POST['alat_id'];
$jumlah      = $_POST['jumlah'];
$tgl_pinjam  = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];

$cek = mysqli_query($koneksi, "SELECT stok FROM alat WHERE id='$alat_id'");
$a = mysqli_fetch_assoc($cek);

if ($a['stok'] < $jumlah) {
    die("Stok tidak mencukupi");
}

mysqli_begin_transaction($koneksi);

try {
    mysqli_query($koneksi,
        "INSERT INTO peminjaman (user_id, tgl_pinjam, tgl_kembali, status)
         VALUES ('$user_id', '$tgl_pinjam', '$tgl_kembali', 'dipinjam')"
    );

    $peminjaman_id = mysqli_insert_id($koneksi);

    mysqli_query($koneksi,
        "INSERT INTO detail_peminjaman (peminjaman_id, alat_id, jumlah)
         VALUES ('$peminjaman_id', '$alat_id', '$jumlah')"
    );

    mysqli_query($koneksi,
        "UPDATE alat SET stok = stok - $jumlah WHERE id='$alat_id'"
    );

    mysqli_commit($koneksi);
    header("Location: peminjaman_admin.php");
    exit;

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "Gagal menyimpan peminjaman";
}
