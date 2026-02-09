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
        p.status
     FROM peminjaman p
     JOIN users u ON p.user_id = u.id
     JOIN detail_peminjaman d ON p.id = d.peminjaman_id
     JOIN alat a ON d.alat_id = a.id
     WHERE p.status = 'menunggu_pengembalian'
     ORDER BY p.id DESC"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Persetujuan Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Pengajuan Pengembalian</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Nama Alat</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php if (mysqli_num_rows($data) == 0): ?>
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Tidak ada pengajuan pengembalian
                </td>
            </tr>
        <?php endif; ?>

        <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['username']) ?></td>
                <td><?= htmlspecialchars($r['nama_alat']) ?></td>
                <td><?= $r['jumlah'] ?></td>
                <td><?= $r['tgl_pinjam'] ?></td>
                <td><?= $r['status'] ?></td>

                <td>
                    <a href="setujui_kembali.php?id=<?= $r['peminjaman_id'] ?>"
                       class="btn btn-success btn-sm"
                       onclick="return confirm('Setujui pengembalian alat?')">
                       Setujui
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
