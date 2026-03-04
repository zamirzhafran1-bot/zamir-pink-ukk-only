<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}
 // log aktivitas
    $user_id = $_SESSION['id_user'];
    $aktivitas = "Mengembalikan alat ";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', '$aktivitas', NOW())"
    );
$id = $_GET['id'];
$user_id = $_SESSION['id_user'];

$cek = mysqli_query($koneksi,
"SELECT * FROM peminjaman
 WHERE id='$id'
 AND user_id='$user_id'
 AND status='dipinjam'"
);

if (mysqli_num_rows($cek) == 0) {
    header("Location: kembali.php");
    exit;
}

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

/* Update status peminjaman */
mysqli_query($koneksi,
"UPDATE peminjaman 
 SET status='selesai',
     tgl_kembali = CURDATE()
 WHERE id='$id'"
);

header("Location: kembali.php");
exit;
?>
