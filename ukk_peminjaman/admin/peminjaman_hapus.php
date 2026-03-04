<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];

$detail = mysqli_query($koneksi,
    "SELECT alat_id, jumlah FROM detail_peminjaman WHERE peminjaman_id='$id'"
);
 // log aktivitas
 if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Menghapus peminjaman alat dari admin $nama";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
while ($d = mysqli_fetch_assoc($detail)) {
    mysqli_query($koneksi,
        "UPDATE alat SET stok = stok + {$d['jumlah']} WHERE id='{$d['alat_id']}'"
    );
}

mysqli_query($koneksi, "DELETE FROM detail_peminjaman WHERE peminjaman_id='$id'");
mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id='$id'");

header("Location: peminjaman_admin.php");
exit;
