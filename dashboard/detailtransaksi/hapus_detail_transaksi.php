<?php
session_start();
include "../koneksi.php";

$id_transaksi = $_GET['id_transaksi'];

if (isset($_GET['id_detail_transaksi'])) {
    $id_detail_transaksi = $_GET['id_detail_transaksi'];

    $sql = "DELETE FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Detail transaksi berhasil dihapus.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Gagal menghapus detail transaksi.'
        ];
    }

    header("Location: index.php?id_transaksi=$id_transaksi");
} else {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Gagal!',
        'message' => 'ID Detail Transaksi tidak ditemukan.'
    ];
    header("Location: index.php");
}

mysqli_close($conn);
exit();
