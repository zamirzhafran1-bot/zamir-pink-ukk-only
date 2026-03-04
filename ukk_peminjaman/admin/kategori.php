<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Data Kategori";
include "../assets/layout.php";

$data = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
?>

<h4 class="mb-3">Data Kategori</h4>
<a href="kategori_tambah.php" class="btn btn-primary mb-3 rounded-pill">+ Tambah Kategori</a>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                        <td class="d-flex gap-1 flex-wrap">
                            <a href="kategori_edit.php?id=<?= $row['id'] ?>" 
                               class="btn btn-warning btn-sm rounded-pill">Edit</a>
                            <a href="kategori_hapus.php?id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm rounded-pill"
                               onclick="return confirm('Hapus kategori?')">
                               Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
