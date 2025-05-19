<?php
require '../../vendor/autoload.php'; // Ensure the path is correct

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

include "../koneksi.php"; // Include your database connection file
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

// Query to get all customer data sorted A-Z
$customer_query = "
    SELECT 
        nama_customer, 
        alamat, 
        jenis_kelamin, 
        no_telp 
    FROM customer
    ORDER BY nama_customer ASC
";

$result = mysqli_query($conn, $customer_query);
if (mysqli_num_rows($result) === 0) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Data Tidak Ditemukan!',
        'message' => 'Tidak ada data customer yang tersedia.'
    ];
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add report title at the top
$report_title = "Laporan Data Customer";
$sheet->setCellValue('A1', $report_title);
$sheet->mergeCells('A1:E1'); // Merge cells for the title
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Set font style
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Center align the title

// Header columns (dengan No Urut)
$headers = ['No', 'Nama Customer', 'Alamat', 'Jenis Kelamin', 'No Telepon'];
$sheet->fromArray($headers, null, 'A2'); // Set header starting from row 2

// Styling Header
$sheet->getStyle('A2:E2')->getFont()->setBold(true);
$sheet->getStyle('A2:E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Set data
$rowNumber = 3; // Start data from row 3
$no = 1; // No Urut

while ($row = mysqli_fetch_assoc($result)) {
    // Konversi jenis kelamin
    $jenis_kelamin = ($row['jenis_kelamin'] === 'l') ? 'Laki-Laki' : 'Perempuan';

    $data = [
        $no, // No Urut
        $row['nama_customer'],
        $row['alamat'],
        $jenis_kelamin,
        $row['no_telp']
    ];

    $sheet->fromArray($data, null, "A$rowNumber");

    // Apply border to the row
    $sheet->getStyle("A$rowNumber:E$rowNumber")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    $rowNumber++;
    $no++; // Increment No Urut
}

// Auto-size columns
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Save file as Excel
$filename = "Laporan_Data_Customer.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
