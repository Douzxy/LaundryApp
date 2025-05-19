
<?php
session_start();
include "../koneksi.php";


if ($_POST) {
    $id_user = $_POST['id_user'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    session_start();
    include 'alert.php';

    if (empty($nama_user)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Nama user tidak boleh kosong.'
        ];
        header("Location: index.php");
        exit();
    } elseif (empty($username)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Username tidak boleh kosong.'
        ];
        header("Location: index.php");
        exit();
    } elseif (empty($no_telp)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'No. Telepon tidak boleh kosong.'
        ];
        header("Location: index.php");
        exit();
    } elseif (empty($password)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Password tidak boleh kosong.'
        ];
        header("Location: index.php");
        exit();
    } else {
        // Check if username already exists
        $check_username = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
        if (mysqli_num_rows($check_username) > 0) {
            $_SESSION['alert'] = [
                'type' => 'warning',
                'title' => 'Peringatan!',
                'message' => 'Username sudah digunakan.'
            ];
            header("Location: index.php");
            exit();
        } else {
            $sql = "INSERT INTO user (id_user, nama_user, username, no_telp, password) 
                VALUES ('$id_user', '$nama_user', '$username', '$no_telp', '$password')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'title' => 'Berhasil!',
                    'message' => 'Sukses menambahkan user.'
                ];
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'title' => 'Error!',
                    'message' => 'Gagal menambahkan user.'
                ];
            }
            header("Location: index.php");
            exit();
        }
    }


    mysqli_close($conn);
}
?>