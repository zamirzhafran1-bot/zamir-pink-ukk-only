<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ukk_peminjaman";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal");
}
?>
