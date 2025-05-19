<?php
session_start();
include "../koneksi.php";

if ($_POST) {
    $id_transaksi = $_POST['id_transaksi'];
    $id_jenis_cucian = $_POST['jenis_cucian'];
    $qty = $_POST['qty'];
    $total_harga = $_POST['total_harga'];

    if (empty($id_transaksi)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'ID Transaksi tidak boleh kosong.'
        ];
    } elseif (empty($id_jenis_cucian)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Jenis Cucian tidak boleh kosong.'
        ];
    } elseif (empty($qty)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Berat/Jumlah tidak boleh kosong.'
        ];
    } elseif (empty($total_harga)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Total Harga tidak boleh kosong.'
        ];
    } else {
        // Cek apakah jenis cucian sudah ada dalam transaksi
        $check_sql = "SELECT qty, total_harga FROM detail_transaksi 
                      WHERE id_transaksi = '$id_transaksi' 
                      AND id_jenis_cucian = '$id_jenis_cucian'";
        $result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($result) > 0) {
            // Jika ada, update data qty dan total_harga
            $row = mysqli_fetch_assoc($result);
            $new_qty = $row['qty'] + $qty;
            $new_total_harga = $row['total_harga'] + $total_harga;

            $update_sql = "UPDATE detail_transaksi 
                           SET qty = '$new_qty', total_harga = '$new_total_harga' 
                           WHERE id_transaksi = '$id_transaksi' 
                           AND id_jenis_cucian = '$id_jenis_cucian'";
            if (mysqli_query($conn, $update_sql)) {
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'title' => 'Berhasil!',
                    'message' => 'Sukses memperbarui layanan transaksi.'
                ];
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'title' => 'Error!',
                    'message' => 'Gagal memperbarui layanan transaksi.'
                ];
            }
        } else {
            // Jika tidak ada, lakukan insert
            $sql = "INSERT INTO detail_transaksi (id_transaksi, id_jenis_cucian, qty, total_harga) 
                    VALUES ('$id_transaksi', '$id_jenis_cucian', '$qty', '$total_harga')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'title' => 'Berhasil!',
                    'message' => 'Sukses menambahkan layanan transaksi.'
                ];
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'title' => 'Error!',
                    'message' => 'Gagal menambahkan layanan transaksi.'
                ];
            }
        }
    }

    header("Location: index.php?id_transaksi=$id_transaksi");
    exit();
}
mysqli_close($conn);
