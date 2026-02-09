<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}
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
LEFT JOIN detail_peminjaman d ON p.id = d.peminjaman_id
LEFT JOIN alat a ON d.alat_id = a.id
WHERE p.status = 'menunggu_peminjaman'
ORDER BY p.id DESC"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Data Peminjaman (Menunggu Persetujuan)</h3>

    <table class="table table-bordered">
        <tr class="table-dark">
            <th>No</th>
            <th>User</th>
            <th>Nama Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
          
            <th>Aksi</th>
        </tr>

        <?php $no=1; while($p=mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $p['username'] ?></td>
            <td><?= $p['nama_alat'] ?></td>
            <td><?= $p['jumlah'] ?></td>
            <td><?= $p['tgl_pinjam'] ?></td>
            <td><?= $p['tgl_kembali'] ?></td>
           
           <td>
<?php if ($p['status'] == 'menunggu_peminjaman') { ?>
    <a href="setujui.php?id=<?= $p['id'] ?>"
       class="btn btn-success btn-sm"
       onclick="return confirm('Setujui peminjaman ini?')">
       Setujui
    </a>
<?php } else { ?>
    -
<?php } ?>
</td>
     
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
