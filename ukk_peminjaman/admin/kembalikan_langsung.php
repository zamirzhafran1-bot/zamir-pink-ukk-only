<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
 // log aktivitas
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Mengembalikan alat dari admin";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
$id = $_GET['id'];

/* Ambil detail alat */
$q = mysqli_query($koneksi,
"SELECT alat_id, jumlah 
 FROM detail_peminjaman 
 WHERE peminjaman_id='$id'"
);

$d = mysqli_fetch_assoc($q);
$alat_id = $d['alat_id'];
$jumlah = $d['jumlah'];

/* Kembalikan stok */
mysqli_query($koneksi,
"UPDATE alat 
 SET stok = stok + $jumlah 
 WHERE id='$alat_id'"
);

/* Update status */
mysqli_query($koneksi,
"UPDATE peminjaman 
 SET status='selesai',
     tgl_kembali = CURDATE()
 WHERE id='$id'"
);

header("Location: pengembalian_admin.php");
exit;
