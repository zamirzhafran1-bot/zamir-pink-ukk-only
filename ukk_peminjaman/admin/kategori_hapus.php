<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$id'");
header("Location: kategori.php");
 // log aktivitas
 if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Menghapus kategori";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );