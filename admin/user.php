<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Kelola User</h3>

    <a href="user_tambah.php" class="btn btn-primary mb-3">Tambah User</a>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; while($u = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $u['username'] ?></td>
            <td><?= $u['nama'] ?></td>
            <td><?= $u['role'] ?></td>
            <td>
                <a href="user_edit.php?id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="user_hapus.php?id=<?= $u['id'] ?>"
                   onclick="return confirm('Yakin hapus user?')"
                   class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
