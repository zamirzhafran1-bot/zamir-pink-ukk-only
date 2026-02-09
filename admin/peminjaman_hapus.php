<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];

$detail = mysqli_query($koneksi,
    "SELECT alat_id, jumlah FROM detail_peminjaman WHERE peminjaman_id='$id'"
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
