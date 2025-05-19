<?php include '../layout/header.php';
displayAlert();
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
?>
<!--begin::Main-->
<!--begin::Root-->
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
						<!--begin::Heading-->
						<h1 class="text-dark fw-bolder my-1 fs-2">Laundry App</h1>
						<!--end::Heading-->
						<!--begin::Breadcrumb-->
						<ul class="breadcrumb fw-bold fs-base my-1">
							<li class="breadcrumb-item text-muted">
								<a href="index.php" class="text-muted">Beranda</a>
							</li>
							<li class="breadcrumb-item text-muted">Admin</li>
							<li class="breadcrumb-item text-dark">Jenis Cucian</li>
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
						<a href="index.php" class="d-flex align-items-center">
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
					<!--begin::About card-->
					<div class="card">
						<!--begin::Body-->
						<div class="card-body p-lg-17">
							<!--begin::About-->
							<div class="mb-18">
								<!--begin::Wrapper-->
								<div class="mb-10">
									<!--begin::Top-->

									<!-- Button trigger modal -->
									<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
										Tambah Jenis Cucian
									</button> <br><br><br>
									<div class="text-center mb-15">
										<!--begin::Text-->

										<!-- Add CSS -->
										<style>
											.custom-table {
												border-radius: 8px;
												overflow: hidden;
												box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
											}

											.custom-table thead {
												background: linear-gradient(to right, #3699FF, #5AB1FF);
											}

											.custom-table thead th {
												color: #ffffff !important;
												font-weight: 600;
												padding: 15px !important;
											}

											.custom-table tbody tr {
												transition: all 0.3s ease;
											}

											.custom-table tbody tr:hover {
												background-color: #f8f9fa;
												transform: translateY(-1px);
											}

											.custom-table td {
												padding: 12px 15px !important;
												vertical-align: middle;
											}

											.price-column {
												font-weight: 600;
												color: #2c3e50;
											}
										</style>

										<?php
										// Ambil jumlah total jenis cucian
										$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
										$total_jenis_cucian_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM jenis_cucian WHERE nama_jenis_cucian LIKE '%$search%'");
										$total_jenis_cucian = mysqli_fetch_assoc($total_jenis_cucian_query)['total'];

										// Tentukan jumlah jenis cucian per halaman
										$limit = 10; // Misalnya 10 jenis cucian per halaman
										$total_pages = ceil($total_jenis_cucian / $limit); // Hitung total halaman

										// Ambil halaman saat ini
										$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
										$page = max(1, min($total_pages, $page)); // Pastikan halaman valid

										// Hitung offset untuk query
										$offset = ($page - 1) * $limit;

										// Query untuk mengambil jenis cucian dengan limit dan offset
										$qry_jenis_cucian = mysqli_query($conn, "SELECT * FROM jenis_cucian WHERE nama_jenis_cucian LIKE '%$search%' ORDER BY id_jenis_cucian DESC LIMIT $limit OFFSET $offset");										?>

										<!-- Search Input -->
										<div class="mb-3 col-6 col-md-3 border rounded shadow-sm">
											<div class="input-group">
												<label for="search" class="input-group-text bg-white border-0 cursor-pointer">
													<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M21 21L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
														<path d="M10 17C13.866 17 17 13.866 17 10C17 6.13401 13.866 3 10 3C6.13401 3 3 6.13401 3 10C3 13.866 6.13401 17 10 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
													</svg>
												</label>
												<input type="text" id="search" class="form-control border-0 shadow-none" placeholder="Cari jenis cucian..." value="<?= htmlspecialchars($search) ?>">
											</div>
										</div>

										<div class="table-responsive">
											<table class="table custom-table" id="jenisCucianTable">
												<thead>
													<tr>
														<th>No</th>
														<th class="text-nowrap">Nama Jenis Cucian</th>
														<th>Harga</th>
														<th>Status</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$no = $offset + 1; // Mulai nomor dari offset + 1
													while ($data_jenis_cucian = mysqli_fetch_array($qry_jenis_cucian)) {
													?>
														<tr class="text-nowrap align-middle">
															<td><?= $no ?></td>
															<td><?= htmlspecialchars($data_jenis_cucian['nama_jenis_cucian']) ?></td>
															<td class="price-column">Rp <?= number_format($data_jenis_cucian['harga'], 0, ',', '.') ?></td>
															<td class="text-center">
																<form action="<?= base_url ?>dashboard/jeniscucian/proses_ubah_status.php" method="post" class="d-flex justify-content-center">
																	<input type="hidden" name="id_jenis_cucian" value="<?= $data_jenis_cucian['id_jenis_cucian']; ?>">
																	<div class="form-check form-switch form-check-custom form-check-solid">
																		<input class="shadow form-check-input switch-status" type="checkbox"
																			id="switch_<?= $data_jenis_cucian['id_jenis_cucian']; ?>"
																			name="status"
																			value="1"
																			<?= $data_jenis_cucian['status'] == 1 ? 'checked' : ''; ?>
																			onchange="this.form.submit();" />
																	</div>
																</form>
															</td>

															<td class="text-center">
																<a class="btn btn-success" href="<?= base_url ?>dashboard/jeniscucian/ubah_jenis_cucian.php?id_jenis_cucian=<?= $data_jenis_cucian['id_jenis_cucian'] ?>">
																	<i class="far fa-edit"></i>
																</a>
																<a href="<?= base_url ?>dashboard/jeniscucian/hapus_jenis_cucian.php?id_jenis_cucian=<?= $data_jenis_cucian['id_jenis_cucian'] ?>"
																	onclick="return confirmDelete(event, '<?= base_url ?>dashboard/jeniscucian/hapus_jenis_cucian.php?id_jenis_cucian=<?= $data_jenis_cucian['id_jenis_cucian'] ?>')"
																	class="btn btn-danger">
																	<i class="far fa-trash-alt"></i>
																</a>
															</td>
														</tr>

													<?php
														$no++; // Increment nomor
													} ?>
												</tbody>
											</table>
										</div>

										<div class="d-flex flex-column flex-md-row align-items-center mb-3 justify-content-between">
											<!-- Teks Menampilkan Data -->
											<div class="text-muted mb-3">
												<?php
												$start = ($total_jenis_cucian > 0) ? $offset + 1 : 0;
												$end = ($total_jenis_cucian > 0) ? min($offset + $limit, $total_jenis_cucian) : 0;
												?>
												Menampilkan data <?= $start ?> - <?= $end ?> dari <?= $total_jenis_cucian ?> data
											</div>

											<!-- Pagination -->
											<ul class="pagination mb-0">
												<!-- Tombol Previous -->
												<li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
													<a href="<?= ($page > 1) ? base_url . "dashboard/jeniscucian/index.php?page=" . ($page - 1) . "&search=" . urlencode($search) : '#' ?>" class="page-link">
														<i class="fas fa-chevron-left"></i>
													</a>
												</li>

												<!-- Nomor Halaman -->
												<?php if ($total_pages > 5): ?>
													<li class="page-item <?= ($page == 1) ? 'active' : '' ?>">
														<a href="<?= base_url ?>dashboard/jeniscucian/index.php?page=1&search=<?= urlencode($search) ?>" class="page-link">1</a>
													</li>
													<?php if ($page > 3): ?>
														<li class="page-item disabled">
															<span class="page-link">...</span>
														</li>
													<?php endif; ?>
													<?php for ($i = max(2, $page - 1); $i <= min($total_pages - 1, $page + 1); $i++): ?>
														<li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
															<a href="<?= base_url ?>dashboard/jeniscucian/index.php?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="page-link"><?= $i ?></a>
														</li>
													<?php endfor; ?>
													<?php if ($page < $total_pages - 2): ?>
														<li class="page-item disabled">
															<span class="page-link">...</span>
														</li>
													<?php endif; ?>
													<li class="page-item <?= ($page == $total_pages) ? 'active' : '' ?>">
														<a href="<?= base_url ?>dashboard/jeniscucian/index.php?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>" class="page-link"><?= $total_pages ?></a>
													</li>
												<?php else: ?>
													<?php for ($i = 1; $i <= $total_pages; $i++): ?>
														<li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
															<a href="<?= base_url ?>dashboard/jeniscucian/index.php?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="page-link"><?= $i ?></a>
														</li>
													<?php endfor; ?>
												<?php endif; ?>

												<!-- Tombol Next -->
												<li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
													<a href="<?= ($page < $total_pages) ? base_url . "dashboard/jeniscucian/index.php?page=" . ($page + 1) . "&search=" . urlencode($search) : '#' ?>" class="page-link">
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
											let timeout = null;
											$('#search').on('keyup', function() {
												clearTimeout(timeout);
												const value = $(this).val().toLowerCase();
												timeout = setTimeout(function() {
													window.location.href = "<?= base_url ?>dashboard/jeniscucian/index.php?search=" + encodeURIComponent(value);
												}, 1000);
											});

											// Fokus pada input pencarian jika ada parameter pencarian
											if ("<?= isset($_GET['search']) ? 'true' : 'false' ?>" === 'true') {
												$('#search').focus();
												$('#search')[0].setSelectionRange($('#search').val().length, $('#search').val().length); // Set kursor di akhir
											}
										});
									</script>
								</div>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Cucian</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<form method="POST" action="<?= base_url ?>dashboard/jeniscucian/proses_tambah_jenis_cucian.php" enctype="multipart/form-data">
													<section class="base">
														<div class="mb-3">
															<label for="exampleInputEmail1" class="form-label">Nama Jenis Cucian</label>
															<input type="text" name="nama_jenis_cucian" required placeholder="Masukkan nama jenis cucian" class="form-control">
														</div>
														<div class="mb-3">
															<label for="exampleInputEmail1" class="form-label">Harga</label>
															<input type="text" id="formattedHarga" class="form-control" required placeholder="Masukkan harga">
															<input type="hidden" name="harga" id="harga">
														</div>

														<script>
															document.getElementById('formattedHarga').addEventListener('input', function() {
																let angka = this.value.replace(/\D/g, ''); // Hanya ambil angka
																this.value = new Intl.NumberFormat('id-ID').format(angka); // Format dengan titik
																document.getElementById('harga').value = angka; // Simpan angka asli tanpa titik
															});
														</script>

														<br>
														<div class="d-flex justify-content-end">
															<button type="button" class="btn btn-secondary me-2" onclick="window.location.href='<?= base_url ?>dashboard/jeniscucian/index.php'">Batal</button>
															<input type="submit" name="simpan" value="Kirim" class="btn btn-primary">
														</div>
													</section>
												</form>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
				<!--end::Modal body-->
			</div>
			<!--end::Modal content-->
		</div>
		<!--end::Modal dialog-->
	</div>
	<!--end::Modal - New Target-->
	<!--end::Modals-->
	<!--begin::Scrolltop-->
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
		<span class="svg-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<polygon points="0 0 24 0 24 24 0 24" />
					<rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
					<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
				</g>
			</svg>
		</span>
		<!--end::Svg Icon-->
	</div>
	<!--end::Scrolltop-->
	<!--end::Main-->

	<!-- Define the JavaScript function -->
	<script>
		function confirmDelete(event, deleteUrl) {
			event.preventDefault(); // Mencegah link langsung berjalan

			// Buat elemen alert
			let alertDiv = document.createElement("div");
			alertDiv.innerHTML = `
        <div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10 position-fixed top-50 start-50 translate-middle shadow-lg" style="z-index: 1050; min-width: 400px;">
            <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-danger" onclick="closeAlert(this)">
                <span class="svg-icon svg-icon-1">
					<i class="fas fa-times"	></i>
				</span>
            </button>
            <span class="svg-icon svg-icon-5tx svg-icon-danger mb-5">
				<i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
			</span>
            <div class="text-center">
                <h5 class="fw-bolder fs-1 mb-5">Konfirmasi Hapus</h5>
                <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                <div class="mb-9">
                    Apakah Anda yakin ingin menghapus jenis cucian ini? <br/>
                    Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="d-flex flex-center flex-wrap">
                    <a href="<?= base_url ?>dashboard/jeniscucian/index.php" class="btn btn-outline btn-outline-danger btn-active-danger m-2" onclick="closeAlert(this)">Batal</a>
                    <a href="${deleteUrl}" class="btn btn-danger m-2">Ya, Hapus</a>
                </div>
            </div>	
        </div>
    `;

			// Tambahkan ke body
			document.body.appendChild(alertDiv);
		}

		// Fungsi untuk menutup alert
		function closeAlert(button) {
			button.closest('.alert').remove();
		}
	</script>

	<?php include '../layout/footer.php'; ?>