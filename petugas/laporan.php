<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

$dari   = $_GET['dari']   ?? '';
$sampai = $_GET['sampai'] ?? '';

$where = "";
if ($dari && $sampai) {
    $where = "WHERE p.tgl_pinjam BETWEEN '$dari' AND '$sampai'";
}

$data = mysqli_query($koneksi,
    "SELECT 
        p.id AS peminjaman_id,
        u.username,
        a.nama_alat,
        d.jumlah,
        p.tgl_pinjam,
        p.tgl_kembali,
        p.status
     FROM peminjaman p
     JOIN users u ON p.user_id = u.id
     JOIN detail_peminjaman d ON p.id = d.peminjaman_id
     JOIN alat a ON d.alat_id = a.id
     $where
     ORDER BY p.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h3 class="text-center">LAPORAN PEMINJAMAN ALAT</h3>
    <p class="text-center">
        Dicetak oleh Petugas | <?= date('d-m-Y') ?>
    </p>

    <!-- FILTER -->
    <form method="get" class="row g-2 mb-3 no-print">
        <div class="col-md-4">
            <input type="date" name="dari" class="form-control" value="<?= $dari ?>" required>
        </div>
        <div class="col-md-4">
            <input type="date" name="sampai" class="form-control" value="<?= $sampai ?>" required>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary">Filter</button>
            <a href="laporan.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="no-print mb-3 text-center">
        <button onclick="window.print()" class="btn btn-success">
            Cetak Laporan
        </button>
        <a href="dashboard.php" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Alat</th>
                <th>Jumlah Dipinjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        <?php if (mysqli_num_rows($data) == 0): ?>
            <tr>
                <td colspan="7" class="text-center text-muted">
                    Data laporan kosong
                </td>
            </tr>
        <?php endif; ?>

        <?php $no=1; while($l=mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($l['username']) ?></td>
                <td><?= htmlspecialchars($l['nama_alat']) ?></td>
                <td><?= $l['jumlah'] ?></td>
                <td><?= $l['tgl_pinjam'] ?></td>
                <td><?= $l['tgl_kembali'] ?: '-' ?></td>
                <td><?= ucfirst($l['status']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
