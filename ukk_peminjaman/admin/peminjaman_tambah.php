<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
 // log aktivitas
 if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    exit;
}
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Menambah peminjaman dari admin";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
$users = mysqli_query($koneksi, "SELECT id, username FROM users WHERE role='peminjam'");
$alat  = mysqli_query($koneksi, "SELECT id, nama_alat, stok FROM alat WHERE status='aktif'");

$title = "Tambah Peminjaman";
include "../assets/layout.php";
?>

<h4 class="mb-3">Tambah Peminjaman</h4>

<div class="card shadow-sm border-0" style="max-width:650px">
    <div class="card-body">
        <form method="post" action="peminjaman_simpan.php">

            <div class="mb-3">
                <label class="form-label">User</label>
                <select name="user_id" class="form-select rounded-pill" required>
                    <option value="">-- Pilih User --</option>
                    <?php while($u=mysqli_fetch_assoc($users)): ?>
                        <option value="<?= $u['id'] ?>">
                            <?= htmlspecialchars($u['username']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Alat</label>
                <select name="alat_id" class="form-select rounded-pill" required>
                    <option value="">-- Pilih Alat --</option>
                    <?php while($a=mysqli_fetch_assoc($alat)): ?>
                        <option value="<?= $a['id'] ?>">
                            <?= htmlspecialchars($a['nama_alat']) ?> (stok: <?= $a['stok'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" min="1"
                       class="form-control rounded-pill" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam"
                       class="form-control rounded-pill" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tgl_kembali"
                       class="form-control rounded-pill" required>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary rounded-pill px-4">Simpan</button>
                <a href="peminjaman_admin.php" class="btn btn-secondary rounded-pill px-4">Kembali</a>
            </div>

        </form>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
