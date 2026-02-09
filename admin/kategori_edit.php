<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT * FROM kategori WHERE id='$id'"
));

if (isset($_POST['update'])) {
    mysqli_query($koneksi,
        "UPDATE kategori SET nama_kategori='$_POST[nama]' WHERE id='$id'"
    );
    header("Location: kategori.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Edit Kategori</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama_kategori'] ?>" required>
        </div>
        <button name="update" class="btn btn-warning">Update</button>
        <a href="kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
