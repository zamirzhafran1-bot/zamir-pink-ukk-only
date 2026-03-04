<?php
session_start();
include "../config/database.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

/* Ambil detail alat */
$detail = mysqli_query($koneksi,
    "SELECT alat_id, jumlah
     FROM detail_peminjaman
     WHERE peminjaman_id = '$id'"
);

while ($d = mysqli_fetch_assoc($detail)) {
    $alat_id = $d['alat_id'];
    $jumlah  = $d['jumlah'];

    mysqli_query($koneksi,
        "UPDATE alat
         SET stok = stok + $jumlah
         WHERE id = '$alat_id'"
    );
}

/* Update status peminjaman */
mysqli_query($koneksi,
    "UPDATE peminjaman
     SET status = 'selesai',
         tgl_kembali = CURDATE()
     WHERE id = '$id'"
);

header("Location: pengembalian_admin.php");
exit;
