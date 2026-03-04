<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Data Peminjaman";
include "../assets/layout.php";

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

<h4 class="mb-3">Data Peminjaman</h4>
<a href="peminjaman_tambah.php" class="btn btn-primary mb-3 rounded-pill">+ Tambah Peminjaman</a>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['username']) ?></td>
                        <td><?= htmlspecialchars($r['nama_alat']) ?></td>
                        <td><?= (int)$r['jumlah'] ?></td>
                        <td><?= htmlspecialchars($r['tgl_pinjam']) ?></td>
                        <td><?= $r['tgl_kembali'] ? htmlspecialchars($r['tgl_kembali']) : '-' ?></td>
                        <td>
                            <?php if ($r['status'] == 'kembali'): ?>
                                <span class="badge bg-success">Kembali</span>
                            <?php elseif ($r['status'] == 'dipinjam'): ?>
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= ucfirst($r['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="peminjaman_hapus.php?id=<?= $r['peminjaman_id'] ?>"
                               onclick="return confirm('Hapus data ini?')"
                               class="btn btn-danger btn-sm rounded-pill">
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
