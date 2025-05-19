<?php include '../layout/header.php';
displayAlert();


// Cek level pengguna
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'petugas') {
	$_SESSION['alert'] = [
		'type' => 'danger',
		'title' => 'Akses Ditolak!',
		'message' => 'Anda tidak memiliki akses untuk membuka halaman tersebut.'
	];
	header("Location: ../index.php"); // Arahkan ke halaman utama
	exit();
}

if (!isset($_GET['id_transaksi'])) {
	header("Location: ../transaksi/index.php");
} else {
	$id_transaksi = $_GET['id_transaksi'];
}

?>

<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
	<!--begin::Page-->
	<div class="page d-flex flex-row flex-column-fluid">
		<?php include '../layout/sidebar.php' ?>
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
							<li class="breadcrumb-item text-muted">Petugas</li>
							<li class="breadcrumb-item text-dark">Detail Transaksi</li>
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
									<div class="d-flex justify-content-between align-items-center mb-4">
										<h3 class="fw-bold">Detail Transaksi</h3>
										<div>
											<a href="<?= base_url ?>dashboard/transaksi/index.php" class="btn btn-secondary me-2">
												<i class="fas fa-arrow-left"></i> Kembali
											</a>
											<?php
											$sql = "SELECT * FROM transaksi 
                JOIN customer ON customer.id_customer = transaksi.id_customer 
                WHERE transaksi.id_transaksi = " . $_GET['id_transaksi'];
											$result = mysqli_query($conn, $sql);
											$data = mysqli_fetch_assoc($result);

											$sql_check = "SELECT status_pembayaran, status FROM transaksi WHERE id_transaksi = " . $_GET['id_transaksi'];
											$result_check = mysqli_query($conn, $sql_check);
											$data_pembayaran = mysqli_fetch_assoc($result_check);
											?>

											<?php if ($data_pembayaran['status_pembayaran'] == '1' || $data_pembayaran['status'] != 'baru'): ?>
												<a href="<?= base_url ?>dashboard/detailtransaksi/cetak_transaksi.php?id_transaksi=<?= $data['id_transaksi'] ?>"
													class="btn btn-primary me-2">
													<i class="fas fa-print"></i> Cetak Transaksi
												</a>
											<?php endif; ?>
										</div>
									</div>

									<div class="card shadow-sm">
										<div class="card-body">
											<!-- Status Section -->
											<div class="mb-4">
												<?php
												function getNextStatus($currentStatus)
												{
													$statuses = ['baru' => 'proses', 'proses' => 'selesai', 'selesai' => 'diambil'];
													return $statuses[$currentStatus] ?? null;
												}

												$current_status = $data_pembayaran['status'];
												$new_status = getNextStatus($current_status);
												$status_labels = ['baru' => 'Secondary', 'proses' => 'Primary', 'selesai' => 'Success', 'diambil' => 'Dark'];
												?>

												<div class="d-flex justify-content-between align-items-center">
													<h5 class="card-title">Status Transaksi</h5>
													<span class="badge bg-<?= strtolower($status_labels[$current_status] ?? 'light') ?>">
														<?= ucfirst($current_status) ?>
													</span>
												</div>

												<?php if ($current_status != 'diambil' && $current_status != 'baru'): ?>
													<form id="statusForm" class="mt-2" action="<?= base_url ?>dashboard/detailtransaksi/ubah_status_transaksi.php" method="POST">
														<input type="hidden" name="id_transaksi" value="<?= $data['id_transaksi'] ?>">
														<input type="hidden" name="status" value="<?= $new_status ?>">
														<button type="button" class="btn btn-sm btn-warning"
															onclick="<?= $current_status == 'selesai' ? 'confirmPickup(event)' : 'this.form.submit()' ?>">
															<?= match ($current_status) {
																'proses' => 'Tandai Selesai',
																'selesai' => 'Konfirmasi Pengambilan'
															} ?>
														</button>
													</form>
												<?php endif; ?>
											</div>

											<!-- Progress Indicator -->
											<div class="progress-container mb-4">
												<div class="d-flex justify-content-between small">
													<?php foreach (['baru', 'proses', 'selesai', 'diambil'] as $status): ?>
														<span class="<?= $status == $current_status ? 'text-primary fw-bold' : 'text-muted' ?>">
															<i class="<?= match ($status) {
																			'baru' => 'fas fa-clipboard-list',
																			'proses' => 'fas fa-cogs',
																			'selesai' => 'fas fa-check-circle',
																			'diambil' => 'fas fa-box-open'
																		} ?> me-1"></i>
															<?= ucfirst($status) ?>
														</span>
													<?php endforeach; ?>
												</div>
												<div class="progress" style="height: 8px;">
													<?php
													$progress = match ($current_status) {
														'baru' => 0,
														'proses' => 33,
														'selesai' => 66,
														'diambil' => 100
													};
													?>
													<div class="progress-bar bg-primary"
														role="progressbar"
														style="width: <?= $progress ?>%"
														aria-valuenow="<?= $progress ?>"
														aria-valuemin="0"
														aria-valuemax="100">
													</div>
												</div>
											</div>

											<!-- Transaction Details -->
											<div class="row">
												<div class="col-md-6">
													<dl class="row">
														<dt class="col-sm-4 text-muted">Kode Transaksi</dt>
														<dd class="col-sm-8 fw-bold"><?= $data['kode_transaksi'] ?></dd>

														<dt class="col-sm-4 text-muted">Nama Pelanggan</dt>
														<dd class="col-sm-8 fw-bold"><?= $data['nama_customer'] ?></dd>

														<dt class="col-sm-4 text-muted">Alamat</dt>
														<dd class="col-sm-8"><?= $data['alamat'] ?></dd>
													</dl>
												</div>
												<div class="col-md-6">
													<dl class="row">
														<dt class="col-sm-4 text-muted">Telepon</dt>
														<dd class="col-sm-8"><?= $data['no_telp'] ?></dd>

														<dt class="col-sm-4 text-muted">Status Pembayaran</dt>
														<dd class="col-sm-8">
															<span class="badge bg-<?= $data['status_pembayaran'] ? 'success' : 'danger' ?>">
																<?= $data['status_pembayaran'] ? 'Sudah Dibayar' : 'Belum Dibayar' ?>
															</span>
														</dd>
													</dl>
												</div>
											</div>
										</div>
									</div>

									<script>
										function confirmPickup(event) {
											event.preventDefault(); // Prevent the default form submission

											// Create alert element
											let alertDiv = document.createElement("div");
											alertDiv.innerHTML = `
           <div class="alert alert-dismissible bg-light-warning d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10 position-fixed top-50 start-50 translate-middle shadow-lg" style="z-index: 1050; min-width: 400px;">
    <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-warning" onclick="closeAlert(this)">
        <span class="svg-icon svg-icon-1">
            <i class="fas fa-times"></i>
        </span>
    </button>
    <span class="svg-icon svg-icon-5tx svg-icon-warning mb-5">
        <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
    </span>
    <div class="text-center">
        <h5 class="fw-bolder fs-1 mb-5">Konfirmasi Pengambilan</h5>
        <div class="separator separator-dashed border-warning opacity-50 mb-5"></div>
        <div class="mb-9">
            Apakah Anda yakin ingin mengonfirmasi pengambilan transaksi ini? <br/>
            Tindakan ini tidak dapat dibatalkan.
        </div>
        <div class="d-flex flex-center flex-wrap">
            <button class="btn btn-outline btn-outline-warning btn-active-warning m-2" onclick="closeAlert(this)">Batal</button>
            <button class="btn btn-warning m-2" onclick="document.getElementById('statusForm').submit();">Ya, Konfirmasi</button>
        </div>
    </div>	
</div>

        `;

											// Append to body
											document.body.appendChild(alertDiv);
										}

										// Function to close alert
										function closeAlert(button) {
											button.closest('.alert').remove();
										}
									</script>

									<br><br>
									<?php
									// Get status_pembayaran
									$sql_check = "SELECT status_pembayaran, status FROM transaksi WHERE id_transaksi = " . $_GET['id_transaksi'];
									$result_check = mysqli_query($conn, $sql_check);
									$data_pembayaran = mysqli_fetch_assoc($result_check);
									?>

									<div class="d-flex flex-column align-items-start mb-5">
										<h3 class="mb-3">Detail Layanan</h3>
										<?php if ($data_pembayaran['status_pembayaran'] == '0' && $data_pembayaran['status'] == 'baru'): ?>
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTransaksiModal">
												Tambah Jenis Cucian
											</button>
										<?php endif; ?>
									</div>

									<div class="table-responsive">
										<table class="table table-hover text-nowrap">
											<thead>
												<tr class="text-nowrap">
													<th>No</th>
													<th>Nama Pelanggan</th>
													<th>Tanggal</th>
													<th>Jenis Cucian</th>
													<th>Berat/Jumlah</th>
													<th>Harga</th>
													<th>Total Harga</th>
													<?php
													$qry_user = mysqli_query($conn, "SELECT status_pembayaran, status FROM transaksi WHERE id_transaksi = " . $_GET['id_transaksi']);
													$data_user = mysqli_fetch_array($qry_user);

													// Cek apakah status pembayaran adalah '0' dan status transaksi adalah 'baru'
													if ($data_user['status_pembayaran'] != '1' && $data_user['status'] == 'baru') {
														echo '<th class="">Aksi</th>';
													}
													?>
												</tr>
											</thead>
											<tbody>
												<?php
												$qry_detail_transaksi = mysqli_query($conn, "SELECT detail_transaksi.*, jenis_cucian.nama_jenis_cucian, jenis_cucian.harga, customer.nama_customer, transaksi.tanggal, transaksi.status_pembayaran
                FROM detail_transaksi 
                JOIN jenis_cucian ON jenis_cucian.id_jenis_cucian = detail_transaksi.id_jenis_cucian 
                JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi 
                JOIN customer ON customer.id_customer = transaksi.id_customer 
                WHERE detail_transaksi.id_transaksi = " . $_GET['id_transaksi']);
												$no = 0;
												$total_harga = 0;
												while ($data_detail_transaksi = mysqli_fetch_array($qry_detail_transaksi)) {
													$harga = $data_detail_transaksi['harga'];
													$qty = $data_detail_transaksi['qty'];
													$subtotal = $harga * $qty;
													$total_harga += $subtotal;
													$total_harga_lama = $data_detail_transaksi['total_harga'];
													$no++;
												?>
													<tr class="text-xs fw-bold">
														<td class="align-middle text-left"><?= $no ?></td>
														<td class="align-middle text-left"><?= $data_detail_transaksi['nama_customer'] ?></td>
														<td class="align-middle text-left"><?= $data_detail_transaksi['tanggal'] ?></td>
														<td class="align-middle text-left"><?= $data_detail_transaksi['nama_jenis_cucian'] ?></td>
														<td class="align-middle text-left"><?= $data_detail_transaksi['qty'] ?></td>
														<td class="align-middle text-left">
															<?php if ($data_user['status'] == 'baru') { ?>
																<span>Rp <?= number_format($harga, 0, ',', '.') ?></span>
															<?php } else { ?>
																<span>Rp <?= number_format($total_harga_lama, 0, ',', '.') ?></span>
															<?php } ?>
														</td>
														<td class="align-middle text-left">
															<?php if ($data_user['status'] == 'baru') { ?>
																<span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
															<?php } else { ?>
																<span>Rp <?= number_format($total_harga_lama, 0, ',', '.') ?></span>
															<?php } ?>
														</td>
														<td class="align-middle text-left">
															<?php
															// Cek apakah status pembayaran adalah '0' dan status transaksi adalah 'baru'
															if ($data_user['status_pembayaran'] != '1' && $data_user['status'] == 'baru') {
															?>
																<a href="<?= base_url ?>dashboard/detailtransaksi/hapus_detail_transaksi.php?id_detail_transaksi=<?= $data_detail_transaksi['id_detail_transaksi'] ?>&id_transaksi=<?= $_GET['id_transaksi'] ?>" onclick="return confirmDelete(event, '<?= base_url ?>dashboard/detailtransaksi/hapus_detail_transaksi.php?id_detail_transaksi=<?= $data_detail_transaksi['id_detail_transaksi'] ?>&id_transaksi=<?= $_GET['id_transaksi'] ?>')" class="btn btn-danger">
																	<i class="far fa-trash-alt"></i>
																</a>
															<?php
															}
															?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>

									<!-- Total dan Bayar-->
									<div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 mt-4 bg-light rounded border">
										<div class="d-flex flex-column mb-3">
											<span class="text-muted fs-6">Total Bayar</span>
											<span class="fw-bold fs-4">Rp <?= number_format($total_harga, 0, ',', '.') ?></span>
										</div>
										<div>
											<?php
											$qry_detail_transaksi = mysqli_query(
												$conn,
												"
        SELECT detail_transaksi.*, jenis_cucian.nama_jenis_cucian, jenis_cucian.harga, customer.nama_customer, transaksi.tanggal, transaksi.status_pembayaran, transaksi.status
        FROM detail_transaksi 
        JOIN jenis_cucian ON jenis_cucian.id_jenis_cucian = detail_transaksi.id_jenis_cucian 
        JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi 
        JOIN customer ON customer.id_customer = transaksi.id_customer 
        WHERE detail_transaksi.id_transaksi = " . $_GET['id_transaksi']
											);

											if (mysqli_num_rows($qry_detail_transaksi) > 0) {
												$data_detail_transaksi = mysqli_fetch_array($qry_detail_transaksi);

												// Cek status dan status pembayaran
												if ($data_detail_transaksi['status'] == 'baru' && $data_detail_transaksi['status_pembayaran'] == 0) { ?>
													<div class="d-flex">
														<button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#selesaiModal">
															<i class="fas fa-check me-2"></i>Selesai
														</button>
														<button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#bayarModal">
															<i class="fas fa-money-bill-wave me-2"></i>Bayar
														</button>
													</div>
												<?php } elseif ($data_detail_transaksi['status'] != 'baru' && $data_detail_transaksi['status_pembayaran'] == 0) { ?>
													<div class="d-flex">
														<button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#bayarModal">
															<i class="fas fa-money-bill-wave me-2"></i>Bayar
														</button>
													</div>
											<?php }
											} ?>
										</div>
									</div>

									<!-- Modal Tambah Transaksi -->
									<div class="modal fade" id="tambahTransaksiModal" tabindex="-1" aria-labelledby="tambahTransaksiModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="tambahTransaksiModalLabel">Tambah Jenis Cucian</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<form id="tambahTransaksiForm" method="POST" action="<?= base_url ?>dashboard/detailtransaksi/proses_tambah_detail_transaksi.php">
														<input type="hidden" name="id_transaksi" value="<?= $_GET['id_transaksi'] ?>">
														<div class="mb-3">
															<label for="jenisCucian" class="form-label">Jenis Cucian</label>
															<select id="jenisCucian" name="jenis_cucian" class="form-control" required data-control="select2" tabindex="-1"
																data-dropdown-parent="#tambahTransaksiModal" onchange="setDefaultQuantity()">
																<option value="" disabled selected>Pilih Jenis Cucian</option>
																<?php
																$qry_jenis_cucian = mysqli_query($conn, "SELECT * FROM jenis_cucian WHERE status = '1'");
																while ($data_jenis_cucian = mysqli_fetch_array($qry_jenis_cucian)) {
																	echo '<option value="' . $data_jenis_cucian['id_jenis_cucian'] . '" data-harga="' . $data_jenis_cucian['harga'] . '">' . $data_jenis_cucian['nama_jenis_cucian'] . ' | ' . $data_jenis_cucian['harga'] . '</option>';
																}
																?>
															</select>
														</div>
														<div class="mb-3">
															<label for="beratJumlah" class="form-label">Berat/Jumlah</label>
															<input type="number" id="beratJumlah" name="qty" class="form-control" placeholder="0" required>
														</div>
														<div class="mb-3">
															<label for="totalHarga" class="form-label">Total Harga</label>
															<input type="text" id="totalHarga" name="total_harga" class="form-control" readonly placeholder="0">
														</div>
														<div class="d-flex justify-content-end">
															<button type="button" class="btn btn-secondary me-2" onclick="window.location.href='<?= base_url ?>dashboard/detailtransaksi/index.php?id_transaksi=<?= $_GET['id_transaksi'] ?>'">Batal</button>
															<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
														</div>
													</form>

													<script>
														function setDefaultQuantity() {
															// Set default quantity to 1
															document.getElementById('beratJumlah').value = 1;
															calculateTotal(); // Call calculateTotal to update totalHarga
														}
														document.getElementById('beratJumlah').addEventListener('input', calculateTotal);
														document.getElementById('jenisCucian').addEventListener('change', calculateTotal);

														function calculateTotal() {
															const jenisCucian = document.getElementById('jenisCucian');
															const beratJumlah = document.getElementById('beratJumlah').value;
															const harga = jenisCucian.options[jenisCucian.selectedIndex].getAttribute('data-harga');
															const total = beratJumlah * harga;
															document.getElementById('totalHarga').value = total ? total : 0;
														}
													</script>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal Bayar -->
									<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="bayarModalLabel">Bayar Transaksi</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<form id="bayarForm" method="POST" action="<?= base_url ?>dashboard/detailtransaksi/proses_bayar.php">
														<input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
														<div class="mb-3">
															<label for="totalBayar" class="form-label">Total Bayar</label>
															<input type="text" id="totalBayar" class="form-control" value="<?= number_format($total_harga, 0, ',', '.') ?>" readonly>
															<!-- Input hidden agar tetap mengirim nilai numerik -->
															<input type="hidden" id="total_harga" name="total_harga" value="<?= $total_harga ?>">
														</div>

														<div class="mb-3">
															<label for="nominal" class="form-label">Nominal</label>
															<input type="text" id="nominal" class="form-control" onkeyup="formatCurrency(this)" placeholder="Masukkan nominal">
															<!-- Input hidden untuk menyimpan nilai numerik -->
															<input type="hidden" id="total_bayar" name="total_bayar">
														</div>

														<script>
															function formatCurrency(input) {
																// Hapus semua karakter non-digit
																let rawValue = input.value.replace(/[^0-9]/g, '');

																// Simpan nilai numerik ke input hidden
																document.getElementById('total_bayar').value = rawValue;

																// Format tampilan dengan separator ribuan
																input.value = new Intl.NumberFormat('id-ID').format(rawValue);
															}
														</script>

														<div class="d-flex justify-content-end">
															<button type="submit" class="btn btn-primary">Bayar</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal untuk Selesai -->
									<div class="modal fade" id="selesaiModal" tabindex="-1" aria-labelledby="selesaiModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="selesaiModalLabel">Layanan Selesai</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													Apakah Anda yakinkan bahwa layanan sudah selesai?
												</div>
												<form action="<?= base_url ?>dashboard/detailtransaksi/proses_layanan_selesai.php" method="post">
													<input type="hidden" name="id_transaksi" value="<?= $_GET['id_transaksi'] ?>">
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
														<button type="submit" class="btn btn-primary" id="confirmSelesai">Selesai</button>
													</div>
												</form>

											</div>
										</div>
									</div>



									<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
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
	<!--end::Modal - Create App-->
	<!--end::Modals-->
	<!--begin::Scrolltop-->
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
		<span class="svg-icon">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<polygon points="0 0 24 0 24 24" />
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
                    Apakah Anda yakin ingin menghapus layanan ini? <br/>
                    Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="d-flex flex-center flex-wrap">
                    <a href="<?= base_url ?>dashboard/detailtransaksi/index.php" class="btn btn-outline btn-outline-danger btn-active-danger m-2" onclick="closeAlert(this)">Batal</a>
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

	<?php if (isset($_SESSION['alert_kembalian'])) : ?>
		<script>
			window.onload = function() {
				showKembalianAlert("<?= $_SESSION['alert_kembalian'] ?>");
			}
		</script>
		<?php unset($_SESSION['alert_kembalian']); ?>
	<?php endif; ?>

	<script>
		function showKembalianAlert(message) {
			// Hapus alert lama jika ada
			let existingAlert = document.querySelector(".custom-alert");
			if (existingAlert) {
				existingAlert.remove();
			}

			// Buat elemen alert
			let alertDiv = document.createElement("div");
			alertDiv.classList.add("custom-alert");
			alertDiv.innerHTML = `
        <div class="alert alert-dismissible bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10 position-fixed top-50 start-50 translate-middle shadow-lg" style="z-index: 1050; min-width: 400px;">
            <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-success" onclick="closeKembalianAlert()">
                <span class="svg-icon svg-icon-1">
					<i class="fas fa-times"></i>
				</span>
            </button>
            <span class="svg-icon svg-icon-5tx svg-icon-success mb-5">
				<i class="fas fa-check-circle fa-3x text-success"></i>
			</span>
            <div class="text-center">
                <h5 class="fw-bolder fs-1 mb-5">Pembayaran Berhasil!</h5>
                <div class="separator separator-dashed border-success opacity-25 mb-5"></div>
                <div class="mb-9">
                    ${message}
                </div>
                <button class="btn btn-success m-2" onclick="closeKembalianAlert()">OK</button>
            </div>	
        </div>`;

			// Tambahkan ke body
			document.body.appendChild(alertDiv);
		}

		// Fungsi untuk menutup alert
		function closeKembalianAlert() {
			let alertElement = document.querySelector(".custom-alert");
			if (alertElement) {
				alertElement.remove();
			}
		}
	</script>


	<?php include '../layout/footer.php' ?>