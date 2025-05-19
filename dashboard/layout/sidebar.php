<?php
include "../koneksi.php";

function is_active($url)
{
    // Mendapatkan URL saat ini
    $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Menghapus query string dari URL saat ini
    $current_url = strtok($current_url, '?');

    // Memeriksa apakah URL yang diberikan cocok dengan URL saat ini
    return ($current_url == $url) ? 'active' : '';
}
?>

<!--begin::Aside-->
<div id="kt_aside" class="aside aside-extended bg-white" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
    <!--begin::Primary-->
    <div class="aside-primary d-flex flex-column align-items-lg-center flex-row-auto">
        <!--begin::Logo-->
        <div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto pt-10" id="kt_aside_logo">
            <a href="<?= base_url ?>dashboard/index.php">
                <img alt="Logo" src="<?= base_url ?>assets/img/logo.png" class="h-50px" />
            </a>
        </div>
        <!--end::Logo-->
        <!--begin::Nav-->
        <div class="aside-nav d-flex flex-column flex-lg-center flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
            <!--begin::Primary menu-->
            <div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-bold fs-5" data-kt-menu="true">
                <!-- begin::Dashboard -->
                <?php if ($_SESSION['level'] == 'admin') : ?>

                    <div class="menu-item py-2">
                        <a class="menu-link  <?= is_active(base_url . 'dashboard/index.php') ?> menu-center" href="<?= base_url ?>dashboard/index.php" title="Dashboard" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon me-0">
                                <!--begin::Svg Icon | path: icons/duotone/Home/Home2.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M21.4622 10.699C21.4618 10.6986 21.4613 10.6981 21.4609 10.6977L13.3016 2.53955C12.9538 2.19165 12.4914 2 11.9996 2C11.5078 2 11.0454 2.1915 10.6974 2.5394L2.54246 10.6934C2.53971 10.6961 2.53696 10.699 2.53422 10.7018C1.82003 11.42 1.82125 12.5853 2.53773 13.3017C2.86506 13.6292 3.29739 13.8188 3.75962 13.8387C3.77839 13.8405 3.79732 13.8414 3.81639 13.8414H4.14159V19.8453C4.14159 21.0334 5.10833 22 6.29681 22H9.48897C9.81249 22 10.075 21.7377 10.075 21.4141V16.707C10.075 16.1649 10.516 15.7239 11.0582 15.7239H12.941C13.4832 15.7239 13.9242 16.1649 13.9242 16.707V21.4141C13.9242 21.7377 14.1866 22 14.5102 22H17.7024C18.8909 22 19.8576 21.0334 19.8576 19.8453V13.8414H20.1592C20.6508 13.8414 21.1132 13.6499 21.4613 13.302C22.1786 12.5844 22.1789 11.4171 21.4622 10.699V10.699Z" fill="#00B2FF" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </a>
                    </div>
                    <!-- end::Dashboard -->

                    <!-- begin::user -->
                    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-flip="bottom" class="menu-item py-2">
                        <a href="<?= base_url ?>dashboard/user/index.php">
                            <span class="menu-link <?= (is_active(base_url . 'dashboard/user/index.php') || is_active(base_url . 'dashboard/user/ubah_user.php')) ? 'active' : '' ?> menu-center" title="Akun Petugas" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                <span class="menu-icon me-0">
                                    <!--begin::Svg Icon | path: icons/duotone/Communication/Group.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                        </a>
                    </div>
                    <!-- end::user -->

                    <!-- begin::jenis cucian -->
                    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-flip="bottom" class="menu-item py-2">
                        <a href="<?= base_url ?>dashboard/jeniscucian/index.php">
                            <span class="menu-link <?= (is_active(base_url . 'dashboard/jeniscucian/index.php') || is_active(base_url . 'dashboard/jeniscucian/ubah_jenis_cucian.php')) ? 'active' : '' ?> menu-center" title="Jenis Cucian" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                <span class="menu-icon me-0">
                                    <!--begin::Svg Icon | path: icons/duotone/Clothes/Tshirt.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M9 3C9 4.65685 7.65685 6 6 6H4C2.89543 6 2 6.89543 2 8V9C2 10.1046 2.89543 11 4 11H6V21H18V11H20C21.1046 11 22 10.1046 22 9V8C22 6.89543 21.1046 6 20 6H18C16.3431 6 15 4.65685 15 3H9Z" fill="#000000" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                        </a>
                    </div>
                    <!-- end::jenis cucian -->

                    <!-- begin::laporan -->
                    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-flip="bottom" class="menu-item py-2">
                        <span class="menu-link <?= (is_active(base_url . 'dashboard/laporan/index.php') || is_active(base_url . 'dashboard/laporan/customer.php')) ? 'active' : '' ?> menu-center" title="Laporan" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon me-0">
                                <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 2C5.44772 2 5 2.44772 5 3V21C5 21.5523 5.44772 22 6 22H18C18.5523 22 19 21.5523 19 21V7L14 2H6Z" fill="#000000" />
                                        <path d="M14 2V7H19" fill="#000000" />
                                        <rect x="7" y="11" width="3" height="5" fill="white" />
                                        <rect x="11" y="9" width="3" height="7" fill="white" />
                                        <rect x="15" y="13" width="3" height="3" fill="white" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                        <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4">
                            <div class="menu-item">
                                <div class="menu-content">
                                    <span class="menu-section fs-5 fw-bolder ps-1 py-1">Laporan</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="<?= base_url ?>dashboard/laporan/index.php">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Laporan Keuangan dan Pekerjaan</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="<?= base_url ?>dashboard/laporan/customer.php">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Customer</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end::laporan -->

                <?php endif; ?>

                <?php if ($_SESSION['level'] == 'petugas') : ?>
                    <div class="menu-item py-2">
                        <a class="menu-link <?= is_active(base_url . 'dashboard/index.php') ?> menu-center" href="<?= base_url ?>dashboard/index.php" title="Dashboard" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                            <span class="menu-icon me-0">
                                <!--begin::Svg Icon | path: icons/duotone/Home/Home2.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M21.4622 10.699C21.4618 10.6986 21.4613 10.6981 21.4609 10.6977L13.3016 2.53955C12.9538 2.19165 12.4914 2 11.9996 2C11.5078 2 11.0454 2.1915 10.6974 2.5394L2.54246 10.6934C2.53971 10.6961 2.53696 10.699 2.53422 10.7018C1.82003 11.42 1.82125 12.5853 2.53773 13.3017C2.86506 13.6292 3.29739 13.8188 3.75962 13.8387C3.77839 13.8405 3.79732 13.8414 3.81639 13.8414H4.14159V19.8453C4.14159 21.0334 5.10833 22 6.29681 22H9.48897C9.81249 22 10.075 21.7377 10.075 21.4141V16.707C10.075 16.1649 10.516 15.7239 11.0582 15.7239H12.941C13.4832 15.7239 13.9242 16.1649 13.9242 16.707V21.4141C13.9242 21.7377 14.1866 22 14.5102 22H17.7024C18.8909 22 19.8576 21.0334 19.8576 19.8453V13.8414H20.1592C20.6508 13.8414 21.1132 13.6499 21.4613 13.302C22.1786 12.5844 22.1789 11.4171 21.4622 10.699V10.699Z" fill="#00B2FF" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </a>
                    </div>
                    <!-- end::Dashboard -->

                    <!-- begin::Pelanggan -->
                    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-flip="bottom" class="menu-item py-2">
                        <a href="<?= base_url ?>dashboard/customer/index.php">
                            <span class="menu-link <?= (is_active(base_url . 'dashboard/customer/index.php') || is_active(base_url . 'dashboard/customer/ubah_customer.php')) ? 'active' : '' ?> menu-center" title="Pelanggan" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                <span class="menu-icon me-0">
                                    <!--begin::Svg Icon | path: icons/duotone/Communication/User.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z" fill="#E4E6EF" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                        </a>
                    </div>
                    <!-- end::Pelanggan -->

                    <!-- begin::Transaksi -->
                    <div data-kt-menu-trigger="click" data-kt-menu-placement="right-start" data-kt-menu-flip="bottom" class="menu-item py-2">
                        <a href="<?= base_url ?>dashboard/transaksi/index.php">
                            <span class="menu-link  <?= (is_active(base_url . 'dashboard/transaksi/index.php') || is_active(base_url . 'dashboard/detailtransaksi/index.php')) ? 'active' : '' ?> menu-center" title="Transaksi" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                <span class="menu-icon me-0">
                                    <!--begin::Svg Icon | path: icons/duotone/Shopping/Cart6.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M16.0546 7.08943H17.8078L15.2088 2.39571C14.9994 2.01537 14.5354 1.88571 14.1741 2.11045C13.8128 2.33088 13.6896 2.81927 13.9031 3.1996L16.0546 7.08943Z" fill="#E4E6EF" />
                                            <path d="M10.1051 3.19921C10.3145 2.81887 10.1954 2.33048 9.83411 2.11006C9.47279 1.88963 9.00882 2.01497 8.79942 2.39531L6.20037 7.09336H7.9536L10.1051 3.19921Z" fill="#E4E6EF" />
                                            <path d="M20.7107 8.52869H3.28516C2.57483 8.52869 2 9.13377 2 9.88148V11.3812C2 12.1289 2.57483 12.734 3.28516 12.734H3.68754L4.92753 19.8092C5.08356 20.6433 5.8062 21.3046 6.55759 21.3046H7.0503H10.2858C10.6142 21.3046 11.0413 21.3046 11.4765 21.3046H11.8707H12.2648C12.7001 21.3046 13.1271 21.3046 13.4556 21.3046H16.691H17.1837C17.9351 21.3046 18.6578 20.6433 18.8138 19.8092L20.062 12.7297H20.7148C21.4252 12.7297 22 12.1246 22 11.3769V9.87716C21.9959 9.13377 21.4211 8.52869 20.7107 8.52869ZM9.09505 15.5995V18.6509C9.09505 19.0874 8.75837 19.4159 8.3683 19.4159C7.9536 19.4159 7.64155 19.0615 7.64155 18.6509V17.3716V14.3721C7.64155 13.9356 7.97824 13.6071 8.3683 13.6071C8.783 13.6071 9.09505 13.9615 9.09505 14.3721V15.5995ZM11.4272 15.5995V18.6509C11.4272 19.0874 11.0905 19.4159 10.7005 19.4159C10.2858 19.4159 9.97372 19.0615 9.97372 18.6509V17.3716V14.3721C9.97372 13.9356 10.3104 13.6071 10.7005 13.6071C11.0905 13.6071 11.4272 13.9615 11.4272 14.3721V15.5995ZM13.7717 17.3716V18.6509C13.7717 19.0615 13.4597 19.4159 13.045 19.4159C12.6549 19.4159 12.3182 19.0874 12.3182 18.6509V15.5995V14.3721C12.3182 13.9615 12.6549 13.6071 13.045 13.6071C13.435 13.6071 13.7717 13.9356 13.7717 14.3721V17.3716ZM16.1039 17.3716V18.6509C16.1039 19.0615 15.7918 19.4159 15.3771 19.4159C14.9871 19.4159 14.6504 19.0874 14.6504 18.6509V15.5995V14.3721C14.6504 13.9615 14.9624 13.6071 15.3771 13.6071C15.7672 13.6071 16.1039 13.9356 16.1039 14.3721V17.3716Z" fill="#E4E6EF" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                        </a>
                    </div>
                    <!-- end::Transaksi -->


                <?php endif; ?>
            </div>
            <!--end::Primary menu-->
        </div>
        <!--end::Nav-->
        <!--begin::Footer-->
        <div class="aside-footer d-flex flex-column align-items-center flex-column-auto" id="kt_aside_footer">
            <?php if ($_SESSION['level'] == 'admin') : ?>
                <!--begin::Menu-->
                <div class="mb-7">
                    <button type="button" class="<?= is_active(base_url . 'dashboard/user/pengaturan_user.php') ?> btn btm-sm btn-icon btn-color-gray-400 btn-active-color-primary btn-active-light" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Pengaturan">
                        <!--begin::Svg Icon | path: icons/duotone/Communication/Dial-numbers.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-lg-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="" height="" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                    <!--begin::Menu 2-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Pengaturan</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mb-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="<?= base_url ?>dashboard/user/pengaturan_user.php" class="menu-link px-3">Pengaturan Akun</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="<?= base_url ?>dashboard/logout.php" class="menu-link px-3">Keluar</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mt-3 opacity-75"></div>
                        <!--end::Menu separator-->
                    </div>
                </div>
                <!--end::Menu 2-->
        </div>
        <!--end::Menu-->
    <?php endif; ?>

    <?php if ($_SESSION['level'] == 'petugas') : ?>
        <!--begin::Menu-->
        <div class="mb-7">
            <button type="button" class="menu-link  <?= is_active(base_url . 'dashboard/user/pengaturan_user.php') ?> btn btm-sm btn-icon btn-color-gray-400 btn-active-color-primary btn-active-light" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Pengaturan">
                <!--begin::Svg Icon | path: icons/duotone/Communication/Dial-numbers.svg-->
                <span class="svg-icon svg-icon-2 svg-icon-lg-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="" height="" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
            <!--begin::Menu 2-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Pengaturan</div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator mb-3 opacity-75"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="<?= base_url ?>dashboard/user/pengaturan_user.php" class="menu-link px-3">Pengaturan Akun</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="<?= base_url ?>dashboard/logout.php" class="menu-link px-3">Keluar</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator mt-3 opacity-75"></div>
                <!--end::Menu separator-->
            </div>
            <!--end::Menu 2-->
        </div>
        <!--end::Menu-->
    <?php endif; ?>

    </div>
    <!--end::Footer-->
</div>
<!--end::Primary-->
<!--begin::Action-->
<!--end::Action-->
</div>
<!--end::Aside-->