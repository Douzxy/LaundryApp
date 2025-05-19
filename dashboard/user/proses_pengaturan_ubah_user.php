<?php
include "../koneksi.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id_user = $_SESSION['id_user'];
    $username = $_POST['username'] ?? null;
    $nama_user = $_POST['nama_user'];
    $no_telp = $_POST['no_telp'];

    // Validate input
    if (empty($nama_user) || empty($no_telp)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Semua field harus diisi!'
        ];
        header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
        exit;
    }

    // Cek apakah username sudah digunakan oleh user lain
    if (!empty($username)) {
        $cek_username = mysqli_query($conn, "SELECT id_user FROM user WHERE username = '$username' AND id_user != '$id_user'");
        if (mysqli_num_rows($cek_username) > 0) {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'Username sudah digunakan oleh pengguna lain!'
            ];
            header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
            exit;
        }
    }

    // Build query dynamically
    $query = "UPDATE user SET nama_user = '$nama_user', no_telp = '$no_telp'";

    if (!empty($username)) {
        $query .= ", username = '$username'";
    }

    $query .= " WHERE id_user = '$id_user'";

    // Execute query
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Data berhasil diupdate!'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Gagal mengupdate data!'
        ];
    }

    header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
    exit;
} else {
    header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
    exit;
}
