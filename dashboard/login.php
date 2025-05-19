<?php
include 'koneksi.php';
session_start();

// Cek jika pengguna sudah login
if (isset($_SESSION['username'])) {
	// Jika sudah login, arahkan ke dashboard
	header("Location: " . base_url . "dashboard/index.php");
	exit();
}

// Tampilkan alert jika ada di session
displayAlert();

if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$pwhash = md5($password);

	// Cek apakah username ada di database
	$checkUser    = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	if (mysqli_num_rows($checkUser) == 0) {
		$_SESSION['alert'] = [
			'type' => 'warning',
			'title' => 'Login Gagal!',
			'message' => 'Username tidak ditemukan.'
		];
		header("location:login.php");
		exit();
	}

	// Jika username ditemukan, lanjut cek password
	$query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$pwhash'");

	if (mysqli_num_rows($query) > 0) {
		$data = mysqli_fetch_assoc($query);

		// Check if the account is disabled
		if ($data['level'] == 'off') {
			$_SESSION['alert'] = [
				'type' => 'danger',
				'title' => 'Akun Dinonaktifkan!',
				'message' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.'
			];
			header("location:login.php");
			exit();
		}

		$_SESSION['username'] = $username;
		$_SESSION['id_user'] = $data['id_user'];
		$_SESSION['level'] = $data['level'];
		$_SESSION['nama_user'] = $data['nama_user'];

		if ($data['level'] == "admin" || $data['level'] == "petugas") {
			$_SESSION['alert'] = [
				'type' => 'success',
				'title' => 'Login Berhasil!',
				'message' => 'Selamat datang, ' . $data['username']
			];
			header("Location: index.php");
			exit();
		} else {
			$_SESSION['alert'] = [
				'type' => 'danger',
				'title' => 'Login Gagal!',
				'message' => 'Akses tidak diizinkan.'
			];
			header("location:login.php");
			exit();
		}
	} else {
		$_SESSION['alert'] = [
			'type' => 'danger',
			'title' => 'Login Gagal!',
			'message' => 'Password salah.'
		];
		header("location:login.php");
		exit();
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<base href="../">
	<meta charset="utf-8" />
	<title>Frestlt Laundry - Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="<?= base_url; ?>assets/img/logo.png" type="image/x-icon" />
	<link href="<?= base_url; ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url; ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background: linear-gradient(135deg, #d6f0ff 0%, #f0fdff 100%);
			height: 100vh;
			margin: 0;
			overflow: hidden;
		}

		.login-wrapper {
			display: flex;
			height: 100vh;
		}

		.login-image-side {
			flex: 1;
			background-image: url('<?= base_url; ?>assets/img/laundry-bg.jpg');
			background-size: cover;
			background-position: center;
			position: relative;
			display: none;
		}

		@media (min-width: 992px) {
			.login-image-side {
				display: block;
			}
		}

		.login-form-side {
			flex: 1;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 2rem;
		}

		.login-container {
			background: white;
			border-radius: 20px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
			padding: 2.5rem;
			width: 100%;
			max-width: 450px;
			position: relative;
			overflow: hidden;
		}

		.login-header {
			text-align: center;
			margin-bottom: 2rem;
		}

		.login-logo {
			width: 80px;
			height: 80px;
			object-fit: contain;
			margin-bottom: 1rem;
			animation: pulse 2s infinite;
		}

		@keyframes pulse {
			0% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.05);
			}

			100% {
				transform: scale(1);
			}
		}

		.login-title {
			font-size: 1.75rem;
			font-weight: 700;
			color: #36a3f7;
			/* primary color */
			margin-bottom: 0.5rem;
		}

		.login-subtitle {
			font-size: 1rem;
			font-weight: 400;
			color: #6c757d;
			/* secondary color */
			margin-bottom: 2rem;
		}

		.form-floating {
			margin-bottom: 1.5rem;
			position: relative;
		}

		.input-group {
			display: flex;
			align-items: center;
			border-radius: 10px;
			border: 1px solid #e0e6ed;
			transition: border-color 0.3s ease;
		}

		.input-group:focus-within {
			border-color: #36a3f7;
			/* primary color */
		}

		.input-group-text {
			background-color: #f9fbff;
			border: none;
			border-radius: 10px 0 0 10px;
			height: 50px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.form-control {
			border: none;
			border-radius: 0 10px 10px 0;
			padding: 0.75rem 1rem;
			font-size: 1rem;
			transition: all 0.3s ease;
			background-color: #f9fbff;
		}

		.form-control:focus {
			box-shadow: 0 0 0 0.2rem rgba(54, 163, 247, 0.15);
			background-color: white;
		}

		.password-toggle {
			position: absolute;
			right: 1rem;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: #6c757d;
			/* secondary color */
			z-index: 10;
			transition: all 0.2s ease;
		}

		.btn-login {
			background: #36a3f7;
			/* primary color */
			border: none;
			border-radius: 12px;
			padding: 0.75rem;
			font-size: 1.1rem;
			font-weight: 600;
			color: white;
			width: 100%;
			margin-top: 1rem;
			transition: all 0.3s ease;
			position: relative;
			overflow: hidden;
			height: 55px;
		}

		.btn-login:hover {
			background: #1a97f5;
			/* primary hover */
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(54, 163, 247, 0.3);
		}

		.custom-alert {
			border-radius: 12px;
			padding: 1rem;
			margin-bottom: 1.5rem;
			display: flex;
			align-items: center;
			animation: slideDown 0.4s ease forwards;
		}

		@keyframes slideDown {
			from {
				opacity: 0;
				transform: translateY(-20px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.alert-warning {
			background-color: #fff3cd;
			border-left: 4px solid #ffc107;
			color: #856404;
		}

		.alert-danger {
			background-color: #f8d7da;
			border-left: 4px solid #dc3545;
			color: #721c24;
		}

		.alert-success {
			background-color: #d4edda;
			border-left: 4px solid #28a745;
			color: #155724;
		}

		.alert-icon {
			font-size: 1.5rem;
			margin-right: 1rem;
		}

		.alert-content {
			flex: 1;
		}

		.alert-title {
			font-weight: 600;
			margin-bottom: 0.25rem;
		}

		.alert-dismiss {
			color: inherit;
			opacity: 0.7;
			cursor: pointer;
			transition: opacity 0.2s;
		}

		.alert-dismiss:hover {
			opacity: 1;
		}
	</style>


	<div class="login-wrapper">
		<div class="login-form-side">
			<div class="login-container">
				<div class="bubble bubble-1"></div>
				<div class="bubble bubble-2"></div>

				<?php if (isset($_SESSION['alert'])): ?>
					<div class="custom-alert alert-<?= $_SESSION['alert']['type'] ?>">
						<i class="alert-icon fas <?= $_SESSION['alert']['type'] == 'success' ? 'fa-check-circle' : ($_SESSION['alert']['type'] == 'warning' ? 'fa-exclamation-triangle' : 'fa-times-circle') ?>"></i>
						<div class="alert-content">
							<div class="alert-title"><?= $_SESSION['alert']['title'] ?></div>
							<div class="alert-message"><?= $_SESSION['alert']['message'] ?></div>
						</div>
						<div class="alert-dismiss" onclick="this.parentElement.style.display='none'">
							<i class="fas fa-times"></i>
						</div>
					</div>
					<?php unset($_SESSION['alert']); ?>
				<?php endif; ?>

				<div class="login-header">
					<img src="<?= base_url; ?>assets/img/logo.png" alt="Frestlt Laundry Logo" class="login-logo">
					<h2 class="login-title animated">Frestlt Laundry</h2>
					<p class="login-subtitle animated delay-1 ">Silahkan login untuk melanjutkan</p>
				</div>

				<form action="" method="POST" id="loginForm">
					<div class="form-floating animated delay-2">
						<div class="input-group">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
							<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
						</div>
					</div>

					<div class="form-floating animated delay-3">
						<div class="input-group">
							<span class="input-group-text"><i class="fas fa-lock"></i></span>
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
							<span class="password-toggle" onclick="togglePassword()">
								<i id="toggleIcon" class="fas fa-eye"></i>
							</span>
						</div>
					</div>

					<button type="submit" name="login" class="btn-login animated delay-4" id="loginButton">
						<span>Masuk</span>
						<span class="btn-overlay" id="btnOverlay"></span>
					</button>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
	<script>
		function togglePassword() {
			const passwordInput = document.getElementById('password');
			const toggleIcon = document.getElementById('toggleIcon');

			if (passwordInput.type === "password") {
				passwordInput.type = "text";
				toggleIcon.classList.remove('fa-eye');
				toggleIcon.classList.add('fa-eye-slash');
			} else {
				passwordInput.type = "password";
				toggleIcon.classList.remove('fa-eye-slash');
				toggleIcon.classList.add('fa-eye');
			}
		}

		document.getElementById('loginButton').addEventListener('mousedown', function(e) {
			const x = e.clientX - e.target.getBoundingClientRect().left;
			const y = e.clientY - e.target.getBoundingClientRect().top;

			const overlay = document.getElementById('btnOverlay');
			overlay.style.left = `${x}px`;
			overlay.style.top = `${y}px`;
			overlay.style.transform = 'scale(15)';

			setTimeout(() => {
				overlay.style.transform = 'scale(0)';
			}, 600);
		});

		document.getElementById('loginForm').addEventListener('submit', function(e) {
			const username = document.getElementById('username').value;
			const password = document.getElementById('password').value;

			if (username.trim() === '' || password.trim() === '') {
				e.preventDefault();
				alert('Username dan password tidak boleh kosong!');
			}
		});

		setTimeout(function() {
			const alert = document.querySelector('.custom-alert');
			if (alert) {
				alert.style.opacity = '0';
				alert.style.transform = 'translateY(-20px)';
				setTimeout(() => alert.style.display = 'none', 500);
			}
		}, 5000);
	</script>
</body>

</html>