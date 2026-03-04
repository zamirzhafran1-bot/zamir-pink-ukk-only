<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
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

$title = "Riwayat Peminjaman";
include "../assets/layout.php";
?>

<h4 class="mb-3 fw-bold">📜 Riwayat Peminjaman</h4>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['nama_alat']) ?></td>
                        <td><?= $r['jumlah'] ?></td>
                        <td><?= $r['tgl_pinjam'] ?></td>
                        <td><?= $r['tgl_kembali'] ?></td>
                        <td>
                            <?php
                            $badge = match($r['status']) {
                                'menunggu_peminjaman' => 'warning',
                                'dipinjam' => 'primary',
                                'menunggu_pengembalian' => 'info',
                                'selesai' => 'success',
                                'ditolak' => 'danger',
                                default => 'secondary'
                            };
                            ?>
                            <span class="badge rounded-pill bg-<?= $badge ?>">
                                <?= str_replace('_',' ', $r['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="dashboard.php" class="btn btn-secondary rounded-pill mt-2">← Kembali</a>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
