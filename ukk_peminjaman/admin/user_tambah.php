<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// ======================
// PROSES SIMPAN (HARUS DI ATAS)
// ======================
if (isset($_POST['simpan'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $role     = $_POST['role'];

    mysqli_query($koneksi,
        "INSERT INTO users (username, password, nama, role)
         VALUES ('$username', '$password', '$nama', '$role')"
    );

    header("Location: user.php?msg=added");
    exit;
}

// ======================
// BARU LOAD LAYOUT
// ======================
$title = "Tambah User";
include "../assets/layout.php";
?>

<h4 class="mb-4">➕ Tambah User</h4>

<div class="card shadow-sm border-0 col-md-6">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input name="nama" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="peminjam">Peminjam</option>
                </select>
            </div>

            <button name="simpan" class="btn btn-success rounded-pill px-4">💾 Simpan</button>
            <a href="user.php" class="btn btn-secondary rounded-pill px-4">↩ Kembali</a>
        </form>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
