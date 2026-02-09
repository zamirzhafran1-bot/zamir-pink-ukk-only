<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;
if (isset($_POST['simpan'])) {
    mysqli_query($koneksi,
        "INSERT INTO kategori(nama_kategori) VALUES ('$_POST[nama]')"
    );
    header("Location: kategori.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Tambah Kategori</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button name="simpan" class="btn btn-primary">Simpan</button>
        <a href="kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
