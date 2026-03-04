<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

/* ===== HITUNG DATA ===== */
$pending = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT COUNT(*) AS total FROM peminjaman WHERE status='menunggu_peminjaman'"
))['total'];

$dipinjam = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT COUNT(*) AS total FROM peminjaman WHERE status='dipinjam'"
))['total'];

$title = "Dashboard Petugas";
include "../assets/layout.php";
?>
<div class="dashboard-wrapper">

<h4 class="mb-4 fw-bold">🧭 Navigation Petugas</h4>

<div class="row g-4 mb-4">

<div class="col-md-4">
<div class="card dashboard-card menu-card">
<i class="bi bi-hourglass-split menu-icon"></i>
<h6>Menunggu Persetujuan</h6>
<h2 class="counter"><?= $pending ?></h2>
<a href="peminjaman.php" class="btn btn-primary rounded-pill mt-2">Buka</a>
</div>
</div>

<div class="col-md-4">
<div class="card dashboard-card menu-card">
<i class="bi bi-box menu-icon"></i>
<h6>Sedang Dipinjam</h6>
<h2 class="counter"><?= $dipinjam ?></h2>
<a href="kembali.php" class="btn btn-primary rounded-pill mt-2">Monitoring</a>
</div>
</div>

<div class="col-md-4">
<div class="card dashboard-card menu-card">
<i class="bi bi-file-earmark-text menu-icon"></i>
<h5>Laporan</h5>
<a href="laporan.php" class="btn btn-primary rounded-pill">Cetak</a>
</div>
</div>

</div>


<?php include "../assets/layout_footer.php"; ?>
