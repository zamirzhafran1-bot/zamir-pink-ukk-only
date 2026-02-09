<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}

$alat = mysqli_query($koneksi,
    "SELECT alat.*, kategori.nama_kategori
     FROM alat
     JOIN kategori ON alat.kategori_id = kategori.id
     WHERE alat.status='aktif' AND alat.stok > 0"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pinjam Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Pinjam Alat</h3>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Pengajuan peminjaman berhasil</div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Alat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($a=mysqli_fetch_assoc($alat)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $a['nama_alat'] ?></td>
            <td><?= $a['nama_kategori'] ?></td>
            <td><?= $a['stok'] ?></td>
            <td>
                <button class="btn btn-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#pinjam<?= $a['id'] ?>">
                    Pinjam
                </button>
            </td>
        </tr>

        <!-- Modal -->
        <div class="modal fade" id="pinjam<?= $a['id'] ?>">
            <div class="modal-dialog">
                <form method="post" action="proses_pinjam.php">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pinjam <?= $a['nama_alat'] ?></h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="alat_id" value="<?= $a['id'] ?>">

                            <div class="mb-3">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" class="form-control"
                                       min="1" max="<?= $a['stok'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Tanggal Pinjam</label>
                                <input type="date" name="tgl_pinjam" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Tanggal Kembali</label>
                                <input type="date" name="tgl_kembali" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Ajukan</button>
                            <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php endwhile; ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
