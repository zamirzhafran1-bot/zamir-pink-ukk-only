<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Dashboard Admin";
include "../assets/layout.php";

/* ===================== STATISTIK ===================== */

$jumlah_user = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) total FROM users"))['total'];
$jumlah_alat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) total FROM alat"))['total'];
$jumlah_kategori = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) total FROM kategori"))['total'];
$dipinjam = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) total FROM peminjaman WHERE status='dipinjam'"))['total'];

/* ===================== LOG ===================== */

$log = mysqli_query($koneksi,"
SELECT * FROM log_aktivitas
ORDER BY waktu DESC
LIMIT 5
");
?>

<div class="dashboard-wrapper">

<h4 class="mb-4 fw-bold">🧭Navigation Administrator</h4>

<!-- ================= STAT CARD ================= -->
<div class="row g-4 mb-4">

<?php
$stats = [
["Total User",$jumlah_user,"bi-person-badge-fill","bg-gradient-primary"],
["Total Alat",$jumlah_alat,"bi-gear-wide-connected","bg-gradient-success"],
["Kategori",$jumlah_kategori,"bi-collection-fill","bg-gradient-warning"],
["Dipinjam",$dipinjam,"bi-box-seam-fill","bg-gradient-danger"]
];

foreach($stats as $s):
?>

<div class="col-md-3">
<div class="card dashboard-card stat-card <?= $s[3] ?>">
<i class="bi <?= $s[2] ?> stat-icon"></i>
<h6><?= $s[0] ?></h6>
<h2 class="counter"><?= $s[1] ?></h2>
</div>
</div>

<?php endforeach; ?>

</div>

<!-- ================= MENU ================= -->
<div class="row g-4">

<?php
$menu = [
["Kelola User","Manajemen akun pengguna","bi-person-lines-fill","user.php","btn-primary"],
["Kelola Alat","Inventaris peralatan","bi-tools","alat.php","btn-primary"],
["Kelola Kategori","Data kategori alat","bi-tags-fill","kategori.php","btn-primary"],
["Peminjaman","Mengelola peminjaman","bi-box-arrow-up-right","peminjaman_admin.php","btn-success"],
["Pengembalian","Mengelola pengembalian","bi-arrow-counterclockwise","pengembalian_admin.php","btn-warning"]
];

foreach($menu as $m):
?>

<div class="col-md-4">
<div class="card dashboard-card menu-card">
<i class="bi <?= $m[2] ?> menu-icon"></i>
<h5><?= $m[0] ?></h5>
<p><?= $m[1] ?></p>
<a href="<?= $m[3] ?>" class="btn <?= $m[4] ?> rounded-pill">Buka</a>
</div>
</div>

<?php endforeach; ?>

</div>

<!-- ================= LOG ================= -->
<div class="card dashboard-card p-4 mt-4">
<h5 class="fw-semibold">
<i class="bi bi-clock-history me-2"></i> Aktivitas Terbaru
</h5>


<ul class="timeline">
<?php while($l = mysqli_fetch_assoc($log)): ?>
<li>
<?= $l['aktivitas'] ?>
<br>
<small class="text-muted"><?= $l['waktu'] ?></small>
</li>
<?php endwhile; ?>
</ul>

</div>

</div>


<style>

.dashboard-wrapper{
padding:25px;
}

.dashboard-card{
background: rgba(255,255,255,0.7);
backdrop-filter: blur(18px);
border-radius: 20px;
border: 1px solid rgba(255,255,255,0.3);
transition:0.3s;
}

.dashboard-card:hover{
transform: translateY(-6px);
box-shadow:0 15px 30px rgba(0,0,0,0.15);
}

.stat-card{
position:relative;
padding:25px;
overflow:hidden;
}

.stat-icon{
font-size:45px;
position:absolute;
right:20px;
top:20px;
opacity:0.25;
}

.menu-card{
text-align:center;
padding:25px;
}

.menu-icon{
font-size:40px;
color:#6c5ce7;
margin-bottom:10px;
}

.timeline{
list-style:none;
padding-left:0;
}

.timeline li{
padding:10px 15px;
border-left:4px solid #6c5ce7;
margin-bottom:10px;
background:rgba(255,255,255,0.5);
border-radius:10px;
}

</style>


<script>

/* COUNTER ANIMATION */
document.querySelectorAll('.counter').forEach(counter=>{
let target=parseInt(counter.innerText);
let count=0;

function update(){
count+=Math.ceil(target/40);
if(count<target){
counter.innerText=count;
requestAnimationFrame(update);
}else{
counter.innerText=target;
}
}
update();
});

</script>

<?php include "../assets/layout_footer.php"; ?>
