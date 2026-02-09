<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['id_user'];

$cek = mysqli_query($koneksi,
    "SELECT * FROM peminjaman
     WHERE id='$id'
     AND user_id='$user_id'
     AND status='dipinjam'"
);

if (mysqli_num_rows($cek) == 0) {
    header("Location: kembali.php");
    exit;
}

mysqli_query($koneksi,
    "UPDATE peminjaman
     SET status='menunggu_pengembalian'
     WHERE id='$id'"
);

header("Location: kembali.php");
exit;
?>
