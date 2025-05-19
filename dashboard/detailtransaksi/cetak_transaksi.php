<?php include '../layout/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cetak Laporan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            color: black; /* Set text color to black */
            background-color: white; /* Set background color to white */
        }

        .container {
            flex: 1;
        }

        footer {
            background-color: white; /* Ensure footer is white */
            padding: 20px 0;
            margin-top: auto;
            color: black; /* Set footer text color to black */
        }

        h2, h3, h4 {
            color: black; /* Ensure headings are black */
        }

        .text-muted {
            color: black; /* Set muted text color to black */
        }

        .bg-light-dark {
            background-color: white; /* Set background of list to white */
            color: black; /* Set text color to black */
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="text-center mb-4">
            <!-- <img src="<?= base_url ?>assets/img/logo.png" alt="Logo" class="img-fluid" style="width: 120px; margin-bottom: 20px;"> -->
            <h2 class="display-5 fw-bold mb-3">INVOICE TRANSAKSI LAUNDRY</h2>
            <h3 class="text-uppercase mb-2" style="letter-spacing: 2px; font-weight: 600;">Freshlt Laundry</h3>
            <div class="text-muted mb-1" style="font-size: 16px;">
                Email: laundry@gmail.com
            </div>
            <div class="text-muted" style="font-size: 16px;">
                Telepon: 0896-1226-4122
            </div>
        </div>
        <hr class="my-4">

        <div class="d-flex justify-content-between mb-4">
            <?php
            // Mendapatkan id_transaksi dari parameter GET
            $id_transaksi = $_GET['id_transaksi'];

            // Query untuk mengambil nama_customer berdasarkan id_transaksi
            $query = "SELECT c.nama_customer 
                      FROM transaksi t 
                      JOIN customer c ON t.id_customer = c.id_customer 
                      WHERE t.id_transaksi = $id_transaksi";

            // Eksekusi query
            $result = mysqli_query($conn, $query);

            // Ambil data nama_customer
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $nama_customer = $row['nama_customer'] ?? "Pelanggan tidak ditemukan.";
            } else {
                $nama_customer = "Terjadi kesalahan dalam query.";
            }
            ?>

            <div>
                <h4>Pelanggan: <?= htmlspecialchars($nama_customer) ?></h4>
            </div>
            <div class="text-muted">
                <?php
                $hari = array(
                    'Sunday'    => 'Minggu',
                    'Monday'    => 'Senin',
                    'Tuesday'   => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday'  => 'Kamis',
                    'Friday'    => 'Jumat',
                    'Saturday'  => 'Sabtu'
                );

                $bulan = array(
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                );

                $hari_ini = date('l');
                $tanggal = date('d');
                $bulan_ini = date('m');
                $tahun = date('Y');

                $hari_indonesia = $hari[$hari_ini];
                $bulan_indonesia = $bulan[$bulan_ini];

                echo $hari_indonesia . ', ' . $tanggal . ' ' . $bulan_indonesia . ' ' . $tahun;
                ?>
            </div>
        </div>

        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal Transaksi</th>
                    <th class="text-center">Paket Laundry</th>
                    <th class="text-center">Berat Cucian</th>
                    <th class="text-center">Harga/Kg</th>
                    <th class="text-center">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM transaksi 
                                             JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi 
                                             JOIN jenis_cucian ON jenis_cucian.id_jenis_cucian = detail_transaksi.id_jenis_cucian 
                                             WHERE transaksi.id_transaksi = " . $_GET['id_transaksi']);
                $no = 0;
                $grandTotal = 0;
                while ($data = mysqli_fetch_array($query)) {
                    $harga = $data['harga'];
                    $qty = $data['qty'];
                    $total = $harga * $qty;
                    $grandTotal += $total;
                    $no++;
                    $tanggal = date('d F Y H:i:s', strtotime($data['tanggal']));
                ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center"><?= $tanggal ?></td>
                        <td class="text-center"><?= $data['nama_jenis_cucian'] ?></td>
                        <td class="text-center"><?= $data['qty'] ?> Kg</td>
                        <td class="text-center">Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                        <td class="text-center">Rp <?= number_format($total, 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-end fw-bold">
            Total: <span>Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
        </div>
    </div>

    <footer>
        <div class="container">
            <h4>Keterangan :</h4>
            <ol class="bg-light-dark p-5 rounded-3">
                <li>Pekerjaan dilakukan sesuai jam kerja yaitu hari Senin – Sabtu dari pukul 07:00 – 19:00. Diluar jam tersebut, maka pekerjaan tidak dilakukan. Hari minggu tidak dihitung sebagai hari layanan.</li>
                <li>Jumlah berat yang ditimbang dan dijadikan nota adalah jumlah berat yang diterima pada saat diterima baik basah maupun kering.</li>
                <li>Bukti tagihan yang sah di dalam transaksi kami adalah melalui nota digital atau nota fisik.</li>
                <li>Kami tidak bertanggung jawab apabila terjadi kehilangan / kerusakan pada laundry bersih yang tidak diambil selama 1 bulan di workshop kami.</li>
                <li>Kami menggunakan bahan detergent dan parfum dengan standar laundry tanpa mengetahui jenis alergi yang anda miliki. Segala jenis penggunaan sabun atau parfum milik pribadi tidak diperkenankan untuk digunakan di laundry kami dan apabila terjadi reaksi alergi pada kulit bukan menjadi tanggung jawab FamilyLaundry.</li>
                <li>Pengaduan harap disampaikan secara tertulis di ke email familylaundry@gmail.com dengan melampirkan nomor nota, video unboxing serta keluhan yang dialami.</li>
            </ol>
            <div class="text-center mt-4">
                &copy; <?= date('Y'); ?> Family Laundry. Hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <script>
        window.onafterprint = function() {
            window.location.href = 'detailtransaksi/index.php?id_transaksi=<?= $_GET['id_transaksi'] ?>';
        };

        window.onbeforeprint = function() {
            console.log("Printing Proses...");
        };

        window.print();
    </script>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>