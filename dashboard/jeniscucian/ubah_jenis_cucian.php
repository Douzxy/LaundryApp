<?php
include '../layout/header.php';


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
		<?php
		include '../layout/sidebar.php';
		?>
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

									<div class="text-center mb-15">
										<!--begin::Text-->

										<form action="<?= base_url ?>dashboard/jeniscucian/proses_ubah_jenis_cucian.php" method="post">

											<?php
											$sql = 'select * from jenis_cucian where id_jenis_cucian = ' . $_GET['id_jenis_cucian'];
											$result = mysqli_query($conn, $sql);
											$data = mysqli_fetch_assoc($result);
											?>

											<div class="mb-3" style="text-align: left;">

												<div class="col-lg-12">
													<input type="text" class="form-control" id="val-username" name="id_jenis_cucian" placeholder="Enter id kelas.." hidden value="<?= $data['id_jenis_cucian'] ?>">
												</div>
											</div>
											<div class="mb-3" style="text-align: left;">
												<strong><label class="col-lg-4 col-form-label" for="val-password">Nama Jenis Cucian<span class="text-danger">*</span>
													</label></strong>
												<div class="col-lg-12">
													<input type="text" class="form-control" id="val-password" name="nama_jenis_cucian" placeholder="Masukan nama jenis cucian" required value="<?= $data['nama_jenis_cucian'] ?>">
												</div>
											</div>
											<div class="mb-3" style="text-align: left;">
												<strong><label class="col-lg-4 col-form-label" for="harga">Harga<span class="text-danger">*</span></label></strong>
												<div class="col-lg-12">
													<input type="text" class="form-control" id="harga" name="harga_display" placeholder="Masukkan harga" required
														value="<?= number_format($data['harga'], 0, ',', '.') ?>"
														oninput="formatRupiah(this)">
													<input type="hidden" name="harga" id="harga_real" value="<?= $data['harga'] ?>">
												</div>
											</div>

											<script>
												function formatRupiah(input) {
													let value = input.value.replace(/\./g, ''); // Hilangkan semua titik
													if (!isNaN(value) && value !== '') {
														document.getElementById('harga_real').value = value; // Simpan nilai asli tanpa titik
														input.value = parseInt(value, 10).toLocaleString('id-ID'); // Format tampilan dengan titik
													} else {
														input.value = ''; // Kosongkan jika bukan angka
														document.getElementById('harga_real').value = ''; // Pastikan hidden input ikut kosong
													}
												}
											</script>

											<br><br>
											<div class="form-group row" style="text-align: left;">
												<div class="col-lg-8 ml-auto">
													<button type="submit" class="btn btn-primary">Simpan</button>
													<a href="<?= base_url ?>dashboard/jeniscucian/index.php"><button type="button" class="btn btn-secondary">Kembali</button></a>
										</form>
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Actions-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Stepper-->
					</div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - Create App-->
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
		<?php include '../layout/footer.php'; ?>