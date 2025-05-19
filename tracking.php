<?php
session_start();
include "dashboard/koneksi.php";

if (!defined('base_url')) {
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://localhost/laundryapp/";
    define("base_url", $url);
}

$transactionDetails = null; // Initialize variable for transaction details

if (isset($_POST['transactionCode'])) {
    $transactionCode = mysqli_real_escape_string($conn, $_POST['transactionCode']);

    // Fetch transaction details from the database
    $qry = mysqli_query($conn, "
        SELECT t.*, c.nama_customer, c.no_telp, c.alamat
        FROM transaksi t
        JOIN customer c ON t.id_customer = c.id_customer
        WHERE t.kode_transaksi = '$transactionCode'
    ");

    $transactionDetails = mysqli_fetch_array($qry);

    // Store the transaction code in the session
    $_SESSION['transactionCode'] = $transactionCode;

    // Redirect to the same page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Check if there is a transaction code in the session
if (isset($_SESSION['transactionCode'])) {
    $transactionCode = $_SESSION['transactionCode'];

    // Fetch transaction details from the database again
    $qry = mysqli_query($conn, "
        SELECT t.*, c.nama_customer, c.no_telp, c.alamat
        FROM transaksi t
        JOIN customer c ON t.id_customer = c.id_customer
        WHERE t.kode_transaksi = '$transactionCode'
    ");

    $transactionDetails = mysqli_fetch_array($qry);

    // Clear the session variable
    unset($_SESSION['transactionCode']);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Cucian</title>

    <link rel="shortcut icon" href="<?= base_url; ?>assets/img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>
    <style>
        /* Your existing styles */
    </style>
</head>

<body class="bg-gradient-to-b from-blue-50 to-cyan-100 min-h-screen" x-data="{ showModal: <?= $transactionDetails ? 'true' : 'false' ?> }">
    <!-- Animated background bubbles -->

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden relative card-shine">
            

            <div class="px-8 py-6 form-container">
                <h2 class="text-3xl font-bold text-center gradient-text mb-2">Lacak Status Cucian Anda</h2>
                <p class="text-gray-600 text-center mb-8">Masukkan kode transaksi untuk melihat status cucian Anda</p>

                <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" class="space-y-6">
                    <div class="relative group">
                        <input type="text" name="transactionCode" class="w-full px-6 py-4 border-0 rounded-xl focus:outline-none transition-all pl-14 bg-blue-50 shadow-inner input-focus-effect" placeholder="Kode Transaksi" required>
                        <div class="absolute left-4 top-4 text-cyan-500 transform group-hover:scale-110 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-cyan-500 to-cyan-600 text-black font-medium rounded-xl transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 flex items-center justify-center gap-2">
                        <span class="mr-2">Lacak Sekarang</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>

                </form>

                <!-- Modal for transaction details -->
                <div x-show="showModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="fixed inset-0 flex items-center justify-center z-50"
                    style="background-color: rgba(0,0,0,0.5);">

                    <div class="bg-white rounded-2xl shadow-2xl p-8 w-11/12 max-w-md">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold gradient-text">Detail Transaksi</h3>
                            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <?php if ($transactionDetails): ?>
                            <div class="space-y-4">
                                <div class="p-4 bg-blue-50 rounded-xl">
                                    <p class="text-xs text-cyan-600 uppercase font-semibold">Kode Transaksi</p>
                                    <p class="text-gray-800 font-medium"><?= htmlspecialchars($transactionDetails['kode_transaksi']); ?></p>
                                </div>

                                <div class="p-4 bg-blue-50 rounded-xl">
                                    <p class="text-xs text-cyan-600 uppercase font-semibold">Nama Pelanggan</p>
                                    <p class="text-gray-800 font-medium"><?= htmlspecialchars($transactionDetails['nama_customer']); ?></p>
                                </div>

                                <div class="p-4 bg-blue-50 rounded-xl">
                                    <p class="text-xs text-cyan-600 uppercase font-semibold">Alamat</p>
                                    <p class="text-gray-800 font-medium"><?= htmlspecialchars($transactionDetails['alamat']); ?></p>
                                </div>

                                <div class="p-4 bg-blue-50 rounded-xl">
                                    <p class="text-xs text-cyan-600 uppercase font-semibold">Telepon</p>
                                    <p class="text-gray-800 font-medium"><?= htmlspecialchars($transactionDetails['no_telp']); ?></p>
                                </div>

                                <div class="p-4 rounded-xl <?= ($transactionDetails['status'] == 'Selesai' ? 'bg-blue-50' : ($transactionDetails['status'] == 'Diproses' ? 'bg-orange-50' : 'bg-gray-50')) ?>">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg <?= ($transactionDetails['status'] == 'Selesai' ? 'text-blue-600' : ($transactionDetails['status'] == 'Diproses' ? 'text-orange-600' : 'text-gray-600')) ?>">
                                            <?= ($transactionDetails['status'] == 'Selesai' ? '✅' : ($transactionDetails['status'] == 'Diproses' ? '⏳' : '📝')) ?>
                                        </span>
                                        <p class="text-xs <?= ($transactionDetails['status'] == 'Selesai' ? 'text-blue-600' : ($transactionDetails['status'] == 'Diproses' ? 'text-orange-600' : 'text-gray-600')) ?> uppercase font-semibold">
                                            Status Cucian
                                        </p>
                                    </div>
                                    <p class="font-medium <?= ($transactionDetails['status'] == 'Selesai' ? 'text-blue-800' : ($transactionDetails['status'] == 'Diproses' ? 'text-orange-800' : 'text-gray-800')) ?>">
                                        <?= htmlspecialchars(ucfirst(strtolower($transactionDetails['status']))); ?>
                                    </p>
                                </div>

                                <div class="p-4 rounded-xl <?= ($transactionDetails['status_pembayaran'] == 1) ? 'bg-green-50' : 'bg-yellow-50' ?>">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg <?= ($transactionDetails['status_pembayaran'] == 1) ? 'text-green-600' : 'text-yellow-600' ?>">
                                            <?= ($transactionDetails['status_pembayaran'] == 1) ? '✔️' : '⚠️' ?>
                                        </span>
                                        <p class="text-xs <?= ($transactionDetails['status_pembayaran'] == 1) ? 'text-green-600' : 'text-yellow-600' ?> uppercase font-semibold">
                                            Status Pembayaran
                                        </p>
                                    </div>
                                    <p class="font-medium <?= ($transactionDetails['status_pembayaran'] == 1) ? 'text-green-800' : 'text-yellow-800' ?>">
                                        <?= ($transactionDetails['status_pembayaran'] == 1) ? "Sudah Dibayar" : "Belum Dibayar" ?>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-8">
                                <a href="<?= $_SERVER['PHP_SELF']; ?>" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-cyan-600 text-black rounded-xl hover:shadow-lg transition duration-300 text-center block font-medium">
                                    Kembali
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-12 p-6 bg-blue-50 rounded-2xl text-center shadow-inner">
                    <p class="text-gray-600">
                        Butuh bantuan? Hubungi kami di
                        <a href="#" class="relative inline-block group">
                            <span class="text-cyan-600 font-medium">0896-1226-4122</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-cyan-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Remove animation script
    </script>
</body>

</html>