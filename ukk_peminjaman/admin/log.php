<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Log Aktivitas";
include "../assets/layout.php";

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

<h4 class="mb-3">Log Aktivitas Sistem</h4>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($l = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($l['username'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($l['aktivitas']) ?></td>
                        <td><?= htmlspecialchars($l['waktu']) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
