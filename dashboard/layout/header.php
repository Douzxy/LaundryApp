<?php
session_start();
include "../koneksi.php";

if (!defined('base_url')) {
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://localhost/laundryapp/";
    define("base_url", $url);
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Peringatan!',
        'message' => 'Silahkan Masuk terlebih dahulu.'
    ];
    header("Location: " . base_url . "dashboard/login.php");
    exit();
}

// Ambil level user dari database untuk memastikan masih "admin" atau "petugas"
$username = $_SESSION['username'];

// Menggunakan prepared statement untuk keamanan
$query = "SELECT level FROM user WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Jika tidak ada hasil, set level sebagai kosong
$level = $row['level'] ?? '';

if ($level === "off") {
    // Hapus semua variabel sesi
    $_SESSION = [];
    session_unset();

    session_destroy();

    // Hapus cookie sesi (jika ada)
    if (ini_get("session.use_cookies")) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    header("Location: " . base_url . "dashboard/login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../">
    <meta charset="utf-8" />
    <title>Laundry App</title>
    <meta name="description" content="Jet admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
    <meta name="keywords" content="Jet theme, bootstrap, bootstrap 5, admin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
    <link rel="canonical" href="Https://preview.keenthemes.com/jet-free" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?= base_url; ?>assets/img/logo.png" type="image/x-icon" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="<?= base_url; ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url; ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">