<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}

$today = date("Y-m-d");

$alat = mysqli_query($koneksi,
    "SELECT alat.*, kategori.nama_kategori
     FROM alat
     JOIN kategori ON alat.kategori_id = kategori.id
     WHERE alat.status='aktif' AND alat.stok > 0"
);

$title = "Pinjam Alat";
include "../assets/layout.php";
?>

<h4 class="mb-4 fw-bold">📦 Pinjam Alat</h4>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success rounded-4 shadow-sm">
    ✅ Pengajuan peminjaman berhasil dikirim
</div>
<?php endif; ?>

<div class="row g-4">

<?php while($a = mysqli_fetch_assoc($alat)): ?>
<div class="col-md-4">

    <div class="card alat-card border-0 h-100">

        <div class="card-body d-flex flex-column">

            <span class="badge bg-gradient mb-2">
                🏷 <?= $a['nama_kategori'] ?>
            </span>

            <h5 class="fw-semibold mb-2"><?= $a['nama_alat'] ?></h5>

            <div class="stok-box mb-3">
                📦 Stok tersedia :
                <span class="fw-bold"><?= $a['stok'] ?></span>
            </div>

            <button class="btn btn-primary rounded-pill mt-auto"
                data-bs-toggle="modal"
                data-bs-target="#pinjam<?= $a['id'] ?>">
                Pinjam Sekarang →
            </button>

        </div>
    </div>

</div>

<!-- MODAL -->
<div class="modal fade" id="pinjam<?= $a['id'] ?>" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<form method="post" action="proses_pinjam.php" class="modal-content border-0 rounded-4 shadow-lg">

<div class="modal-header bg-light border-0">
    <h5 class="fw-bold">
        📦 Pinjam <?= $a['nama_alat'] ?>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" name="alat_id" value="<?= $a['id'] ?>">

<div class="info-alat mb-3 p-3 rounded-3">
    <small class="text-muted">Kategori</small>
    <div class="fw-semibold"><?= $a['nama_kategori'] ?></div>

    <small class="text-muted">Stok tersedia</small>
    <div class="fw-semibold"><?= $a['stok'] ?></div>
</div>

<div class="mb-3">
    <label class="form-label">Jumlah</label>
    <input type="number"
        name="jumlah"
        class="form-control rounded-pill"
        min="1"
        max="<?= $a['stok'] ?>"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Pinjam</label>
    <input type="date"
        name="tgl_pinjam"
        class="form-control rounded-pill bg-light"
        value="<?= $today ?>"
        readonly>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Kembali</label>
    <input type="date"
        name="tgl_kembali"
        class="form-control rounded-pill"
        min="<?= $today ?>"
        required>
</div>

</div>

<div class="modal-footer border-0">
    <button class="btn btn-primary rounded-pill px-4">
        Ajukan Peminjaman
    </button>

    <button type="button"
        class="btn btn-secondary rounded-pill px-4"
        data-bs-dismiss="modal">
        Batal
    </button>
</div>

</form>
</div>
</div>

<?php endwhile; ?>

</div>

<style>

.alat-card{
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(18px);
    border-radius: 20px;
    transition: 0.3s;
}

.alat-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.badge.bg-gradient{
    background: linear-gradient(45deg,#6c5ce7,#ff7eb3);
    font-size: 13px;
    padding: 6px 10px;
    color: #000 !important;
}



.stok-box{
    background: rgba(108,92,231,0.1);
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 14px;
}

.info-alat{
    background: rgba(0,0,0,0.04);
}

</style>

<?php include "../assets/layout_footer.php"; ?>
