<?php

include "layout/header.php";

$id_user = $_SESSION['id_user'];
displayAlert();
?>

<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
	<!--begin::Page-->
	<div class="page d-flex flex-row flex-column-fluid">
		<?php include "layout/sidebar.php"; ?>
		<!--begin::Wrapper-->
		<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
			<!--begin::Header-->
			<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
				<!--begin::Container-->
				<div class="container-fluid d-flex align-items-stretch justify-content-between" id="kt_header_container">
					<!--begin::Page title-->
					<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
						<!--begin::Heading-->
						<h1 class="text-dark fw-bolder my-0 fs-2">Dashboard
						</h1>
						<!--end::Heading-->
						<!--begin::Breadcrumb-->
						<ul class="breadcrumb fw-bold fs-base my-1">
							<li class="breadcrumb-item text-muted">
								<a href="dashboard/index.php" class="text-muted">Beranda</a>
							</li>
							<li class="breadcrumb-item text-dark">Dashboard</li>
						</ul>
						<!--end::Breadcrumb-->
					</div>
					<!--end::Page title=-->
					<!--begin::Wrapper-->
					<div class="d-flex d-lg-none align-items-center ms-n2 me-2 w-100 justify-content-between">
						<!--begin::Aside mobile toggle-->
						<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
							<!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
							<span class="svg-icon svg-icon-2x">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
										<path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
									</g>
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Aside mobile toggle-->
						<!--begin::Logo-->
						<a href="dashboard/index.php" class="d-flex align-items-center">
							<img alt="Logo" src="<?= base_url ?>assets/img/logo.png" class="h-30px" />
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Wrapper-->
					<!--begin::Toolbar wrapper-->
					<div class="d-flex align-items-stretch flex-shrink-0">
						<!--begin::Search-->
						<div class="d-flex align-items-stretch ms-1 ms-lg-3">
							<!--begin::Search-->
							<div id="kt_header_search" class="d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
							</div>
							<!--end::Search-->
						</div>
						<!--end::Search-->
					</div>
					<!--end::Toolbar wrapper-->
				</div>
				<!--end::Container-->
			</div>
			<!--end::Header-->

			<!--begin::Content-->
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				<!--begin::Container-->
				<div class="container" id="kt_content_container">

					<!-- Main Stats Overview -->
					<div class="row g-5 gx-xxl-8 mb-5">
						<!-- Financial Summary Cards -->
						<div class="col-xl-3">
							<div class="card card-xl-stretch mb-5 mb-xl-8 bg-primary bg-opacity-10 border-0 shadow-sm hover-elevate-up">
								<div class="card-body d-flex flex-column">
									<div class="d-flex align-items-center">
										<span class="symbol symbol-50px me-2">
											<span class="symbol-label bg-primary bg-opacity-70 rounded-circle">
												<i class="fas fa-money-bill-wave text-white fs-1"></i>
											</span>
										</span>
										<div>
											<p class="text-dark fw-bolder fs-6 mb-0">Total Pemasukan</p>
											<?php
											$level_user = $_SESSION['level'];
											if ($level_user == 'admin') {
												$total_query = "SELECT SUM(dt.total_harga) as total 
                    FROM detail_transaksi dt 
                    JOIN transaksi t ON dt.id_transaksi = t.id_transaksi 
                    WHERE t.status_pembayaran = '1' AND status != 'baru'";
											} else {
												$total_query = "SELECT SUM(dt.total_harga) as total 
                    FROM detail_transaksi dt 
                    JOIN transaksi t ON dt.id_transaksi = t.id_transaksi 
                    WHERE t.id_user = '$id_user' AND t.status_pembayaran = '1' AND status != 'baru'";
											}
											$total_result = mysqli_query($conn, $total_query);
											$total = mysqli_fetch_assoc($total_result)['total'] ?? 0;
											?>
											<h3 class="text-primary fw-boldest mb-0">Rp <?= number_format($total, 0, ',', '.') ?></h3>
										</div>
									</div>
									<div class="d-flex align-items-center mt-4">
										<?php
										// Mendapatkan tanggal kemarin
										$kemarin = date('Y-m-d', strtotime('-1 day'));

										if ($level_user == 'admin') {
											$kemarin_query = "SELECT SUM(dt.total_harga) as total 
                              FROM detail_transaksi dt 
                              JOIN transaksi t ON dt.id_transaksi = t.id_transaksi 
                              WHERE t.status_pembayaran = '1' 
                              AND DATE(t.tanggal) = '$kemarin' 
                              AND status != 'baru'";
										} else {
											$kemarin_query = "SELECT SUM(dt.total_harga) as total 
                              FROM detail_transaksi dt 
                              JOIN transaksi t ON dt.id_transaksi = t.id_transaksi 
                              WHERE t.id_user = '$id_user' 
                              AND t.status_pembayaran = '1' 
                              AND DATE(t.tanggal) = '$kemarin' 
                              AND status != 'baru'";
										}
										$kemarin_result = mysqli_query($conn, $kemarin_query);
										$total_kemarin = mysqli_fetch_assoc($kemarin_result)['total'] ?? 0;
										?>
										<span class="badge bg-primary bg-opacity-20 text-primary me-2">
											<i class="fas fa-chart-line me-1"></i> Rp <?= number_format($total_kemarin, 0, ',', '.') ?>
										</span>
										<span class="text-muted fs-7">kemarin</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-3">
							<div class="card card-xl-stretch mb-5 mb-xl-8 bg-success bg-opacity-10 border-0 shadow-sm hover-elevate-up">
								<div class="card-body d-flex flex-column">
									<div class="d-flex align-items-center">
										<span class="symbol symbol-50px me-2">
											<span class="symbol-label bg-success bg-opacity-70 rounded-circle">
												<i class="fas fa-users text-white fs-1"></i>
											</span>
										</span>
										<div>
											<p class="text-dark fw-bolder fs-6 mb-0">Total Pelanggan</p>
											<?php
											$level_user = $_SESSION['level'];
											$today_query = "SELECT COUNT(*) as total FROM customer;
";
											$today_result = mysqli_query($conn, $today_query);
											$today = mysqli_fetch_assoc($today_result)['total'] ?? 0;
											?>
											<h3 class="text-success fw-boldest mb-0"><?= number_format($today) ?></h3>
										</div>
									</div>
									<div class="d-flex align-items-center mt-4">
										<span class="badge bg-success bg-opacity-20 text-success me-2">
											<i class="fas fa-hourglass-half me-1"></i> Aktif
										</span>
										<span class="text-muted fs-7">saat ini</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-3">
							<div class="card card-xl-stretch mb-5 mb-xl-8 bg-warning bg-opacity-10 border-0 shadow-sm hover-elevate-up">
								<div class="card-body d-flex flex-column">
									<div class="d-flex align-items-center">
										<span class="symbol symbol-50px me-2">
											<span class="symbol-label bg-warning bg-opacity-70 rounded-circle">
												<i class="fas fa-shopping-cart text-white fs-1"></i>
											</span>
										</span>
										<div>
											<p class="text-dark fw-bolder fs-6 mb-0">Total Transaksi</p>
											<?php
											$level_user = $_SESSION['level'];
											if ($level_user == 'admin') {
												$trans_count_query = "SELECT COUNT(*) as total FROM transaksi";
											} else {
												$trans_count_query = "SELECT COUNT(*) as total FROM transaksi WHERE id_user = '$id_user'";
											}
											$trans_count_result = mysqli_query($conn, $trans_count_query);
											$trans_count = mysqli_fetch_assoc($trans_count_result)['total'] ?? 0;
											?>
											<h3 class="text-warning fw-boldest mb-0"><?= number_format($trans_count) ?></h3>
										</div>
									</div>
									<div class="d-flex align-items-center mt-4">
										<span class="badge bg-warning bg-opacity-20 text-warning me-2">
											<i class="fas fa-arrow-up me-1"></i>
											<?php
											// Mendapatkan tanggal seminggu yang lalu
											$minggu_lalu = date('Y-m-d', strtotime('-7 days'));

											$level_user = $_SESSION['level'];
											if ($level_user == 'admin') {
												// Query untuk admin: menghitung transaksi dalam seminggu terakhir
												$transaksi_query = "SELECT COUNT(*) as total_transaksi 
                                FROM transaksi 
                                WHERE tanggal >= '$minggu_lalu'";
											} else {
												// Query untuk user selain admin: menghitung transaksi dalam seminggu terakhir berdasarkan id_user
												$transaksi_query = "SELECT COUNT(*) as total_transaksi 
                                FROM transaksi 
                                WHERE id_user = '$id_user' 
                                AND tanggal >= '$minggu_lalu'";
											}

											// Menjalankan query dan mengambil hasilnya
											$transaksi_result = mysqli_query($conn, $transaksi_query);
											$total_transaksi = mysqli_fetch_assoc($transaksi_result)['total_transaksi'] ?? 0;
											?>
											+<?= $total_transaksi ?>
										</span>
										<span class="text-muted fs-7">minggu ini</span>
									</div>

								</div>
							</div>
						</div>

						<div class="col-xl-3">
							<div class="card card-xl-stretch mb-5 mb-xl-8 bg-info bg-opacity-10 border-0 shadow-sm hover-elevate-up">
								<div class="card-body d-flex flex-column">
									<div class="d-flex align-items-center">
										<span class="symbol symbol-50px me-2">
											<span class="symbol-label bg-info bg-opacity-70 rounded-circle">
												<i class="fas fa-tshirt text-white fs-1"></i>
											</span>
										</span>
										<div>
											<p class="text-dark fw-bolder fs-6 mb-0">Cucian dalam Proses</p>
											<?php
											$level_user = $_SESSION['level'];
											if ($level_user == 'admin') {
												$in_process_query = "SELECT COUNT(*) as total FROM transaksi WHERE status = 'proses'";
											} else {
												$in_process_query = "SELECT COUNT(*) as total FROM transaksi WHERE status = 'proses' AND id_user = '$id_user'";
											}
											$in_process_result = mysqli_query($conn, $in_process_query);
											$in_process = mysqli_fetch_assoc($in_process_result)['total'] ?? 0;
											?>
											<h3 class="text-info fw-boldest mb-0"><?= number_format($in_process) ?></h3>
										</div>
									</div>
									<div class="d-flex align-items-center mt-4">
										<span class="badge bg-info bg-opacity-20 text-info me-2">
											<i class="fas fa-hourglass-half me-1"></i> Aktif
										</span>
										<span class="text-muted fs-7">saat ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>


					<!-- Today's Stats Cards -->
					<div class="row g-5 gx-xxl-8 mb-5">
						<!-- Today's Income Card -->
						<div class="col-xl-4">
							<div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm hover-elevate-up">
								<div class="card-body">
									<div class="d-flex align-items-center mb-5">
										<div class="symbol symbol-60px me-5 bg-light-success rounded-3 p-3">
											<i class="fas fa-calendar-alt fs-1 text-success"></i>
										</div>
										<div class="d-flex flex-column">
											<h3 class="card-title fw-bolder text-dark fs-4 mb-1">Pemasukan Hari Ini</h3>
											<?php
											$level_user = $_SESSION['level'];
											if ($level_user == 'admin') {
												$today_income_query = "SELECT SUM(dt.total_harga) as total 
												FROM detail_transaksi dt 
												JOIN transaksi t ON dt.id_transaksi = t.id_transaksi 
												WHERE DATE(t.tanggal) = CURDATE() 
												AND t.status_pembayaran = '1'";
											} else {
												$today_income_query = "SELECT SUM(dt.total_harga) as total 
												FROM detail_transaksi dt 
												JOIN transaksi t ON dt.id_transaksi = t.id_transaksi 
												WHERE DATE(t.tanggal) = CURDATE() 
												AND t.id_user = '$id_user' 
												AND t.status_pembayaran = '1'";
											}
											$today_income_result = mysqli_query($conn, $today_income_query);
											$today_income = mysqli_fetch_assoc($today_income_result)['total'] ?? 0;
											?>
											<span class="text-muted fs-7">Transaksi selesai hari ini</span>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<span class="fs-2 fw-bolder text-success">Rp <?= number_format($today_income, 0, ',', '.') ?></span>
									</div>
									<div class="progress h-7px bg-success bg-opacity-10 mt-3">
										<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>

						<!-- Today's Customers Card -->
						<div class="col-xl-4">
							<div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm hover-elevate-up">
								<div class="card-body">
									<div class="d-flex align-items-center mb-5">
										<div class="symbol symbol-60px me-5 bg-light-primary rounded-3 p-3">
											<i class="fas fa-user-friends fs-1 text-primary"></i>
										</div>
										<div class="d-flex flex-column">
											<h3 class="card-title fw-bolder text-dark fs-4 mb-1">Pelanggan Hari Ini</h3>
											<?php
											$level_user = $_SESSION['level'];
											if ($level_user == 'admin') {
												$today_customer_query = "SELECT COUNT(DISTINCT id_customer) as total 
													FROM transaksi 
													WHERE DATE(tanggal) = CURDATE()";
											} else {
												$today_customer_query = "SELECT COUNT(DISTINCT id_customer) as total 
													FROM transaksi 
													WHERE DATE(tanggal) = CURDATE() AND id_user = '$id_user'";
											}
											$today_customer_result = mysqli_query($conn, $today_customer_query);
											$today_customer = mysqli_fetch_assoc($today_customer_result)['total'] ?? 0;
											?>
											<span class="text-muted fs-7">Jumlah pelanggan unik</span>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<span class="fs-2 fw-bolder text-primary"><?= number_format($today_customer) ?> Pelanggan</span>
									</div>
									<div class="progress h-7px bg-primary bg-opacity-10 mt-3">
										<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>

						<!-- Today's Transactions Card -->
						<div class="col-xl-4">
							<div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm hover-elevate-up">
								<div class="card-body">
									<div class="d-flex align-items-center mb-5">
										<div class="symbol symbol-60px me-5 bg-light-info rounded-3 p-3">
											<i class="fas fa-receipt fs-1 text-info"></i>
										</div>
										<div class="d-flex flex-column">
											<h3 class="card-title fw-bolder text-dark fs-4 mb-1">Transaksi Hari Ini</h3>
											<?php
											$level_user = $_SESSION['level'];
											if ($level_user == 'admin') {
												$today_transaction_query = "SELECT COUNT(*) as total 
													FROM transaksi 
													WHERE DATE(tanggal) = CURDATE()";
											} else {
												$today_transaction_query = "SELECT COUNT(*) as total 
													FROM transaksi 
													WHERE DATE(tanggal) = CURDATE() AND id_user = '$id_user'";
											}
											$today_transaction_result = mysqli_query($conn, $today_transaction_query);
											$today_transaction = mysqli_fetch_assoc($today_transaction_result)['total'] ?? 0;
											?>
											<span class="text-muted fs-7">Semua transaksi hari ini</span>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<span class="fs-2 fw-bolder text-info"><?= number_format($today_transaction) ?> Transaksi</span>
									</div>
									<div class="progress h-7px bg-info bg-opacity-10 mt-3">
										<div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Tables & Weekly Performance Charts -->
					<div class="row g-5 gx-xxl-8">
						<!-- Transactions Table -->
						<div class="col-xl-6">
							<div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm">
								<div class="card-header border-0 pt-5">
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label fw-bolder text-dark fs-3">Transaksi Terbaru</span>
										<span class="text-muted mt-2 fw-bold fs-7">5 transaksi terakhir masuk</span>
									</h3>
									<?php if ($level_user == 'petugas') : ?>
										<div class="card-toolbar">
											<a href="<?= base_url ?>dashboard/transaksi/index.php" class="btn btn-sm btn-light-primary">
												<i class="fas fa-eye me-1"></i>Lihat Semua
											</a>
										</div>
									<?php endif; ?>
								</div>
								<div class="card-body py-3">
									<div class="table-responsive">
										<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
											<thead>
												<tr class="fw-bolder text-muted bg-light">
													<th class="ps-4 rounded-start min-w-125px">Kode Transaksi</th>
													<th class="min-w-125px">Pelanggan</th>
													<th class="min-w-100px">Status</th>
													<th class="min-w-100px">Pembayaran</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$level_user = $_SESSION['level'];
												if ($level_user == 'admin') {
													$query = "SELECT t.*, c.nama_customer 
														FROM transaksi t 
														JOIN customer c ON t.id_customer = c.id_customer 
														ORDER BY t.tanggal DESC LIMIT 5";
												} else {
													$query = "SELECT t.*, c.nama_customer 
														FROM transaksi t 
														JOIN customer c ON t.id_customer = c.id_customer 
														WHERE t.id_user = '$id_user' 
														ORDER BY t.tanggal DESC LIMIT 5";
												}

												$result = mysqli_query($conn, $query);
												while ($row = mysqli_fetch_assoc($result)) {
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
													}
												?>
													<tr>
														<td class="ps-4">
															<span class="text-dark fw-bolder d-block fs-6"><?= $row['kode_transaksi'] ?></span>
															<span class="text-muted fw-bold text-muted d-block fs-7"><?= date('d M Y', strtotime($row['tanggal'])) ?></span>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<div class="symbol symbol-30px me-3">
																	<span class="symbol-label bg-light-primary text-primary fw-bold"><?= substr($row['nama_customer'], 0, 1) ?></span>
																</div>
																<span class="fw-bold"><?= $row['nama_customer'] ?></span>
															</div>
														</td>
														<td>
															<span class="<?= $status_class ?>"><?= ucfirst($row['status']) ?></span>
														</td>
														<td>
															<?php if ($row['status_pembayaran'] == '1'): ?>
																<span class="badge badge-light-success fs-7 fw-bold">Lunas</span>
															<?php else: ?>
																<span class="badge badge-light-danger fs-7 fw-bold">Belum Lunas</span>
															<?php endif; ?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<!-- Status Overview Card with Chart.js -->
						<div class="col-xl-6">
							<div class="card card-xl-stretch mb-5 mb-xl-8 shadow hover-elevate">
								<div class="card-header gradient-card-2 py-5 ">
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label fw-bolder fs-2">
											<i class="fas fa-chart-pie me-2"></i>Ringkasan Status
										</span>
									</h3>
								</div>
								<div class="card-body py-5">
									<!-- Chart Canvas -->
									<div class="d-flex flex-column">
										<div>
											<canvas id="statusChart" height="350"></canvas>
										</div>
										<div class="d-flex justify-content-around mt-5 flex-wrap">
											<?php
											$status_colors = [
												'baru' => 'info',
												'proses' => 'warning',
												'selesai' => 'success',
												'diambil' => 'primary'
											];

											// Inisialisasi data status dengan nilai 0
											$status_data = array_fill_keys(array_keys($status_colors), 0);

											// Ambil level user dari session
											$level_user = $_SESSION['level']; // Misalkan level disimpan dalam session
											$id_user = $_SESSION['id_user']; // Ambil id_user dari session

											// Ambil data dari database
											if ($level_user == 'admin') {
												// Jika admin, ambil semua status
												$status_query = "SELECT status, COUNT(*) as total 
                                 FROM transaksi 
                                 WHERE status != '' 
                                 GROUP BY status";
											} else {
												// Jika petugas, ambil status berdasarkan id_user
												$status_query = "SELECT status, COUNT(*) as total 
                                 FROM transaksi 
                                 WHERE status != '' AND id_user = '$id_user' 
                                 GROUP BY status";
											}

											$status_result = mysqli_query($conn, $status_query);

											while ($status = mysqli_fetch_assoc($status_result)) {
												$status_data[$status['status']] = $status['total'];
											}

											// Tampilkan legenda status
											foreach ($status_data as $status => $total) {
												$color = $status_colors[$status] ?? 'secondary';
											?>
												<div class="d-flex align-items-center mb-2">
													<div class="d-flex flex-center h-20px w-20px rounded-circle bg-light-<?= $color ?> me-3">
														<i class="fas fa-tasks text-<?= $color ?> fs-4"></i>
													</div>
													<div>
														<span class="text-<?= $color ?> fw-bolder fs-2 me-2"><?= $total ?></span>
														<span class="text-gray-600 fw-bold fs-6"><?= ucfirst($status) ?></span>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!--End::Row-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Content-->
	</div>
	<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::Root-->

<!--end::Main-->

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- Chart initialization script -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Get the chart canvas
		var ctx = document.getElementById('serviceChart').getContext('2d');

		// Data from PHP
		var serviceData = {
			labels: [
				<?php foreach ($service_data as $service => $total) {
					echo "'" . ucfirst($service) . "', ";
				} ?>
			],
			datasets: [{
				data: [
					<?php foreach ($service_data as $total) {
						echo $total . ", ";
					} ?>
				],
				backgroundColor: [
					'#FF6384', // Cuci Kering
					'#36A2EB', // Cuci Setrika
					'#FFCE56', // Setrika Saja
					'#4BC0C0', // Cuci Express
					'#9966FF' // Dry Cleaning
				],
				borderWidth: 0,
				cutout: '70%',
				hoverOffset: 10
			}]
		};

		// Chart configuration
		var serviceChart = new Chart(ctx, {
			type: 'doughnut',
			data: serviceData,
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false
					},
					tooltip: {
						callbacks: {
							label: function(context) {
								var label = context.label || '';
								var value = context.raw || 0;
								var total = context.dataset.data.reduce((a, b) => a + b, 0);
								var percentage = total > 0 ? Math.round((value / total) * 100) : 0;
								return label + ': ' + value + ' (' + percentage + '%)';
							}
						}
					}
				}
			}
		});
	});
</script>

<!-- Add Chart.js library before the closing body tag -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<!-- Chart initialization script -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Get the chart canvas
		var ctx = document.getElementById('statusChart').getContext('2d');

		// Data from PHP
		var statusData = {
			labels: [
				<?php foreach ($status_data as $status => $total) {
					echo "'" . ucfirst($status) . "', ";
				} ?>
			],
			datasets: [{
				data: [
					<?php foreach ($status_data as $total) {
						echo $total . ", ";
					} ?>
				],
				backgroundColor: [
					'#3699FF', // info - baru
					'#FFA800', // warning - proses
					'#1BC5BD', // success - selesai
					'#8950FC' // primary - diambil
				],
				borderWidth: 0,
				cutout: '70%',
				hoverOffset: 10
			}]
		};

		// Chart configuration
		var statusChart = new Chart(ctx, {
			type: 'doughnut',
			data: statusData,
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false
					},
					tooltip: {
						callbacks: {
							label: function(context) {
								var label = context.label || '';
								var value = context.raw || 0;
								var total = context.dataset.data.reduce((a, b) => a + b, 0);
								var percentage = total > 0 ? Math.round((value / total) * 100) : 0;
								return label + ': ' + value + ' (' + percentage + '%)';
							}
						}
					}
				}
			}
		});
	});
</script>

<?php include 'layout/footer.php'; ?>