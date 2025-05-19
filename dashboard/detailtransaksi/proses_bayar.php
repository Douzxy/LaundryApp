<?php
include '../koneksi.php';
session_start();

$id_transaksi = $_POST['id_transaksi'];
$total_harga = str_replace('Rp.', '', $_POST['total_harga']);
$total_bayar = $_POST['total_bayar'];

if ($total_bayar < $total_harga) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Gagal!',
        'message' => 'Nominal tidak mencukupi.'
    ];
    header("Location: index.php?id_transaksi=$id_transaksi");
    exit();
}

// Cek status transaksi sebelum update
$query_status = "SELECT status FROM transaksi WHERE id_transaksi = $id_transaksi";
$result_status = mysqli_query($conn, $query_status);
$row = mysqli_fetch_assoc($result_status);
$status_sekarang = $row['status'] ?? '';

// Siapkan query update
$query_update = "UPDATE transaksi SET status_pembayaran = '1'";

// Jika status bukan "selesai", ubah menjadi "proses"
if ($status_sekarang !== 'selesai') {
    $query_update .= ", status = 'proses'";
}

$query_update .= " WHERE id_transaksi = $id_transaksi;";

// Update detail transaksi
$query_detail = "UPDATE detail_transaksi SET total_bayar = '$total_harga' WHERE id_transaksi = $id_transaksi;";

// Jalankan query update transaksi dan detail transaksi
if (!mysqli_query($conn, $query_update) || !mysqli_query($conn, $query_detail)) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Gagal!',
        'message' => 'Terjadi kesalahan saat memperbarui status pembayaran: ' . mysqli_error($conn)
    ];
} else {
    if ($total_bayar == $total_harga) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Transaksi berhasil dibayar.'
        ];
    } else {
        $kembalian = number_format($total_bayar - $total_harga, 0, ',', '.');
        $_SESSION['alert_kembalian'] = "Transaksi berhasil dibayar. Kembalian: Rp. $kembalian";
    }
}

// Redirect ke halaman transaksi
header("Location: index.php?id_transaksi=$id_transaksi");
exit();
