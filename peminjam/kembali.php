<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') exit;

$user_id = $_SESSION['id_user'];

$data = mysqli_query($koneksi,
"SELECT 
    p.id,
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
WHERE p.user_id = '$user_id'
AND p.status = 'dipinjam'
ORDER BY p.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengembalian Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Pengembalian Alat</h3>

    <table class="table table-bordered">
        <tr class="table-dark">
            <th>No</th>
            <th>User</th>
            <th>Nama Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; while($r=mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['username'] ?></td>
            <td><?= $r['nama_alat'] ?></td>
            <td><?= $r['jumlah'] ?></td>
            <td><?= $r['tgl_pinjam'] ?></td>
            <td><?= $r['tgl_kembali'] ?></td>
            <td><?= $r['status'] ?></td>
            <td>
                <a href="proses_kembali.php?id=<?= $r['id'] ?>"
                   class="btn btn-warning btn-sm"
                   onclick="return confirm('Ajukan pengembalian?')">
                   Ajukan Pengembalian
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
