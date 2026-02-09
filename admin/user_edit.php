<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'"));

if (isset($_POST['update'])) {
    mysqli_query($koneksi,
        "UPDATE users SET
            username='$_POST[username]',
            password='$_POST[password]',
            nama='$_POST[nama]',
            role='$_POST[role]'
         WHERE id='$id'"
    );
    header("Location: user.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Edit User</h3>

    <form method="POST">
        <input name="username" value="<?= $data['username'] ?>" class="form-control mb-2">
        <input name="password" value="<?= $data['password'] ?>" class="form-control mb-2">
        <input name="nama" value="<?= $data['nama'] ?>" class="form-control mb-2">

        <select name="role" class="form-control mb-3">
            <option value="admin" <?= $data['role']=='admin'?'selected':'' ?>>Admin</option>
            <option value="petugas" <?= $data['role']=='petugas'?'selected':'' ?>>Petugas</option>
            <option value="peminjam" <?= $data['role']=='peminjam'?'selected':'' ?>>Peminjam</option>
        </select>

        <button name="update" class="btn btn-warning">Update</button>
        <a href="user.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
