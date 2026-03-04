<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= $title ?? 'Dashboard' ?></title>
<link rel="stylesheet" href="../assets/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    display:flex;
    min-height:100vh;
    background:linear-gradient(135deg,#ff9a9e,#fad0c4,#fbc2eb,#a6c1ee);
    background-size:300% 300%;
    animation:gradientMove 12s ease infinite;
}
.nav-link span:first-child{
    width:26px;
    display:inline-flex;
    justify-content:center;
    align-items:center;
}

.nav-link img.emoji{
    width:20px;
    height:20px;
}

@keyframes gradientMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.sidebar{
    width:260px;
    backdrop-filter:blur(15px);
    background:rgba(255,255,255,0.25);
    border-right:1px solid rgba(255,255,255,0.4);
    transition:0.3s;
}

.sidebar.collapsed{
    width:80px;
}

.sidebar.collapsed .menu-text{
    display:none;
}
.user-box {
            background: rgba(255,255,255,0.03);
            border-radius: 12px;
            padding: 15px;
            margin: 15px;
            text-align: center;
            }
.sidebar .nav-link{
    color:#2d3436;
    padding:12px 20px;
    border-radius:12px;
    margin:4px 10px;
    display:flex;
    gap:10px;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active{
    background:linear-gradient(45deg,#ff7eb3,#6c5ce7);
    color:white;
}

.content{
    flex:1;
    padding:25px;
}

.toggle-btn{
    border:none;
    background:none;
    font-size:22px;
}
/* ===== PRINT STYLE ===== */

.kop-print{
    display:none;
}

@media print{

    body{
        background:white !important;
        animation:none !important;
    }

    /* tampilkan kop */
    .kop-print{
        display:block !important;
    }

    /* sembunyikan sidebar */
    .sidebar{
        display:none !important;
    }

    /* sembunyikan area filter */
    .filter-area{
        display:none !important;
    }

    /* sembunyikan tombol */
    .tombol-area{
        display:none !important;
    }

    /* sembunyikan judul web */
    .judul-web{
        display:none !important;
    }

    /* full content */
    .content{
        margin:0 !important;
        padding:20px !important;
        width:100% !important;
    }

    .card{
        border:none !important;
        box-shadow:none !important;
    }

    table{
        width:100% !important;
        border-collapse:collapse !important;
    }

    th, td{
        border:1px solid black !important;
    }

}
.ttd-print{
    display:none;
}

@media print{

    .ttd-print{
        display:block !important;
    }

    .kop-print table{
        font-size:14px;
    }

}


</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

<div class="d-flex align-items-center px-3 pt-3">
    <img src="../assets/smk.png" width="40">
    <span class="ms-2 fw-bold menu-text">PEMINJAMAN APP</span>

    <button class="toggle-btn ms-auto" id="toggleSidebarBtn">
        <i class="bi bi-list"></i>
    </button>
</div>
<div class="user-box">
 <span>👥</span>
       <span class="menu-text"> <h6 class="mb-0"><?= $_SESSION['nama'] ?? 'User' ?></h6>
        <small class="text-secondary text-uppercase"><?= $_SESSION['role'] ?? '' ?></small></span>
    </div>
<nav class="nav flex-column px-2 mt-4">

<!-- ===== ADMIN ===== -->
<?php if ($role == 'admin'): ?>

<a href="dashboard.php" class="nav-link <?= $currentPage=='dashboard.php'?'active':'' ?>">
<span>📊</span>
<span class="menu-text">Dashboard</span>
</a>

<a href="user.php" class="nav-link <?= $currentPage=='user.php'?'active':'' ?>">
<span>👥</span>
<span class="menu-text">User</span>
</a>

<a href="alat.php" class="nav-link <?= $currentPage=='alat.php'?'active':'' ?>">
<span>🛠️</span>
<span class="menu-text">Alat</span>
</a>

<a href="kategori.php" class="nav-link <?= $currentPage=='kategori.php'?'active':'' ?>">
<span>🏷️</span>
<span class="menu-text">Kategori</span>
</a>

<a href="peminjaman_admin.php" class="nav-link <?= $currentPage=='peminjaman_admin.php'?'active':'' ?>">
<span>📤</span>
<span class="menu-text">Peminjaman</span>
</a>

<a href="pengembalian_admin.php" class="nav-link <?= $currentPage=='pengembalian_admin.php'?'active':'' ?>">
<span>📥</span>
<span class="menu-text">Pengembalian</span>
</a>

<a href="log.php" class="nav-link <?= $currentPage=='log.php'?'active':'' ?>">
<span>🧾</span>
<span class="menu-text">Log Aktivitas</span>
</a>


<?php endif; ?>


<!-- ===== PETUGAS ===== -->
<?php if ($role == 'petugas'): ?>

<a href="dashboard.php" class="nav-link <?= $currentPage=='dashboard.php'?'active':'' ?>">
<span>📊</span>
<span class="menu-text">Dashboard</span>
</a>

<a href="peminjaman.php" class="nav-link <?= $currentPage=='peminjaman.php'?'active':'' ?>">
<span>✅</span>
<span class="menu-text">Peminjam</span>
</a>

<a href="kembali.php" class="nav-link <?= $currentPage=='kembali.php'?'active':'' ?>">
<span>🖥️</span>
<span class="menu-text">Pengembalian</span>
</a>

<a href="laporan.php" class="nav-link <?= $currentPage=='laporan.php'?'active':'' ?>">
<span>📑</span>
<span class="menu-text">Laporan</span>
</a>


<?php endif; ?>


<!-- ===== PEMINJAM ===== -->
<?php if ($role == 'peminjam'): ?>
<a href="dashboard.php" class="nav-link <?= $currentPage=='dashboard.php'?'active':'' ?>">
<span>📊</span>
<span class="menu-text">Dashboard</span>
</a>

<a href="pinjam.php" class="nav-link <?= $currentPage=='pinjam.php'?'active':'' ?>">
<span>📦</span>
<span class="menu-text">Pinjam Alat</span>
</a>

<a href="kembali.php" class="nav-link <?= $currentPage=='kembali.php'?'active':'' ?>">
<span>🔄</span>
<span class="menu-text">Pengembalian</span>
</a>

<a href="riwayat.php" class="nav-link <?= $currentPage=='riwayat.php'?'active':'' ?>">
<span>📋</span>
<span class="menu-text">Riwayat</span>
</a>


<?php endif; ?>

<hr>

<a href="../auth/logout.php" class="nav-link text-danger">
<i class="bi bi-box-arrow-right"></i>
<span class="menu-text">Logout</span>
</a>

</nav>
</div>

<!-- CONTENT -->
<div class="content">
