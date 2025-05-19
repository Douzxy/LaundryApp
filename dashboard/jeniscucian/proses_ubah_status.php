<?php
include "../koneksi.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_jenis_cucian']); // Pastikan ID adalah angka untuk keamanan
    $status = isset($_POST['status']) ? "'1'" : "'0'"; // ENUM di MySQL harus berupa string ('0' atau '1')

    // Query update status
    $query = "UPDATE jenis_cucian SET status = $status WHERE id_jenis_cucian = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Status jenis cucian berhasil diperbarui.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui status. ' . mysqli_error($conn)
        ];
    }

    mysqli_close($conn);

    // Redirect kembali ke halaman utama
    header("Location: " . base_url . "dashboard/jeniscucian/index.php");
    exit();
}
