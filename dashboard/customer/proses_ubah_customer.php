<?php
session_start();
include "../koneksi.php";

if ($_POST) {
    $id_customer = $_POST['id_customer'];
    $nama_customer = $_POST['nama_customer'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];

    if (empty($nama_customer)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Nama pelanggan tidak boleh kosong.'
        ];
    } elseif (empty($alamat)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Alamat tidak boleh kosong.'
        ];
    } elseif (empty($jenis_kelamin)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Jenis kelamin tidak boleh kosong.'
        ];
    } elseif (empty($no_telp)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Nomor telepon tidak boleh kosong.'
        ];
    } else {
        $sql = "UPDATE customer 
                SET nama_customer = '$nama_customer', alamat = '$alamat', jenis_kelamin = '$jenis_kelamin', no_telp = '$no_telp' 
                WHERE id_customer = '$id_customer'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Pelanggan berhasil diperbarui.'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'title' => 'Gagal!',
                'message' => 'Gagal mengubah Pelanggan. Coba lagi.'
            ];
        }
    }

    mysqli_close($conn);
    header("Location: index.php");
    exit();
}
