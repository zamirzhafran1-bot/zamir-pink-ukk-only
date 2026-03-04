<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM alat WHERE id='$id'"));
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori");

if (isset($_POST['update'])) {
    mysqli_query($koneksi,
        "UPDATE alat SET
            nama_alat='$_POST[nama]',
            kategori_id='$_POST[kategori]',
            stok='$_POST[stok]'
         WHERE id='$id'"
    );
    header("Location: alat.php");
    exit;
}
 // log aktivitas
 if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Mengedit alat: $nama";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
$title = "Edit Alat";
$active = "alat";
include "../assets/layout.php";
?>

<h4 class="mb-3">Edit Alat</h4>

<div class="card shadow-sm border-0" style="max-width:600px">
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nama Alat</label>
                <input type="text" name="nama" class="form-control rounded-pill"
                       value="<?= htmlspecialchars($data['nama_alat']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select rounded-pill" required>
                    <?php while($k=mysqli_fetch_assoc($kategori)): ?>
                        <option value="<?= $k['id'] ?>"
                            <?= $k['id']==$data['kategori_id']?'selected':'' ?>>
                            <?= htmlspecialchars($k['nama_kategori']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control rounded-pill"
                       value="<?= (int)$data['stok'] ?>" required>
            </div>

            <div class="d-flex gap-2">
                <button name="update" class="btn btn-warning rounded-pill px-4">Update</button>
                <a href="alat.php" class="btn btn-secondary rounded-pill px-4">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
