<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori");

if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama'];
    $kategori_id = $_POST['kategori'];
    $stok     = $_POST['stok'];

    mysqli_query($koneksi,
        "INSERT INTO alat (nama_alat, kategori_id, stok)
         VALUES ('$nama', '$kategori_id', '$stok')"
    );

    // Log aktivitas
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Menambahkan alat: $nama";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );

    header("Location: alat.php?msg=added");
    exit;
}

$title = "Tambah Alat";
$active = "alat";
include "../assets/layout.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold">➕ Tambah Alat</h4>
    <a href="alat.php" class="btn btn-outline-secondary btn-sm rounded-pill">
        ← Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Alat</label>
                <input type="text" name="nama" class="form-control rounded-3" placeholder="Contoh: Laptop Asus" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="kategori" class="form-select rounded-3" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php while($k=mysqli_fetch_assoc($kategori)): ?>
                        <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Stok</label>
                <input type="number" name="stok" min="0" class="form-control rounded-3" placeholder="0" required>
            </div>

            <div class="d-flex gap-2">
                <button name="simpan" class="btn btn-primary rounded-pill px-4">
                    💾 Simpan
                </button>
                <a href="alat.php" class="btn btn-outline-secondary rounded-pill px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
