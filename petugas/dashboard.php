<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Dashboard Petugas</h3>
    <p>Selamat datang, <b><?= $_SESSION['nama'] ?></b></p>

    <div class="list-group">

        <div class="list-group-item list-group-item-secondary">
            <b>Transaksi</b>
        </div>

        <a href="peminjaman.php" class="list-group-item list-group-item-action">
            Menyetujui Peminjaman
        </a>

        <a href="kembali.php" class="list-group-item list-group-item-action">
            Monitoring Pengembalian
        </a>

        <div class="list-group-item list-group-item-secondary mt-2">
            <b>Laporan</b>
        </div>

        <a href="laporan.php" class="list-group-item list-group-item-action">
            Cetak Laporan
        </a>

        <a href="../auth/logout.php" class="list-group-item list-group-item-danger mt-2">
            Logout
        </a>

    </div>
</div>

</body>
</html>
