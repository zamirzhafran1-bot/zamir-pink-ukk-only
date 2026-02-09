<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori");

if (isset($_POST['simpan'])) {
    mysqli_query($koneksi,
        "INSERT INTO alat(nama_alat,kategori_id,stok)
         VALUES ('$_POST[nama]','$_POST[kategori]','$_POST[stok]')"
    );
    header("Location: alat.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Tambah Alat</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama Alat</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
                <?php while($k=mysqli_fetch_assoc($kategori)): ?>
                    <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>

        <button name="simpan" class="btn btn-primary">Simpan</button>
        <a href="alat.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
