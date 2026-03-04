<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Data User";
include "../assets/layout.php";

$data = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
?>

<h4 class="mb-3">Data User</h4>
<a href="user_tambah.php" class="btn btn-primary mb-3 rounded-pill">+ Tambah User</a>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($u = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['nama']) ?></td>
                        <td>
                            <span class="badge bg-info text-dark text-uppercase">
                                <?= htmlspecialchars($u['role']) ?>
                            </span>
                        </td>
                        <td class="d-flex gap-1 flex-wrap">
                            <a href="user_edit.php?id=<?= $u['id'] ?>"
                               class="btn btn-warning btn-sm rounded-pill">Edit</a>
                            <a href="user_hapus.php?id=<?= $u['id'] ?>"
                               onclick="return confirm('Yakin hapus user?')"
                               class="btn btn-danger btn-sm rounded-pill">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
