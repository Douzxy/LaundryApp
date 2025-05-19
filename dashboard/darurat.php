<?php
session_start();
include "../koneksi.php";

if (!defined('base_url')) {
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://localhost/laundryapp/";
    define("base_url", $url);
}

$current_page = basename($_SERVER['PHP_SELF'], ".php");

if (isset($_POST['kode_unik'])) {
    $kode_unik = $_POST['kode_unik'];
    $expected_kode_unik = 'A9$X!P7@M4#K3T*F2L&VZQ5N8Y%R6D';

    if ($kode_unik === $expected_kode_unik) {
        // Hash password baru menggunakan MD5
        $hashed_password = md5("admin");

        // Query update data admin
        $sql = "UPDATE user SET nama_user = 'admin', username = 'admin', password = '$hashed_password' WHERE level = 'admin'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Kode unik berhasil diatur ulang. Akun admin telah diperbarui, silakan login kembali.'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'warning',
                'title' => 'Perhatian!',
                'message' => 'Kode unik benar, tetapi terjadi kesalahan saat memperbarui akun admin.'
            ];
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Gagal!',
            'message' => 'Kode unik tidak sesuai, silakan coba lagi.'
        ];
    }

    // Redirect agar form tidak resubmit
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../">
    <meta charset="utf-8" />
    <title>Laundry App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?= base_url; ?>assets/img/logo.png" type="image/x-icon" />
    <link href="<?= base_url; ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url; ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Atur Ulang Admin</h4>
                </div>
                <div class="card-body">
                    <div id="alert-container"></div>

                    <form method="POST" id="resetForm">
                        <div class="mb-3">
                            <label for="kode_unik" class="form-label">Kode Unik</label>
                            <input type="text" class="form-control" id="kode_unik" name="kode_unik" required autocomplete="off">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url; ?>dashboard/login.php" class="btn btn-secondary">Kembali ke Login</a> <!-- Tombol Kembali ke Login -->
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Added Bootstrap JS -->
    <script src="<?= base_url; ?>assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url; ?>assets/js/scripts.bundle.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let alertContainer = document.getElementById("alert-container");

            <?php if (isset($_SESSION['alert'])) : ?>
                let alertHTML = `
                    <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                        <strong><?= $_SESSION['alert']['title'] ?></strong> <?= $_SESSION['alert']['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;

                alertContainer.innerHTML = alertHTML;

                // Auto-hide after 5 seconds
                let alertElement = alertContainer.querySelector('.alert');
                setTimeout(() => {
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 5000);

                <?php unset($_SESSION['alert']); ?>
            <?php endif; ?>
        });
    </script>

</body>

</html>