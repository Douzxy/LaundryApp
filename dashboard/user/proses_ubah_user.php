<?php
include "../koneksi.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id_user = $_POST['id_user'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    // Check if username already exists for another user
    $check_username = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND id_user != '$id_user'");
    if (mysqli_num_rows($check_username) > 0) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Peringatan!',
            'message' => 'Username sudah digunakan!'
        ];
        header("Location: " . base_url . "dashboard/user/ubah_user.php?id_user=$id_user");
        exit;
    }

    // Update user data
    $sql = "
        UPDATE user SET 
            nama_user = '$nama_user', 
            username = '$username', 
            password = '$password', 
            no_telp = '$no_telp'
        WHERE id_user = '$id_user';
    ";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Sukses mengedit petugas!'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Gagal mengedit petugas!'
        ];
    }

    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
