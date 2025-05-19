<?php
include "../koneksi.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_user']); // Pastikan ID adalah angka
    $level = isset($_POST['level']) ? "'petugas'" : "'off'"; // Jika dicentang jadi 'petugas', jika tidak jadi 'off'

    // Query update level
    $query = "UPDATE user SET level = $level WHERE id_user = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Status petugas berhasil diperbarui.'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui status petugas. ' . mysqli_error($conn)
        ];
    }

    mysqli_close($conn);

    // Redirect kembali ke halaman user
    header("Location: " . base_url . "dashboard/user/index.php");
    exit();
}
