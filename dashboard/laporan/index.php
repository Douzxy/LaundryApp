<?php
include '../layout/header.php';

// Cek level pengguna
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'title' => 'Akses Ditolak!',
        'message' => 'Anda tidak memiliki akses untuk membuka halaman tersebut.'
    ];
    header("Location: ../index.php"); // Arahkan ke halaman utama
    exit();
}

displayAlert();

// Ambil data filter dari URL
$export_type = $_GET['export_type'] ?? 'all';
$single_date = $_GET['single_date'] ?? null;
$start_date  = $_GET['start_date'] ?? null;
$end_date    = $_GET['end_date'] ?? null;
$month_year  = $_GET['month_year'] ?? null;
$status      = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : null;

// Ambil data pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Tentukan jumlah transaksi per halaman
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);

// Hitung offset untuk query
$offset = ($page - 1) * $limit;

// Proses filter
$filter_query = "";
$filterText = "Filter: Semua data";

if ($export_type === 'per_hari' && !empty($single_date)) {
    $filter_query .= " AND DATE(t.tanggal) = '$single_date'";
    $filterText = "Filter: Tanggal: " . date('d-m-Y', strtotime($single_date));
} elseif ($export_type === 'per_periode' && !empty($start_date) && !empty($end_date)) {
    $filter_query .= " AND DATE(t.tanggal) BETWEEN '$start_date' AND '$end_date'";
    $filterText = "Filter: Dari: " . date('d-m-Y', strtotime($start_date)) . " s/d " . date('d-m-Y', strtotime($end_date));
} elseif ($export_type === 'per_bulan' && !empty($month_year)) {
    $filter_query .= " AND DATE_FORMAT(t.tanggal, '%Y-%m') = '$month_year'";
    $filterText = "Filter: Bulan: " . date('F Y', strtotime($month_year . '-01'));
}

// Tambahkan filter status jika ada
if (!empty($status)) {
    $filter_query .= " AND t.status = '$status'";
    $filterText .= " | Status: " . ucfirst($status);
}

// Hitung total pemasukan
$total_pemasukan_query = "
    SELECT SUM(dt.total_harga) as total 
    FROM transaksi t
    JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
    WHERE t.status_pembayaran = '1' AND t.status != 'baru' $filter_query
";
$total_pemasukan_result = mysqli_query($conn, $total_pemasukan_query);
$total_pemasukan = mysqli_fetch_assoc($total_pemasukan_result)['total'] ?? 0;

// Hitung total keseluruhan
$total_keseluruhan_query = "
    SELECT SUM(dt.total_harga) as total 
    FROM transaksi t
    JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
    WHERE t.status != 'baru' $filter_query
";
$total_keseluruhan_result = mysqli_query($conn, $total_keseluruhan_query);
$total_keseluruhan = mysqli_fetch_assoc($total_keseluruhan_result)['total'] ?? 0;

// Query data transaksi dengan filter dan pencarian
$detail_query = "
    SELECT t.status, t.tanggal, t.id_transaksi, t.kode_transaksi, t.status_pembayaran, 
           c.nama_customer, u.nama_user, 
           COUNT(dt.id_detail_transaksi) AS jumlah_item, SUM(dt.total_harga) AS total_transaksi
    FROM transaksi t
    JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
    JOIN customer c ON t.id_customer = c.id_customer
    JOIN user u ON t.id_user = u.id_user
    WHERE t.status != 'baru' 
    AND (t.kode_transaksi LIKE '%$search%' OR c.nama_customer LIKE '%$search%') 
    $filter_query
    GROUP BY t.id_transaksi, t.tanggal, t.kode_transaksi, t.status_pembayaran, 
             c.nama_customer, u.nama_user, t.status
    ORDER BY t.tanggal DESC
    LIMIT $limit OFFSET $offset
";
$detail_result = mysqli_query($conn, $detail_query);

// Hitung jumlah total transaksi
$total_laporan_query = "
    SELECT COUNT(*) as total 
    FROM transaksi t 
    JOIN customer c ON t.id_customer = c.id_customer 
    WHERE (t.kode_transaksi LIKE '%$search%' OR c.nama_customer LIKE '%$search%') 
    AND t.status != 'baru' 
    $filter_query
";
$total_laporan_result = mysqli_query($conn, $total_laporan_query);
$total_laporan = mysqli_fetch_assoc($total_laporan_result)['total'] ?? 0;

// Hitung total halaman
$total_pages = ceil($total_laporan / $limit);
$page = min($total_pages, $page);
$no = ($page - 1) * $limit + 1;
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
                            <li class="breadcrumb-item text-dark">Laporan</li>
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
                                <h1 class="h3 mb-0 text-gray-800">Dashboard Transaksi</h1>
                            </div>

                            <div class="col-auto d-flex">
                                <form action="<?= base_url ?>dashboard/laporan/export_excel.php" method="post" id="exportForm">
                                    <input type="hidden" name="export_type" value="<?= htmlspecialchars($export_type) ?>">
                                    <input type="hidden" name="single_date" value="<?= htmlspecialchars($single_date) ?>">
                                    <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                                    <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
                                    <input type="hidden" name="month_year" value="<?= htmlspecialchars($month_year) ?>">

                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-download me-2"></i> Unduh Laporan
                                    </button>
                                </form>

                                <button class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_filter_users">
                                    <i class="fas fa-filter me-2"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Transaction Table -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-column">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
                        <p class="text-muted mb-0"><?php echo $filterText ?? "Data per semua transaksi"; ?></p>
                    </div>

                    <div class="card-body">
                        <div class="bg-light border rounded shadow-sm d-flex justify-content-between">
                            <div>
                                <h5 class="text-primary">Total Pemasukan</h5>
                                <p class="fs-4"><strong>Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></strong>
                                    <br>
                                    <small class="text-muted">(Hanya transaksi yang sudah dibayar)</small>
                                </p>
                            </div>
                            <div>
                                <h5 class="text-primary">Total Keseluruhan</h5>
                                <p class="fs-4"><strong>Rp <?= number_format($total_keseluruhan, 0, ',', '.') ?></strong>
                                    <br>
                                    <small class="text-muted">(Semua transaksi termasuk yang belum dibayar)</small>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="col-auto d-flex gap-2">
                            <div class="mb-3 col-6 col-md-3 border rounded shadow-sm">
                                <div class="input-group">
                                    <label for="search" class="input-group-text bg-white border-0 cursor-pointer">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 21L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10 17C13.866 17 17 13.866 17 10C17 6.13401 13.866 3 10 3C6.13401 3 3 6.13401 3 10C3 13.866 6.13401 17 10 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </label>
                                    <input type="text" id="search" class="form-control border-0 shadow-none" placeholder="Cari laporan..." value="<?= htmlspecialchars($search) ?>">
                                </div>
                            </div>
                            <!-- Filter Section -->
                            <div class="mb-3 col-6 col-md-3">
                                <select id="filterStatus" class="form-select" data-control="select2" data-hide-search="true">
                                    <option value="">Semua Status</option>
                                    <option value="proses" <?= (isset($_GET['status']) && $_GET['status'] == 'proses') ? 'selected' : '' ?>>Proses</option>
                                    <option value="selesai" <?= (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                    <option value="diambil" <?= (isset($_GET['status']) && $_GET['status'] == 'diambil') ? 'selected' : '' ?>>Diambil</option>
                                </select>
                            </div>


                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" id="transactionTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Nama Petugas</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Item</th>
                                        <th>Status</th>
                                        <th>Status Pembayaran</th>
                                        <th>Total Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($detail_result)) :
                                        $status_class = '';
                                        switch ($row['status']) {
                                            case 'baru':
                                                $status_class = 'badge badge-light-primary fs-7 fw-bold';
                                                break;
                                            case 'proses':
                                                $status_class = 'badge badge-light-warning fs-7 fw-bold';
                                                break;
                                            case 'selesai':
                                                $status_class = 'badge badge-light-success fs-7 fw-bold';
                                                break;
                                            case 'diambil':
                                                $status_class = 'badge badge-light-info fs-7 fw-bold';
                                                break;
                                            default:
                                                $status_class = 'badge badge-light-secondary fs-7 fw-bold';
                                                break;
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $no?></td>
                                            <td><?= $row['kode_transaksi'] ?></td>
                                            <td><?= $row['nama_customer'] ?></td>
                                            <td><?= $row['nama_user'] ?></td>
                                            <td><?= date('d/m/Y H:i:s', strtotime($row['tanggal'])) ?></td>
                                            <td><?= number_format($row['jumlah_item']) ?></td>
                                            <td><span class='<?= $status_class ?>'><?= ucfirst($row['status']) ?></span></td>
                                            <td><span class='badge badge-light-<?= $row['status_pembayaran'] == 1 ? 'success' : 'danger' ?>'>
                                                    <?= $row['status_pembayaran'] == 1 ? 'Sudah Dibayar' : 'Belum Bayar' ?></span></td>
                                            <td>Rp <?= number_format($row['total_transaksi'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php
                                $no++;
                                endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-center mb-3 justify-content-between">
                            <div class="text-muted mb-3">
                                <?php
                                $start = ($total_laporan > 0) ? $offset + 1 : 0;
                                $end = ($total_laporan > 0) ? min($offset + $limit, $total_laporan) : 0;
                                ?>
                                Menampilkan data <?= $start ?> - <?= $end ?> dari <?= $total_laporan ?> data
                            </div>

                            <ul class="pagination mb-0">
                                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page > 1) ? base_url . "dashboard/laporan/index.php?page=" . ($page - 1) . "&search=" . urlencode($search) . "&export_type=" . urlencode($export_type) : '#' ?>" class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>

                                <?php if ($total_pages > 5): ?>
                                    <li class="page-item <?= ($page == 1) ? 'active' : '' ?>">
                                        <a href="<?= base_url ?>dashboard/laporan/index.php?page=1&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link">1</a>
                                    </li>
                                    <?php if ($page > 3): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($i = max(2, $page - 1); $i <= min($total_pages - 1, $page + 1); $i++): ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                            <a href="<?= base_url ?>dashboard/laporan/index.php?page=<?= $i ?>&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($page < $total_pages - 2): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item <?= ($page == $total_pages) ? 'active' : '' ?>">
                                        <a href="<?= base_url ?>dashboard/laporan/index.php?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link"><?= $total_pages ?></a>
                                    </li>
                                <?php else: ?>
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                            <a href="<?= base_url ?>dashboard/laporan/index.php?page=<?= $i ?>&search=<?= urlencode($search) ?>&export_type=<?= urlencode($export_type) ?>" class="page-link"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                <?php endif; ?>

                                <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page < $total_pages) ? base_url . "dashboard/laporan/index.php?page=" . ($page + 1) . "&search=" . urlencode($search) . "&export_type=" . urlencode($export_type) : '#' ?>" class="page-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            let timeout = null;

                            function updateURL() {
                                const searchValue = $('#search').val().toLowerCase();
                                const statusValue = $('#filterStatus').val();

                                // Ambil semua parameter dari URL
                                const urlParams = new URLSearchParams(window.location.search);
                                const exportType = urlParams.get('export_type') || 'all';
                                const singleDate = urlParams.get('single_date') || '';
                                const startDate = urlParams.get('start_date') || '';
                                const endDate = urlParams.get('end_date') || '';
                                const monthYear = urlParams.get('month_year') || '';

                                // Bangun query string dengan semua parameter filter
                                let queryString = `search=${encodeURIComponent(searchValue)}&export_type=${encodeURIComponent(exportType)}`;

                                if (singleDate) queryString += `&single_date=${encodeURIComponent(singleDate)}`;
                                if (startDate && endDate) queryString += `&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
                                if (monthYear) queryString += `&month_year=${encodeURIComponent(monthYear)}`;
                                if (statusValue) queryString += `&status=${encodeURIComponent(statusValue)}`;

                                // Redirect ke halaman dengan query string baru
                                window.location.href = `<?= base_url ?>dashboard/laporan/index.php?${queryString}`;
                            }

                            // Event handler untuk pencarian
                            $('#search').on('keyup', function() {
                                clearTimeout(timeout);
                                timeout = setTimeout(updateURL, 1000);
                            });

                            // Event handler untuk filter status
                            $('#filterStatus').on('change', function() {
                                updateURL();
                            });

                            // Fokus ke input search jika sebelumnya sudah ada pencarian
                            const urlParams = new URLSearchParams(window.location.search);
                            if (urlParams.has('search')) {
                                $('#search').focus();
                                $('#search')[0].setSelectionRange($('#search').val().length, $('#search').val().length);
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Filter -->
<div class="modal fade" id="kt_modal_filter_users" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Filter Data</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <form id="kt_modal_export_form" class="form" action="" method="get">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Tipe Data</label>
                        <div class="col-lg-8">
                            <select name="export_type" id="export_type" class="form-select form-select-solid" required>
                                <option value="all" <?= ($export_type === 'all') ? 'selected' : '' ?>>Semua Data</option>
                                <option value="per_hari" <?= ($export_type === 'per_hari') ? 'selected' : '' ?>>Per Hari</option>
                                <option value="per_bulan" <?= ($export_type === 'per_bulan') ? 'selected' : '' ?>>Per Bulan</option>
                                <option value="per_periode" <?= ($export_type === 'per_periode') ? 'selected' : '' ?>>Per Periode</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input untuk Per Hari -->
                    <div class="row mb-6 filter-group" id="date_single" style="display: <?= ($export_type === 'per_hari') ? 'block' : 'none'; ?>">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="single_date">Tanggal</label>
                        <div class="col-lg-8">
                            <input class="form-control form-control-solid" type="date" name="single_date" id="single_date" value="<?= htmlspecialchars($single_date) ?>" required />
                        </div>
                    </div>

                    <!-- Input untuk Per Periode -->
                    <div class="row mb-6 filter-group" id="date_range" style="display: <?= ($export_type === 'per_periode') ? 'block' : 'none'; ?>">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="start_date">Tanggal Mulai</label>
                        <div class="col-lg-8">
                            <input class="form-control form-control-solid" type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>" required />
                        </div>
                    </div>

                    <div class="row mb-6 filter-group" id="date_end" style="display: <?= ($export_type === 'per_periode') ? 'block' : 'none'; ?>">
                        <label class="col-lg-4 col-form-label fw-bold fs-6 required" for="end_date">Tanggal Akhir</label>
                        <div class="col-lg-8">
                            <input class="form-control form-control-solid" type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>" required />
                        </div>
                    </div>

                    <!-- Input untuk Per Bulan -->
                    <div class="row mb-6 filter-group" id="month_picker" style="display: <?= ($export_type === 'per_bulan') ? 'block' : 'none'; ?>">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6" for="month_year">Pilih Bulan</label>
                        <div class="col-lg-8">
                            <input class="form-control form-control-solid" type="month" name="month_year" id="month_year" value="<?= htmlspecialchars($month_year) ?>" required />
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12 text-end">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportType = document.getElementById('export_type');
        const dateSingle = document.getElementById('date_single');
        const dateRange = document.getElementById('date_range');
        const dateEnd = document.getElementById('date_end');
        const monthPicker = document.getElementById('month_picker');
        const form = document.getElementById('kt_modal_export_form');

        function toggleFilters() {
            const selectedValue = exportType.value;

            dateSingle.style.display = selectedValue === 'per_hari' ? 'flex' : 'none';
            dateRange.style.display = selectedValue === 'per_periode' ? 'flex' : 'none';
            dateEnd.style.display = selectedValue === 'per_periode' ? 'flex' : 'none';
            monthPicker.style.display = selectedValue === 'per_bulan' ? 'flex' : 'none';

            // Hapus required dari elemen yang tidak aktif
            document.getElementById('single_date').required = (selectedValue === 'per_hari');
            document.getElementById('start_date').required = (selectedValue === 'per_periode');
            document.getElementById('end_date').required = (selectedValue === 'per_periode');
            document.getElementById('month_year').required = (selectedValue === 'per_bulan');
        }

        toggleFilters();
        exportType.addEventListener('change', toggleFilters);

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const selectedValue = exportType.value;
            let isValid = true;
            let queryString = "";

            if (selectedValue === 'per_hari') {
                const singleDate = document.getElementById('single_date').value;
                if (!singleDate) {
                    alert('Tanggal harus diisi untuk tipe data Per Hari.');
                    isValid = false;
                } else {
                    queryString += `&single_date=${encodeURIComponent(singleDate)}`;
                }
            } else if (selectedValue === 'per_periode') {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                if (!startDate || !endDate) {
                    alert('Tanggal mulai dan akhir harus diisi untuk tipe data Per Periode.');
                    isValid = false;
                } else {
                    queryString += `&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
                }
            } else if (selectedValue === 'per_bulan') {
                const monthYear = document.getElementById('month_year').value;
                if (!monthYear) {
                    alert('Bulan harus dipilih untuk tipe data Per Bulan.');
                    isValid = false;
                } else {
                    queryString += `&month_year=${encodeURIComponent(monthYear)}`;
                }
            }

            if (!isValid) return;

            const searchParam = new URLSearchParams(window.location.search).get('search') || '';
            queryString = `search=${encodeURIComponent(searchParam)}&export_type=${selectedValue}` + queryString;

            window.location.href = `<?= base_url ?>dashboard/laporan/index.php?${queryString}`;
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#export_type').select2({
            minimumResultsForSearch: -1
        }).on('change', function() {
            const selectedValue = $(this).val();
            // Sembunyikan semua opsi terlebih dahulu
            $('#date_single, #date_range, #date_end, #month_picker').hide();

            if (selectedValue === 'per_hari') {
                $('#date_single').show(); // Hanya tampilkan input tanggal
            } else if (selectedValue === 'per_periode') {
                $('#date_range, #date_end').show(); // Tampilkan Tanggal Mulai dan Akhir
            } else if (selectedValue === 'per_bulan') {
                $('#month_picker').show(); // Tampilkan input Bulan & Tahun
            }
        });
    });
</script>


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