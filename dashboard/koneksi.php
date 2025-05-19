<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "aplikasilaundry";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
	die("Koneksi gagal:" . mysqli_connect_error());
}

// Check if the constant is already defined
if (!defined('base_url')) {
	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://localhost/laundryapp/";
	define("base_url", $url);
}

date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$pwhash = md5($password);

	$query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$pwhash'");

	if (mysqli_num_rows($query) > 0) {
		$data = mysqli_fetch_assoc($query);
		$_SESSION['username'] = $username;
		$_SESSION['id_user'] = $data['id_user'];
		$_SESSION['level'] = $data['level'];
		$_SESSION['nama_user'] = $data['nama_user'];

		header("location:admin/index.php");
	} else {
		header("location:login.php?alert=gagal");
	}
}

if (isset($_GET['login'])) {
	// Tangkap nilai dari URL
	$login = $_GET['login'];
} else {
	$login = "berhasil";
}

include 'layout/alert.php';