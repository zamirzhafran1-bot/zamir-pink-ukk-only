<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    exit;
}

$user_id = $_SESSION['id_user'];

$data = mysqli_query($koneksi,
    "SELECT p.*, a.nama_alat, d.jumlah
     FROM peminjaman p
     JOIN detail_peminjaman d ON p.id = d.peminjaman_id
     JOIN alat a ON d.alat_id = a.id
     WHERE p.user_id = '$user_id'
     ORDER BY p.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Riwayat Peminjaman</h3>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
        </tr>

        <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($r['nama_alat']) ?></td>
            <td><?= $r['jumlah'] ?></td>
            <td><?= $r['tgl_pinjam'] ?></td>
            <td><?= $r['tgl_kembali'] ?></td>
            <td>
                <span class="badge bg-info">
                    <?= $r['status'] ?>
                </span>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
