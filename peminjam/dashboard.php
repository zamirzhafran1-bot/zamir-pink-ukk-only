<?php
session_start();
if ($_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Dashboard Peminjam</h3>
    <p>Selamat datang, <b><?= $_SESSION['nama'] ?></b></p>

    <div class="list-group">
    <a href="pinjam.php" class="list-group-item">Pinjam Alat</a>
    <a href="riwayat.php" class="list-group-item">Riwayat Peminjaman</a>
    <a href="kembali.php" class="list-group-item">Pengembalian Alat</a>
    <a href="../auth/logout.php" class="list-group-item list-group-item-danger">Logout</a>
</div>

</div>

</body>
</html>
