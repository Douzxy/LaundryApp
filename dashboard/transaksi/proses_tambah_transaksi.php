<?php
include "../koneksi.php";
session_start();

if ($_POST) {
    $id_customer = $_POST['id_customer'];
    $kode_transaksi = "TRANS" . "-" . date('Ymdsi');
    $id_user = $_SESSION['id_user'];

    if (empty($id_customer)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'ID Customer tidak boleh kosong.'
        ];
        header("Location: index.php");
        exit();
    } else {
        $insert = mysqli_query($conn, "INSERT INTO transaksi (id_customer, id_user, kode_transaksi) 
                 VALUES ('$id_customer', '$id_user', '$kode_transaksi')");

        if ($insert) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Transaksi berhasil ditambahkan.'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'title' => 'Gagal!',
                'message' => 'Gagal menambahkan transaksi.'
            ];
        }
        header("Location: index.php");
        exit();
    }
}
