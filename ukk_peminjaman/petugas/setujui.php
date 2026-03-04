<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}
 // log aktivitas
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Menyetujui peminjaman";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
$id = $_GET['id'];

mysqli_query($koneksi, "UPDATE peminjaman 
SET status='dipinjam' 
WHERE id='$id'");

header("Location: peminjaman.php");
exit;
?>
