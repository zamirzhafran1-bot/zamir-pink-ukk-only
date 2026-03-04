<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    exit;
}

$user_id     = $_SESSION['id_user'];
$alat_id     = $_POST['alat_id'];
$jumlah      = $_POST['jumlah'];
$tgl_pinjam  = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];

/* ===== CEK ALAT: AKTIF & STOK CUKUP ===== */
$cek = mysqli_query($koneksi,
    "SELECT stok, status
     FROM alat
     WHERE id='$alat_id' AND status='aktif'
     LIMIT 1"
);

$alat = mysqli_fetch_assoc($cek);

if (!$alat) {
    exit("Alat tidak tersedia atau sudah nonaktif");
}

if ($alat['stok'] < $jumlah) {
    exit("Stok tidak mencukupi");
}


/* ===== TRANSAKSI ===== */
mysqli_begin_transaction($koneksi);

try {

    // simpan peminjaman
    mysqli_query($koneksi, "INSERT INTO peminjaman (user_id, tgl_pinjam, tgl_kembali, status)
VALUES ('$user_id', '$tgl_pinjam', '$tgl_kembali', 'menunggu_peminjaman')");

    

    $peminjaman_id = mysqli_insert_id($koneksi);

    // simpan detail peminjaman
    mysqli_query($koneksi,
        "INSERT INTO detail_peminjaman (peminjaman_id, alat_id, jumlah)
         VALUES ('$peminjaman_id', '$alat_id', '$jumlah')"
    );

    // kurangi stok alat
    mysqli_query($koneksi,
        "UPDATE alat
         SET stok = stok - $jumlah
         WHERE id = '$alat_id'"
    );

    // log aktivitas
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$user_id', 'Mengajukan peminjaman alat', NOW())"
    );

    mysqli_commit($koneksi);
    header("Location: pinjam.php?success=1");
    exit;

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "Gagal memproses peminjaman";
}
