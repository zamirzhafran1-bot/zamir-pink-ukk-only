<?php
include "../config/database.php";

$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];

/* CEK USERNAME */
$cek = mysqli_query($koneksi,"SELECT * FROM users WHERE username='$username'");

if(mysqli_num_rows($cek) > 0){
    header("Location: register.php?error=username");
    exit;
}

/* SIMPAN USER BARU (default role = peminjam) */
mysqli_query($koneksi,"
INSERT INTO users(nama, username, password, role)
VALUES('$nama','$username','$password','peminjam')
");

header("Location: login.php?success=register");
