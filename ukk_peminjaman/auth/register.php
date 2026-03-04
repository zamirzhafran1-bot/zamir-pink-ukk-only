<?php
session_start();
include "../config/database.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register | SIPINJAM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/style.css">

</head>

<body class="d-flex align-items-center justify-content-center vh-100">

<div class="col-md-4 col-sm-10">

<div class="card shadow-lg border-0 rounded-4 p-4">

<div class="text-center mb-3">
<img src="../assets/smk.png" width="70">
<h4 class="mt-2 fw-bold">Register SIPINJAM</h4>
<small>Buat akun peminjam</small>
</div>

<form method="post" action="proses_register.php">

<div class="mb-3">
<label>Nama</label>
<input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-primary w-100 rounded-pill">
Register
</button>

<a href="login.php" class="btn btn-link w-100 mt-2">
Sudah punya akun? Login
</a>

</form>
</div>
</div>

</body>
</html>
