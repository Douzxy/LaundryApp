<?php
include "../koneksi.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user ID and form data
    $id_user = $_SESSION['id_user'];
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);

    // Validate inputs
    if (empty($_POST['old_password']) || empty($_POST['new_password'])) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Semua input harus diisi!'
        ];
        header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
        exit;
    }

    // Verify old password
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'");
    $user = mysqli_fetch_array($query);

    if ($old_password != $user['password']) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Password lama tidak sesuai!'
        ];
        header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
        exit;
    }

    // Update password with MD5
    $update_query = mysqli_query($conn, "UPDATE user SET 
        password = '$new_password'
        WHERE id_user = '$id_user'");

    if ($update_query) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Password berhasil diupdate!'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Gagal mengupdate password!'
        ];
    }

    header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
    exit;
} else {
    header("Location: " . base_url . "dashboard/user/pengaturan_user.php");
    exit;
}
