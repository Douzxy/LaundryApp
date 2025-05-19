<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    $sql = "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Transaksi berhasil dihapus.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Gagal menghapus transaksi.'
        ];
    }
} else {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Gagal!',
        'message' => 'Tidak ada transaksi yang dipilih untuk dihapus.'
    ];
}

header("Location: index.php");
exit();
