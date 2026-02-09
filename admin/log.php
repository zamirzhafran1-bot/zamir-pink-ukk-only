<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($koneksi,
    "SELECT l.*, u.username
     FROM log_aktivitas l
     LEFT JOIN users u ON l.user_id = u.id
     ORDER BY l.waktu DESC"
);

if (!$data) {
    die(mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Log Aktivitas Sistem</h3>

    <table class="table table-bordered table-striped">
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Aktivitas</th>
            <th>Waktu</th>
        </tr>

        <?php $no=1; while($l = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $l['username'] ?? '-' ?></td>
            <td><?= $l['aktivitas'] ?></td>
            <td><?= $l['waktu'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
