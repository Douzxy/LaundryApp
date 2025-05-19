<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id_customer'])) {
    $id_customer = $_GET['id_customer'];

    $sql = "DELETE FROM customer WHERE id_customer = '$id_customer'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Pelanggan berhasil dihapus.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Gagal menghapus Pelanggan. Coba lagi.'
        ];
    }
} else {
    $_SESSION['alert'] = [
        'type' => 'warning',
        'title' => 'Peringatan!',
        'message' => 'Tidak ada Pelanggan yang dipilih untuk dihapus.'
    ];
}

header("Location: index.php");
exit();
