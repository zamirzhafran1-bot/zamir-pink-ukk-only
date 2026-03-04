<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') exit;


/* ===== FILTER ===== */
$status = $_GET['status'] ?? 'menunggu_peminjaman';
$mulai  = $_GET['mulai'] ?? '';
$akhir  = $_GET['akhir'] ?? '';

$where = "WHERE p.status='$status'";
if ($mulai) $where .= " AND p.tgl_pinjam >= '$mulai'";
if ($akhir) $where .= " AND p.tgl_pinjam <= '$akhir'";

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
$where
ORDER BY p.id DESC"
);

$title = "Persetujuan Peminjaman";
include "../assets/layout.php";
?>

<h4 class="mb-3 fw-bold">✅ Persetujuan Peminjaman</h4>

<!-- FILTER -->
<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select rounded-pill">
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

<!-- TABLE -->
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(mysqli_num_rows($data)==0): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                <?php endif; ?>

                <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['username']) ?></td>
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
                        <td>
                            <?php if($r['status']=='menunggu_peminjaman'): ?>
                                <a href="setujui.php?id=<?= $r['id'] ?>"
                                   class="btn btn-success btn-sm rounded-pill"
                                   onclick="return confirm('Setujui peminjaman?')">
                                   Setujui
                                </a>
                                <a href="tolak.php?id=<?= $r['id'] ?>"
                                   class="btn btn-danger btn-sm rounded-pill"
                                   onclick="return confirm('Tolak peminjaman ini?')">
                                   Tolak
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="dashboard.php" class="btn btn-secondary rounded-pill mt-3">
            ← Kembali
        </a>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
