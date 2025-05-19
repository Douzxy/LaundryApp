<?php
include '../layout/header.php';

// Cek level pengguna
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Akses Ditolak!',
        'message' => 'Anda tidak memiliki akses untuk membuka halaman tersebut.'
    ];
    header("Location: ../index.php");
    exit();
}

displayAlert();

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = !empty($search) ? "AND (c.nama_customer LIKE '%$search%' OR c.no_telp LIKE '%$search%' OR c.alamat LIKE '%$search%')" : "";

// Get filter parameters
$export_type = isset($_GET['export_type']) ? $_GET['export_type'] : 'all';
$single_date = isset($_GET['single_date']) ? $_GET['single_date'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$month_year = isset($_GET['month_year']) ? $_GET['month_year'] : '';

// Build date query based on filter (DIKOMENTARI KARENA KOLOM TIDAK ADA)
$date_query = "";
// if ($export_type == 'single' && !empty($single_date)) {
//     $date_query = "AND DATE(c.tanggal_daftar) = '$single_date'";
// } else if ($export_type == 'range' && !empty($start_date) && !empty($end_date)) {
//     $date_query = "AND DATE(c.tanggal_daftar) BETWEEN '$start_date' AND '$end_date'";
// } else if ($export_type == 'month' && !empty($month_year)) {
//     $date_query = "AND DATE_FORMAT(c.tanggal_daftar, '%Y-%m') = '$month_year'";
// }

// Query untuk menghitung total data
$count_query = "SELECT COUNT(*) as total FROM customer c 
            WHERE 1=1 $search_query $date_query";
$count_result = mysqli_query($conn, $count_query);
$total_row = mysqli_fetch_assoc($count_result);
$total_customers = $total_row['total'];
$total_pages = ceil($total_customers / $limit);

// Query untuk mendapatkan data customer
$customer_query = "SELECT 
                c.id_customer,
                c.nama_customer,
                c.alamat,
                c.jenis_kelamin,
                c.no_telp
            FROM 
                customer c
            LEFT JOIN 
                transaksi t ON c.id_customer = t.id_customer
            WHERE 
                1=1 $search_query $date_query
            GROUP BY 
                c.id_customer
            ORDER BY 
                c.nama_customer ASC
            LIMIT $offset, $limit";

$customer_result = mysqli_query($conn, $customer_query);
$no = $offset + 1;
?>
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <?php include '../layout/sidebar.php'; ?>

        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                        <h1 class="text-dark fw-bolder my-1 fs-2">Laundry App</h1>
                        <ul class="breadcrumb fw-bold fs-base my-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="index.php" class="text-muted">Beranda</a>
                            </li>
                            <li class="breadcrumb-item text-muted">Admin</li>
                            <li class="breadcrumb-item text-dark">Laporan Customer</li>
                        </ul>
                    </div>
                    <div class="d-flex d-lg-none align-items-center ms-n2 me-2 w-100 justify-content-between">
                        <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                        <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                            </span>
                        </div>
                        <a href="index.php" class="d-flex align-items-center">
                            <img alt="Logo" src="<?= base_url ?>assets/img/logo.png" class="h-30px" />
                        </a>
                    </div>
                    <div class="d-flex align-items-stretch flex-shrink-0">
                        <div class="d-flex align-items-stretch ms-1 ms-lg-3">
                            <div id="kt_header_search" class="d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid px-4">
                <div class="card shadow mb-4">
                    <div class="card-body p-5 bg-light-primary">
                        <div class="row align-items-center">
                            <div class="col">
                                <h1 class="h3 mb-0 text-gray-800">Laporan Customer</h1>
                            </div>

                            <div class="col-auto d-flex">
                                <form action="<?= base_url ?>dashboard/laporan/export_customer_excel.php" method="post" id="exportForm">
                                    <input type="hidden" name="export_type" value="<?= htmlspecialchars($export_type) ?>">
                                    <input type="hidden" name="single_date" value="<?= htmlspecialchars($single_date) ?>">
                                    <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                                    <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
                                    <input type="hidden" name="month_year" value="<?= htmlspecialchars($month_year) ?>">

                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-download me-2"></i> Unduh Laporan Customer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Table -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="col-auto d-flex gap-2">
                            <div class="mb-3 col-6 col-md-3 border rounded shadow-sm">
                                <div class="input-group">
                                    <label for="search" class="input-group-text bg-white border-0 cursor-pointer">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 21L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10 17C13.866 17 17 13.866 17 10C17 6.13401 13.866 3 10 3C6.13401 3 3 6.13401 3 10C3 13.866 6.13401 17 10 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </label>
                                    <input type="text" id="search" class="form-control border-0 shadow-none" placeholder="Cari customer..." value="<?= htmlspecialchars($search) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" id="customerTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Customer</th>
                                        <th>Alamat</th>
                                        <th>Nomor Telepon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($customer_result)) : ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $row['nama_customer'] ?></td>
                                            <td><?= $row['alamat'] ?></td>
                                            <td><?= $row['no_telp'] ?></td>

                                        </tr>
                                    <?php
                                        $no++;
                                    endwhile; ?>

                                    <?php if (mysqli_num_rows($customer_result) == 0): ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="<?= base_url ?>assets/img/no-data.svg" alt="No Data" width="120" class="mb-3">
                                                    <h6 class="text-muted">Data tidak ditemukan</h6>
                                                    <p class="text-muted small">Coba ubah filter atau kata kunci pencarian Anda</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-center mb-3 justify-content-between">
                            <div class="text-muted mb-3">
                                <?php
                                $start = ($total_customers > 0) ? $offset + 1 : 0;
                                $end = ($total_customers > 0) ? min($offset + $limit, $total_customers) : 0;
                                ?>
                                Menampilkan data <?= $start ?> - <?= $end ?> dari <?= $total_customers ?> data
                            </div>

                            <ul class="pagination mb-0">
                                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page > 1) ? base_url . "dashboard/laporan/customer.php?page=" . ($page - 1) . "&search=" . urlencode($search) . "&export_type=" . urlencode($export_type) : '#' ?>" class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>

                                <?php if ($total_pages > 5): ?>
                                    <li class="page-item <?= ($page == 1) ? 'active' : '' ?>">
                                        <a href="<?= base_url ?>dashboard/laporan/customer.php?page=1&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link">1</a>
                                    </li>
                                    <?php if ($page > 3): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($i = max(2, $page - 1); $i <= min($total_pages - 1, $page + 1); $i++): ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                            <a href="<?= base_url ?>dashboard/laporan/customer.php?page=<?= $i ?>&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($page < $total_pages - 2): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item <?= ($page == $total_pages) ? 'active' : '' ?>">
                                        <a href="<?= base_url ?>dashboard/laporan/customer.php?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link"><?= $total_pages ?></a>
                                    </li>
                                <?php else: ?>
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                            <a href="<?= base_url ?>dashboard/laporan/customer.php?page=<?= $i ?>&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                <?php endif; ?>

                                <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page < $total_pages) ? base_url . "dashboard/laporan/customer.php?page=" . ($page + 1) . "&search=" . urlencode($search) . "&export_type=" . urlencode($export_type) : '#' ?>" class="page-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- JavaScript untuk Pencarian -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            let timeout = null; // Variabel untuk menyimpan timeout

                            $('#search').on('keyup', function() {
                                clearTimeout(timeout); // Hapus timeout sebelumnya
                                const value = $(this).val().toLowerCase();

                                // Set timeout untuk menunggu 1 detik sebelum melakukan pencarian
                                timeout = setTimeout(function() {
                                    // Redirect ke URL dengan query string
                                    window.location.href = "<?= base_url ?>dashboard/laporan/customer.php?search=" + encodeURIComponent(value);
                                }, 1000); // 1000 ms = 1 detik
                            });

                            $('#clearSearch').on('click', function() {
                                $('#search').val('');
                                $('#search').trigger('keyup');
                            });

                            // Fokus pada input pencarian jika ada parameter pencarian
                            if ("<?= isset($_GET['search']) ? 'true' : 'false' ?>" === 'true') {
                                $('#search').focus();
                                $('#search')[0].setSelectionRange($('#search').val().length, $('#search').val().length); // Set kursor di akhir
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- Scrolltop -->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points=" 0 0 24 0 24 24 0 24"></polygon>
                <rect fill="#000000" opacity="0.5" x="11" y="10 " width="2" height="10" rx="1"></rect>
                <path fill="#000000" fill-rule="nonzero" d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5 .29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"></path>
            </g>
        </svg>
    </span>
</div>

<?php include '../layout/footer.php'; ?>