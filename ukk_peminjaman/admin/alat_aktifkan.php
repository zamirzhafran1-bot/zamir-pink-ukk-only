<?php
session_start();
include "../config/database.php";
if (!isset($_GET['id'])) {
    header("Location: alat.php");
    exit;
}

$id = $_GET['id'];
mysqli_query($koneksi,
    "UPDATE alat SET status='aktif' WHERE id='$id'"
);
 // log aktivitas
 if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}

$user_id     = $_SESSION['id_user'];
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', 'Meng-aktifkan alat', NOW())"
    );

header("Location: alat.php");
exit;


