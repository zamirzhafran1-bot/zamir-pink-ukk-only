<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Data Alat";
include "../assets/layout.php";

$data = mysqli_query($koneksi,
    "SELECT alat.*, kategori.nama_kategori
     FROM alat 
     JOIN kategori ON alat.kategori_id = kategori.id
     ORDER BY alat.id DESC"
);
?>

<h4 class="mb-3">Data Alat</h4>
<a href="alat_tambah.php" class="btn btn-primary mb-3 rounded-pill">+ Tambah Alat</a>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
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
                        <td><?= (int)$row['stok'] ?></td>

                        <!-- STATUS -->
                        <td>
                            <?php if ($row['status'] == 'aktif'): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>

                        <!-- AKSI -->
                        <td class="d-flex gap-1 flex-wrap">
                            <a href="alat_edit.php?id=<?= $row['id'] ?>" 
                               class="btn btn-warning btn-sm rounded-pill">Edit</a>

                            <?php if ($row['status'] == 'aktif'): ?>
                                <!-- SOFT DELETE -->
                                <a href="alat_nonaktif.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-danger btn-sm rounded-pill"
                                   onclick="return confirm('Nonaktifkan alat ini?')">
                                   Nonaktifkan
                                </a>
                            <?php else: ?>
                                <!-- AKTIFKAN -->
                                <a href="alat_aktifkan.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-success btn-sm rounded-pill"
                                   onclick="return confirm('Aktifkan kembali alat ini?')">
                                   Aktifkan
                                </a>

                                <!-- HARD DELETE -->
                                <a href="alat_hapus_permanen.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-pill"
                                   onclick="return confirm('HAPUS PERMANEN alat ini? Data tidak bisa dikembalikan!')">
                                   Hapus
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
