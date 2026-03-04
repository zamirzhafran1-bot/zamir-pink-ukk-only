<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
 // log aktivitas
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Mengedit kategori";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT * FROM kategori WHERE id='$id'"
));

if (isset($_POST['update'])) {
    mysqli_query($koneksi,
        "UPDATE kategori SET nama_kategori='$_POST[nama]' WHERE id='$id'"
    );
    header("Location: kategori.php");
    exit;
}

$title = "Edit Kategori";
include "../assets/layout.php";
?>

<h4 class="mb-3">Edit Kategori</h4>

<div class="card shadow-sm border-0" style="max-width:500px">
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama" 
                       class="form-control rounded-pill"
                       value="<?= htmlspecialchars($data['nama_kategori']) ?>" required>
            </div>

            <div class="d-flex gap-2">
                <button name="update" class="btn btn-warning rounded-pill px-4">Update</button>
                <a href="kategori.php" class="btn btn-secondary rounded-pill px-4">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
