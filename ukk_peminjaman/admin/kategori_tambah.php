<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
 // log aktivitas
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Menambah kategori";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
if (isset($_POST['simpan'])) {
    mysqli_query($koneksi,
        "INSERT INTO kategori(nama_kategori) VALUES ('$_POST[nama]')"
    );
    header("Location: kategori.php");
    exit;
}

$title = "Tambah Kategori";
$active = "kategori";
include "../assets/layout.php";
?>

<h4 class="mb-3">Tambah Kategori</h4>

<div class="card shadow-sm border-0" style="max-width:500px">
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama" class="form-control rounded-pill" required>
            </div>

            <div class="d-flex gap-2">
                <button name="simpan" class="btn btn-primary rounded-pill px-4">Simpan</button>
                <a href="kategori.php" class="btn btn-secondary rounded-pill px-4">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
