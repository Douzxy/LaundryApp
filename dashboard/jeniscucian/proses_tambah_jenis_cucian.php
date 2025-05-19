<?php
session_start();
include "../koneksi.php";

if ($_POST) {
    $nama_jenis_cucian = $_POST['nama_jenis_cucian'];
    $harga = $_POST['harga'];

    if (empty($nama_jenis_cucian)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Nama jenis cucian tidak boleh kosong.'
        ];
    } elseif (empty($harga)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Harga tidak boleh kosong.'
        ];
    } else {
        $sql = "INSERT INTO jenis_cucian (nama_jenis_cucian, harga) VALUES ('$nama_jenis_cucian', '$harga')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Sukses menambahkan jenis cucian.'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'Gagal menambahkan jenis cucian.'
            ];
        }

        mysqli_close($conn);
    }
}

header("Location: index.php");
exit;
