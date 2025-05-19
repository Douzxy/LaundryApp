<?php
include '../koneksi.php';
session_start();

// Ambil data dari form
$id_transaksi = $_POST['id_transaksi'];
$status = $_POST['status'];

// Fungsi untuk mengubah nomor ke format internasional
function formatNomorWA($nomor)
{
    $nomor = preg_replace('/\D/', '', $nomor); // Hapus karakter selain angka
    if (substr($nomor, 0, 1) === "0") {
        $nomor = "+62" . substr($nomor, 1);
    }
    return $nomor;
}

if ($_POST) {
    // Ambil data transaksi dari database
    $query = "SELECT status_pembayaran, no_telp, nama_customer, kode_transaksi FROM transaksi 
              JOIN customer ON transaksi.id_customer = customer.id_customer
              WHERE id_transaksi = '$id_transaksi'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $status_pembayaran = $data['status_pembayaran'];
        $no_wa = formatNomorWA($data['no_telp']);
        $nama_customer = $data['nama_customer'];
        $kode_transaksi = $data['kode_transaksi'];

        // Cek jika status ingin diubah menjadi 'diambil' tetapi belum dibayar
        if ($status === 'diambil' && $status_pembayaran == 0) {
            $_SESSION['alert'] = [
                'type' => 'warning',
                'title' => 'Peringatan!',
                'message' => 'Transaksi belum dibayar. Harap lakukan pembayaran terlebih dahulu.'
            ];
            header("Location: index.php?id_transaksi=$id_transaksi");
            exit();
        }

        // Update status transaksi
        $sql = "UPDATE transaksi SET status = '$status' WHERE id_transaksi = '$id_transaksi'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Status transaksi berhasil diubah.'
            ];

            // Jika statusnya menjadi 'selesai', kirim pesan WhatsApp
            if ($status === 'selesai') {
                $pesan = "Halo *$nama_customer*,\n\nPesanan laundry Anda dengan kode transaksi *$kode_transaksi* sudah *selesai* dan siap diambil. Kami pastikan pakaian Anda bersih, wangi, dan rapi seperti baru.\n\nJangan lupa, pakaian yang terawat dengan baik bikin hari Anda lebih percaya diri. Terima kasih sudah mempercayakan laundry Anda kepada kami.\n\nKami tunggu kedatangan Anda!";

                // Kirim pesan menggunakan API UltraMsg
                $params = array(
                    'token' => 'grhbx2tnwi3z2fks', // Ganti dengan token Anda
                    'to' => $no_wa, // Nomor yang sudah diformat
                    'body' => $pesan
                );

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.ultramsg.com/instance108418/messages/chat",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => http_build_query($params),
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err) {
                    $_SESSION['alert'] = [
                        'type' => 'danger',
                        'title' => 'Peringatan!',
                        'message' => 'Gagal mengirim pesan: ' . $err
                    ];
                } else {
                    $_SESSION['alert'] = [
                        'type' => 'success',
                        'title' => 'Pesan Terkirim!',
                        'message' => 'Pesan WhatsApp berhasil dikirim.'
                    ];
                }
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'title' => 'Peringatan!',
                'message' => 'Gagal mengubah status transaksi.'
            ];
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Peringatan!',
            'message' => 'Transaksi tidak ditemukan.'
        ];
    }

    header("Location: index.php?id_transaksi=$id_transaksi");
    exit();
}

mysqli_close($conn);
