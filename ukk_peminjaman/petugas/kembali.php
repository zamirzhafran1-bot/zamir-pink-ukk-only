<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

/*
 STATUS:
 - menunggu : peminjam ajukan pengembalian
 - selesai  : pengembalian sudah disetujui admin
*/

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
     WHERE p.status IN ('menunggu','selesai')
     ORDER BY p.id DESC"
);

$title = "Monitoring Pengembalian";
include "../assets/layout.php";
?>

<h4 class="mb-3">🖥️ Monitoring Pengembalian</h4>
<p class="text-muted">Pantau alat yang sedang dikembalikan oleh peminjam.</p>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($data) == 0): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data pengembalian</td>
                </tr>
            <?php endif; ?>

            <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($r['username']) ?></td>
                    <td><?= htmlspecialchars($r['nama_alat']) ?></td>
                    <td><?= $r['jumlah'] ?></td>
                    <td><?= $r['tgl_pinjam'] ?></td>
                    <td><?= $r['tgl_kembali'] ?: '-' ?></td>
                    <td>
                        <?php if ($r['status'] == 'menunggu'): ?>
                            <span class="badge bg-warning text-dark">Menunggu Persetujuan Admin</span>
                        <?php else: ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary rounded-pill px-4">Kembali</a>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
