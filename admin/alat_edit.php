<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

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
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Edit Alat</h3>
    <form method="post">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="mb-3">
            <label>Nama Alat</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama_alat'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control">
                <?php while($k=mysqli_fetch_assoc($kategori)): ?>
                    <option value="<?= $k['id'] ?>" <?= $k['id']==$data['kategori_id']?'selected':'' ?>>
                        <?= $k['nama_kategori'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
        </div>

        <button name="update" class="btn btn-warning">Update</button>
        <a href="alat.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
