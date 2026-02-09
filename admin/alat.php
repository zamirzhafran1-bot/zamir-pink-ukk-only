<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}

$data = mysqli_query($koneksi,
    "SELECT alat.*, kategori.nama_kategori
     FROM alat 
     JOIN kategori ON alat.kategori_id = kategori.id
     ORDER BY alat.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Data Alat</h3>
    <a href="alat_tambah.php" class="btn btn-primary mb-3">Tambah Alat</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
                <th width="260">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_alat']) ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td><?= $row['stok'] ?></td>

                <!-- STATUS -->
                <td>
                    <?php if ($row['status'] == 'aktif') { ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php } else { ?>
                        <span class="badge bg-secondary">Nonaktif</span>
                    <?php } ?>
                </td>

                <!-- AKSI -->
                <td>
                    <a href="alat_edit.php?id=<?= $row['id'] ?>" 
                       class="btn btn-warning btn-sm">Edit</a>

                    <?php if ($row['status'] == 'aktif') { ?>
                        <!-- SOFT DELETE -->
                        <a href="alat_nonaktif.php?id=<?= $row['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Nonaktifkan alat ini?')">
                           Nonaktifkan
                        </a>
                    <?php } else { ?>
                        <!-- AKTIFKAN -->
                        <a href="alat_aktifkan.php?id=<?= $row['id'] ?>" 
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Aktifkan kembali alat ini?')">
                           Aktifkan
                        </a>

                        <!-- HARD DELETE -->
                        <a href="alat_hapus_permanen.php?id=<?= $row['id'] ?>" 
                           class="btn btn-outline-danger btn-sm"
                           onclick="return confirm('HAPUS PERMANEN alat ini? Data tidak bisa dikembalikan!')">
                           Hapus
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
