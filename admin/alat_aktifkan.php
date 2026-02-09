<?php
include "../config/database.php";

$id = $_GET['id'];

mysqli_query($koneksi,
    "UPDATE alat SET status='aktif' WHERE id='$id'"
);

header("Location: alat.php");
exit;
