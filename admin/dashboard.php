<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Dashboard Admin</h3>
    <p>Selamat datang, <b><?= $_SESSION['nama']; ?></b></p>

    <div class="list-group">

        <!-- MASTER DATA -->
        <div class="list-group-item list-group-item-secondary">
            <b>Master Data</b>
        </div>
        <a href="user.php" class="list-group-item list-group-item-action">
            Kelola User
        </a>
        <a href="alat.php" class="list-group-item list-group-item-action">
            Kelola Alat
        </a>
        <a href="kategori.php" class="list-group-item list-group-item-action">
            Kelola Kategori
        </a>

        <!-- TRANSAKSI -->
        <div class="list-group-item list-group-item-secondary mt-2">
            <b>Transaksi</b>
        </div>
        <a href="peminjaman_admin.php" class="list-group-item list-group-item-action">
            Kelola Peminjaman
        </a>
        <a href="pengembalian_admin.php" class="list-group-item list-group-item-action">
            Kelola Pengembalian
        </a>

        <!-- LAPORAN & LOG -->
        <div class="list-group-item list-group-item-secondary mt-2">
            <b>Laporan</b>
        </div>
        <a href="log.php" class="list-group-item list-group-item-action">
            Log Aktivitas
        </a>

        <!-- LOGOUT -->
        <a href="../auth/logout.php" class="list-group-item list-group-item-danger mt-2">
            Logout
        </a>

    </div>
</div>

</body>
</html>
