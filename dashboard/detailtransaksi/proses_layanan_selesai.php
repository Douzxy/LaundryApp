<?php
include '../koneksi.php';
session_start();

$id_transaksi = $_POST['id_transaksi'];

// Update status layanan menjadi 'proses'
$query = "UPDATE transaksi SET status = 'proses' WHERE id_transaksi = $id_transaksi;";

if (mysqli_query($conn, $query)) {
    $_SESSION['alert'] = [
        'type' => 'success',
        'title' => 'Berhasil!',
        'message' => 'Layanan berhasil diproses.'
    ];
} else {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Gagal!',
        'message' => 'Terjadi kesalahan saat memperbarui status layanan: ' . mysqli_error($conn)
    ];
}

// Redirect kembali ke halaman sebelumnya
header("Location: index.php?id_transaksi=$id_transaksi");
exit();
