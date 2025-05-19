<?php include "../layout/header.php";
displayAlert();

// Cek level pengguna

// if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'petugas') {
//     $_SESSION['alert'] = [
//         'type' => 'danger',
//         'title' => 'Akses Ditolak!',
//         'message' => 'Anda tidak memiliki akses untuk membuka halaman tersebut.'
//     ];
//     header("Location: ../index.php"); // Arahkan ke halaman utama
//     exit();
// } 
?>

<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <?php include "../layout/sidebar.php"; ?>
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
                            <li class="breadcrumb-item text-dark">Pengaturan</li>
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
                        <a href="index.html" class="d-flex align-items-center">
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
                <!-- Add this inside content container -->
                <div class="container" id="kt_content_container">
                    <div class="row g-5 g-xl-8">
                        <!-- Profile Settings Card -->
                        <div class="col-xl-6">
                            <div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm hover-elevate-up">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1">
                                            <i class="fas fa-user-cog text-primary me-2"></i>Pengaturan Profil
                                        </span>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?= base_url ?>dashboard/user/proses_pengaturan_ubah_user.php">
                                        <?php
                                        // Get user data from database
                                        $id_user = $_SESSION['id_user']; // Assuming you have user session
                                        $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'");
                                        $user = mysqli_fetch_array($query);
                                        ?>

                                        <div class="mb-3">
                                            <label class="form-label required">Nama</label>
                                            <input type="text" class=" form-control" name="nama_user" value="<?= $user['nama_user'] ?? '' ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?= $user['username'] ?? '' ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Nomor Telepon</label>
                                            <input type="text" class="form-control" name="no_telp" value="<?= $user['no_telp'] ?? '' ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Security Settings Card -->
                        <div class="col-xl-6">
                            <div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm hover-elevate-up">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1">
                                            <i class="fas fa-shield-alt text-danger me-2"></i>Pengaturan Keamanan
                                        </span>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?= base_url ?>dashboard/user/proses_pengaturan_password_user.php">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Password Lama</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control pe-5" name="old_password" id="oldPassword" placeholder="********" required>
                                                        <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" data-target="oldPassword">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Password Baru</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control pe-5" name="new_password" id="newPassword" required placeholder="********">
                                                        <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" data-target="newPassword">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                            <button type="submit" class="btn btn-danger text-nowrap">
                                                <i class="fas fa-lock me-2"></i>Simpan Perubahan
                                            </button>

                                            <!-- Tambahkan FontAwesome jika belum ada -->
                                            <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

                                            <script>
                                                document.querySelectorAll('.toggle-password').forEach(button => {
                                                    button.addEventListener('click', function() {
                                                        let target = document.getElementById(this.getAttribute('data-target'));
                                                        let icon = this.querySelector('i');

                                                        if (target.type === "password") {
                                                            target.type = "text";
                                                            icon.classList.replace("fa-eye", "fa-eye-slash");
                                                        } else {
                                                            target.type = "password";
                                                            icon.classList.replace("fa-eye-slash", "fa-eye");
                                                        }
                                                    });
                                                });
                                            </script>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Add this below the Security Settings Card in the same container -->
                        <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>
                            <!-- Admin Version -->
                            <div class="col-xl-12 mt-5">
                                <div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm hover-elevate-up border-left-primary">
                                    <div class="card-header border-0 pt-5 bg-light-primary">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder fs-3 mb-1">
                                                <i class="fas fa-shield-alt text-primary me-2"></i>Catatan Keamanan Admin
                                            </span>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-primary d-flex align-items-center p-5 mb-10">
                                            <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
                                                <i class="fas fa-user-shield fa-2x"></i>
                                            </span>
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-primary">Akses Admin & Pemulihan Akun</h4>
                                                <span>Sebagai Admin, Anda memiliki kemampuan untuk mereset akun pengguna dan mengatur ulang kredensial.</span>
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <h5 class="fw-bold mb-3"><i class="fas fa-cogs text-primary me-2"></i>Prosedur Reset Akun:</h5>
                                            <ol class="list-group list-group-numbered mb-5">

                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Kredensial Default Admin</div>
                                                        Jika akun admin Anda direset, kredensial default: Username "admin" dan Password "admin"
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Pemulihan Darurat</div>
                                                        Untuk pemulihan darurat, gunakan file darurat.php seperti yang dijelaskan pada Manual Book halaman 47.
                                                    </div>
                                                </li>
                                            </ol>
                                        </div>

                                        <div class="separator my-10"></div>

                                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6">
                                            <span class="svg-icon svg-icon-2tx svg-icon-danger me-4">
                                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                            </span>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-bold">
                                                    <h4 class="text-gray-900 fw-bolder">Pengingat Penting</h4>
                                                    <div class="fs-6 text-gray-700">Selalu simpan kredensial admin dengan aman dan jangan bagikan dengan siapapun. Sebagai admin sistem, Anda bertanggung jawab untuk keamanan data dan akses pengguna.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php elseif (isset($_SESSION['level']) && $_SESSION['level'] === 'petugas'): ?>
                            <!-- Petugas Version -->
                            <div class="col-xl-12 mt-5">
                                <div class="card card-xl-stretch mb-5 mb-xl-8 shadow-sm hover-elevate-up border-left-warning">
                                    <div class="card-header border-0 pt-5 bg-light-warning">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder fs-3 mb-1">
                                                <i class="fas fa-exclamation-circle text-warning me-2"></i>Catatan Penting untuk Petugas
                                            </span>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                                <i class="fas fa-key fa-2x"></i>
                                            </span>
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-warning">Lupa Username atau Password?</h4>
                                                <span>Jika Anda lupa username atau password setelah mengubahnya, silahkan ikuti langkah berikut:</span>
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <h5 class="fw-bold mb-3"><i class="fas fa-cogs text-warning me-2"></i>Prosedur Pemulihan Akun:</h5>
                                            <ol class="list-group list-group-numbered mb-5">
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Hubungi Admin Sistem</div>
                                                        Segera hubungi admin sistem untuk melakukan reset akun Anda.
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Berikan Informasi Akun</div>
                                                        Siapkan informasi seperti nama lengkap, username, dan nomor telepon untuk verifikasi identitas.
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">Ikuti Prosedur Verifikasi</div>
                                                        Admin akan meminta beberapa informasi untuk memverifikasi identitas Anda sebelum mereset akun.
                                                    </div>
                                                </li>
                                            </ol>
                                        </div>

                                        <div class="separator my-10"></div>

                                        <div class="d-flex align-items-center mb-5">
                                            <div class="symbol symbol-50px me-5">
                                                <span class="symbol-label bg-light-info">
                                                    <i class="fas fa-phone-alt text-info"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1">Kontak Admin</h4>
                                                <span>Untuk bantuan segera, hubungi admin sistem di ekstensi 4455 atau email: admin@laundryapp.com</span>
                                            </div>
                                        </div>

                                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                            <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                                <i class="fas fa-lightbulb text-primary"></i>
                                            </span>
                                            <div class="d-flex flex-stack flex-grow-1">
                                                <div class="fw-bold">
                                                    <h4 class="text-gray-900 fw-bolder">Tip Keamanan</h4>
                                                    <div class="fs-6 text-gray-700">Gunakan password yang kuat dan unik. Jangan gunakan password yang sama untuk akun lain. Jangan pernah membagikan informasi login Anda dengan orang lain.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
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

<?php include '../layout/footer.php'; ?>