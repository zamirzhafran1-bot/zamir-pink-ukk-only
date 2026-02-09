<?php
session_start();
include "../config/database.php";

if ($_SESSION['role'] != 'admin') exit;

if (isset($_POST['simpan'])) {
    mysqli_query($koneksi,
        "INSERT INTO users (username, password, nama, role)
         VALUES (
            '$_POST[username]',
            '$_POST[password]',
            '$_POST[nama]',
            '$_POST[role]'
         )"
    );
    header("Location: user.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Tambah User</h3>

    <form method="POST">
        <input name="username" class="form-control mb-2" placeholder="Username" required>
        <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
        <input name="nama" class="form-control mb-2" placeholder="Nama" required>

        <select name="role" class="form-control mb-3">
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="peminjam">Peminjam</option>
        </select>

        <button name="simpan" class="btn btn-success">Simpan</button>
        <a href="user.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
