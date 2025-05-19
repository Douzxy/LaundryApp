<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    $sql = "DELETE FROM user WHERE id_user = '$id_user'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'User berhasil dihapus.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Gagal menghapus user.'
        ];
    }
} else {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Error!',
        'message' => 'Tidak ada user yang dipilih untuk dihapus.'
    ];
}

header("Location: index.php");
exit();
