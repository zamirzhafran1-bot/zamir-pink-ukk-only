<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['id_user'];

/* ===== HITUNG PINJAMAN AKTIF ===== */
$qAktif = mysqli_query($koneksi,
"SELECT COUNT(*) AS total
 FROM peminjaman
 WHERE user_id='$user_id' AND status='dipinjam'"
);
$aktif = mysqli_fetch_assoc($qAktif)['total'];

/* ===== FILTER ===== */
$status = $_GET['status'] ?? '';
$mulai  = $_GET['mulai'] ?? '';
$akhir  = $_GET['akhir'] ?? '';

$where = "WHERE p.user_id='$user_id'";
if ($status != '') $where .= " AND p.status='$status'";
if ($mulai != '')  $where .= " AND p.tgl_pinjam >= '$mulai'";
if ($akhir != '')  $where .= " AND p.tgl_pinjam <= '$akhir'";

/* ===== DATA RINGKAS ===== */
$data = mysqli_query($koneksi,
"SELECT p.*, a.nama_alat, d.jumlah
 FROM peminjaman p
 JOIN detail_peminjaman d ON p.id = d.peminjaman_id
 JOIN alat a ON d.alat_id = a.id
 $where
 ORDER BY p.id DESC
 LIMIT 5"
);

$title = "Dashboard Peminjam";
include "../assets/layout.php";
?>

<div class="dashboard-wrapper">

<h4 class="mb-4 fw-bold">🧭 Navigation Peminjam</h4>

<!-- ===== STAT ===== -->
<div class="row g-4 mb-4">

<div class="col-md-4">
<div class="card dashboard-card stat-card">
<i class="bi bi-box-seam menu-icon"></i>
<h6>Pinjaman Aktif</h6>
<h2 class="counter"><?= $aktif ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card dashboard-card menu-card">
<i class="bi bi-journal-plus menu-icon"></i>
<h5>Ajukan Peminjaman</h5>
<a href="pinjam.php" class="btn btn-primary rounded-pill">Buka</a>
</div>
</div>

<div class="col-md-4">
<div class="card dashboard-card menu-card">
<i class="bi bi-arrow-counterclockwise menu-icon"></i>
<h5>Pengembalian</h5>
<a href="kembali.php" class="btn btn-primary rounded-pill">Buka</a>
</div>
</div>

</div>


<!-- ===== FILTER ===== -->
<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select rounded-pill">
                    <option value="">Semua</option>
                    <option value="menunggu_peminjaman" <?= $status=='menunggu_peminjaman'?'selected':'' ?>>Menunggu</option>
                    <option value="dipinjam" <?= $status=='dipinjam'?'selected':'' ?>>Dipinjam</option>
                    <option value="menunggu_pengembalian" <?= $status=='menunggu_pengembalian'?'selected':'' ?>>Menunggu Kembali</option>
                    <option value="selesai" <?= $status=='selesai'?'selected':'' ?>>Selesai</option>
                    <option value="ditolak" <?= $status=='ditolak'?'selected':'' ?>>Ditolak</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Dari</label>
                <input type="date" name="mulai" value="<?= $mulai ?>" class="form-control rounded-pill">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sampai</label>
                <input type="date" name="akhir" value="<?= $akhir ?>" class="form-control rounded-pill">
            </div>

            <div class="col-md-2 d-grid">
                <button class="btn btn-primary rounded-pill">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== RIWAYAT SINGKAT ===== -->
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">📜 Riwayat Terbaru</h6>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
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

        <a href="riwayat.php" class="btn btn-secondary rounded-pill mt-2">
            Lihat Semua Riwayat →
        </a>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
