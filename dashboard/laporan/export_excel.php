<?php
require '../../vendor/autoload.php'; // Ensure the path is correct

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

include "../koneksi.php";
session_start();

// Check user level
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Akses Ditolak!',
        'message' => 'Anda tidak memiliki akses untuk membuka halaman tersebut.'
    ];
    header("Location: ../index.php"); // Redirect to the main page
    exit();
}

// Get filters from request
$export_type = $_POST['export_type'] ?? 'all';
$single_date = $_POST['single_date'] ?? null;
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
$month_year = $_POST['month_year'] ?? null;

// Create query based on filter
$filter_query = "";
$filename_suffix = "Semua";
$report_title = "Laporan Transaksi"; // Variable to store report title

if ($export_type === 'per_hari' && !empty($single_date)) {
    $filter_query = "WHERE DATE(t.tanggal) = '" . mysqli_real_escape_string($conn, $single_date) . "'";
    $filename_suffix = str_replace('-', '_', $single_date);
    $report_title = "Laporan Transaksi Tanggal: " . date('d/m/Y', strtotime($single_date)); // Title for daily report
} elseif ($export_type === 'per_periode' && !empty($start_date) && !empty($end_date)) {
    $filter_query = "WHERE DATE(t.tanggal) BETWEEN '" . mysqli_real_escape_string($conn, $start_date) . "' AND '" . mysqli_real_escape_string($conn, $end_date) . "'";
    $filename_suffix = str_replace('-', '_', $start_date) . "_-_" . str_replace('-', '_', $end_date);
    $report_title = "Laporan Transaksi Periode: " . date('d/m/Y', strtotime($start_date)) . " s/d " . date('d/m/Y', strtotime($end_date)); // Title for period report
} elseif ($export_type === 'per_bulan' && !empty($month_year)) {
    $filter_query = "WHERE DATE_FORMAT(t.tanggal, '%Y-%m') = '" . mysqli_real_escape_string($conn, $month_year) . "'";
    $filename_suffix = str_replace('-', '_', $month_year);
    $report_title = "Laporan Transaksi Bulan: " . date('F Y', strtotime($month_year . '-01')); // Title for monthly report
}

// Transaction query
$detail_query = "SELECT 
    t.tanggal,
    t.kode_transaksi,
    c.nama_customer,
    u.nama_user,
    COUNT(dt.id_detail_transaksi) AS jumlah_item,
    SUM(dt.total_harga) AS total_transaksi,
    t.status,
    t.status_pembayaran
FROM transaksi t
JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
JOIN customer c ON t.id_customer = c.id_customer
JOIN user u ON t.id_user = u.id_user
$filter_query
GROUP BY t.id_transaksi, c.nama_customer, u.nama_user
ORDER BY t.tanggal DESC";

$result = mysqli_query($conn, $detail_query);
if (mysqli_num_rows($result) === 0) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Data Tidak Ditemukan!',
        'message' => 'Tidak ada data transaksi yang tersedia.'
    ];
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add report title at the top
$sheet->setCellValue('A1', $report_title);
$sheet->mergeCells('A1:I1'); // Merge cells for the title
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Set font style
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Center align the title

// Header columns
$headers = ['No', 'Kode Transaksi', 'Nama Pelanggan', 'Nama Petugas', 'Tanggal', 'Jumlah Item', 'Status', 'Status Pembayaran', 'Total Transaksi'];
$sheet->fromArray($headers, null, 'A2'); // Set header starting from row 2

// Styling Header
$sheet->getStyle('A2:I2')->getFont()->setBold(true);
$sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:I2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Set data
$rowNumber = 3; // Start data from row 3
$total_pemasukan = 0;
$total_keseluruhan = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $status_pembayaran_text = ($row['status_pembayaran'] == 1) ? 'Sudah Dibayar' : 'Belum Bayar';
    if ($row['status_pembayaran'] == 1) {
        $total_pemasukan += $row['total_transaksi']; // Only for paid transactions
    }
    $total_keseluruhan += $row['total_transaksi']; // All transactions

    $data = [
        $rowNumber - 2, // Row number
        $row['kode_transaksi'],
        $row['nama_customer'],
        $row['nama_user'],
        date('d/m/Y H:i', strtotime($row['tanggal'])),
        $row['jumlah_item'],
        ucfirst($row['status']),
        $status_pembayaran_text,
        'Rp ' . number_format($row['total_transaksi'], 0, ',', '.')
    ];

    $sheet->fromArray($data, null, "A$rowNumber");

    // Apply border to the row
    $sheet->getStyle("A$rowNumber:I$rowNumber")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    $rowNumber++;
}

// Total pemasukan dan keseluruhan
$sheet->setCellValue("H$rowNumber", "Total Pemasukan");
$sheet->setCellValue("I$rowNumber", 'Rp ' . number_format($total_pemasukan, 0, ',', '.'));
$sheet->getStyle("H$rowNumber:I$rowNumber")->getFont()->setBold(true);
$sheet->getStyle("H$rowNumber:I$rowNumber")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

$rowNumber++;
$sheet->setCellValue("H$rowNumber", "Total Keseluruhan");
$sheet->setCellValue("I$rowNumber", 'Rp ' . number_format($total_keseluruhan, 0, ',', '.'));
$sheet->getStyle("H$rowNumber:I$rowNumber")->getFont()->setBold(true);
$sheet->getStyle("H$rowNumber:I$rowNumber")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Auto-size columns
foreach (range('A', 'I') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Save file as Excel
$filename = "Laporan_Transaksi_" . $filename_suffix . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
