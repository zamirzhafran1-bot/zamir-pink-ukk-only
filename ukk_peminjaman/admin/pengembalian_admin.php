<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Kelola Pengembalian";
include "../assets/layout.php";

$data = mysqli_query($koneksi,
"SELECT 
    p.id,
    u.username,
    a.nama_alat,
    d.jumlah,
    p.tgl_pinjam,
    p.status
FROM peminjaman p
JOIN users u ON p.user_id = u.id
JOIN detail_peminjaman d ON p.id = d.peminjaman_id
JOIN alat a ON d.alat_id = a.id
WHERE p.status = 'dipinjam'
ORDER BY p.id DESC"
);
?>

<h4 class="mb-3">Kelola Pengembalian</h4>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['username']) ?></td>
                        <td><?= htmlspecialchars($r['nama_alat']) ?></td>
                        <td><?= (int)$r['jumlah'] ?></td>
                        <td><?= htmlspecialchars($r['tgl_pinjam']) ?></td>
                        <td>
                            <a href="kembalikan_langsung.php?id=<?= $r['id'] ?>"
                               class="btn btn-warning btn-sm rounded-pill"
                               onclick="return confirm('Kembalikan alat sekarang?')">
                               Kembalikan
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
