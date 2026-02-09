<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: alat.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($koneksi,
    "UPDATE alat SET status='nonaktif' WHERE id='$id'"
);

header("Location: alat.php");
exit;
