<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($koneksi, "UPDATE peminjaman 
SET status='dipinjam' 
WHERE id='$id'");

header("Location: peminjaman.php");
exit;
?>
