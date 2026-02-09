<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
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
     ORDER BY p.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Data Peminjaman (Admin)</h3>

    <a href="peminjaman_tambah.php" class="btn btn-primary mb-3">
        + Tambah Peminjaman
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Nama Alat</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['username']) ?></td>
                <td><?= htmlspecialchars($r['nama_alat']) ?></td>
                <td><?= $r['jumlah'] ?></td>
                <td><?= $r['tgl_pinjam'] ?></td>
                <td><?= $r['tgl_kembali'] ?: '-' ?></td>
                <td><?= ucfirst($r['status']) ?></td>
                <td>
                    <a href="peminjaman_hapus.php?id=<?= $r['peminjaman_id'] ?>"
                       onclick="return confirm('Hapus data ini?')"
                       class="btn btn-danger btn-sm">
                       Hapus
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
