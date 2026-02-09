<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$id'");
header("Location: kategori.php");
