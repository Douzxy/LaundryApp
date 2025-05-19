<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id_jenis_cucian'])) {
    $id_jenis_cucian = $_GET['id_jenis_cucian'];

    $sql = "DELETE FROM jenis_cucian WHERE id_jenis_cucian = '$id_jenis_cucian'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Jenis cucian berhasil dihapus.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Gagal menghapus jenis cucian.'
        ];
    }
} else {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Error!',
        'message' => 'Tidak ada jenis cucian yang dipilih untuk dihapus.'
    ];
}

header("Location: index.php");
exit;
