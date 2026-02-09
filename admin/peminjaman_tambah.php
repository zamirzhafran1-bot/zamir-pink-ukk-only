<?php
session_start();
include "../config/database.php";
if ($_SESSION['role'] != 'admin') exit;

$users = mysqli_query($koneksi, "SELECT id, username FROM users WHERE role='peminjam'");
$alat  = mysqli_query($koneksi, "SELECT id, nama_alat, stok FROM alat WHERE status='aktif'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Tambah Peminjaman (Admin)</h3>

    <form method="post" action="peminjaman_simpan.php">
        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                <?php while($u=mysqli_fetch_assoc($users)) { ?>
                <option value="<?= $u['id'] ?>"><?= $u['username'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Alat</label>
            <select name="alat_id" class="form-control" required>
                <option value="">-- Pilih Alat --</option>
                <?php while($a=mysqli_fetch_assoc($alat)) { ?>
                <option value="<?= $a['id'] ?>">
                    <?= $a['nama_alat'] ?> (stok: <?= $a['stok'] ?>)
                </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tgl_pinjam" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="peminjaman_admin.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
