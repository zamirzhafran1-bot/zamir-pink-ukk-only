<?php
session_start();
include "../config/database.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
$data  = mysqli_fetch_assoc($query);

if ($data && $password == $data['password']) {

    $_SESSION['id_user'] = $data['id'];
    $_SESSION['nama']    = $data['nama'];
    $_SESSION['role']    = $data['role'];

    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas(user_id, aktivitas, waktu)
         VALUES ('$data[id]', 'Login ke sistem', NOW())"
    );

    header("Location: ../".$data['role']."/dashboard.php");
} else {
    header("Location: login.php?error=1");
}
