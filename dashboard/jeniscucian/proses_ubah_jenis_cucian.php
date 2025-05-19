<?php
session_start();
include "../koneksi.php";

if ($_POST) {
    $id_jenis_cucian = $_POST['id_jenis_cucian'];
    $nama_jenis_cucian = $_POST['nama_jenis_cucian'];
    $harga = $_POST['harga'];

    if (empty($nama_jenis_cucian)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Nama jenis cucian tidak boleh kosong.'
        ];
        header("Location: ubah_jenis_cucian.php?id_jenis_cucian=$id_jenis_cucian");
    } elseif (empty($harga)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Harga tidak boleh kosong.'
        ];
        header("Location: ubah_jenis_cucian.php?id_jenis_cucian=$id_jenis_cucian");
    } else {
        $sql = "UPDATE jenis_cucian SET nama_jenis_cucian = '$nama_jenis_cucian', harga = '$harga' WHERE id_jenis_cucian = '$id_jenis_cucian'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Sukses mengubah jenis cucian.'
            ];
            header("Location: index.php");
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'Gagal mengubah jenis cucian.'
            ];
            header("Location: ubah_jenis_cucian.php?id_jenis_cucian=$id_jenis_cucian");
        }

        mysqli_close($conn);
    }
}
exit;
