<?php
session_start();

// Hapus semua variabel sesi
$_SESSION = [];
session_unset();
session_destroy();

// Hapus cookie sesi (jika ada)
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Redirect ke login.php
header("Location: login.php");
exit;

