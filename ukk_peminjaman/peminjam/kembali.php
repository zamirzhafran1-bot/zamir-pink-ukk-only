<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['id_user'];

$data = mysqli_query($koneksi,
"SELECT 
    p.id,
    u.username,
    a.nama_alat,
    d.jumlah,
    p.tgl_pinjam,
    p.status
FROM peminjaman p
JOIN users u ON p.user_id = u.id
JOIN detail_peminjaman d ON p.id = d.peminjaman_id
JOIN alat a ON d.alat_id = a.id
WHERE p.user_id = '$user_id'
AND p.status = 'dipinjam'
ORDER BY p.id DESC"
);

$title = "Pengembalian Alat";
include "../assets/layout.php";
?>

<h4 class="mb-3 fw-bold">🔄 Pengembalian Alat</h4>

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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['nama_alat']) ?></td>
                        <td><?= $r['jumlah'] ?></td>
                        <td><?= $r['tgl_pinjam'] ?></td>
                        <td>
                            <span class="badge rounded-pill bg-primary">
                                <?= str_replace('_',' ', $r['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="proses_kembali.php?id=<?= $r['id'] ?>"
                               class="btn btn-success btn-sm rounded-pill"
                               onclick="return confirm('Kembalikan alat sekarang?')">
                               ✔ Kembalikan
                            </a>
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
