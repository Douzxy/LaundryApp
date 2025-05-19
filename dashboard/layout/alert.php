<?php
if (!function_exists('displayAlert')) {
    function displayAlert()
    {
        if (isset($_SESSION['alert'])) {
            $alertType = $_SESSION['alert']['type'] ?? 'info';
            $alertTitle = $_SESSION['alert']['title'] ?? 'Informasi';
            $alertMessage = $_SESSION['alert']['message'] ?? 'Terjadi kesalahan.';
            $alertIcon = '';

            // Tentukan ikon dan warna border berdasarkan jenis alert
            switch ($alertType) {
                case "danger":
                    $alertIcon = '<i class="fas fa-times-circle fa-2x text-danger"></i>';
                    break;
                case "warning":
                    $alertIcon = '<i class="fas fa-exclamation-triangle fa-2x text-warning"></i>';
                    break;
                case "info":
                    $alertIcon = '<i class="fas fa-info-circle fa-2x text-info"></i>';
                    break;
                case "success":
                    $alertIcon = '<i class="fas fa-check-circle fa-2x text-success"></i>';
                    break;
                default:
                    $alertIcon = '<i class="fas fa-bell fa-2x text-secondary"></i>';
            }

            // Tampilkan alert
            echo "<div id='alertBox' class='alert alert-$alertType position-fixed top-0 end-0 m-3 p-4 d-flex align-items-center shadow-lg' 
            style='width: 250px; max-width: 350px; z-index: 1050;'
     >
        <div class='me-3'>$alertIcon</div>
        <div>
            <div class='fw-bold fs-5'>$alertTitle</div>
            <div class='fs-6'>$alertMessage</div>
        </div>
        <button type='button' class='btn-close ms-auto' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>

     <style>
        @media (min-width: 768px) {
            #alertBox {
                width: 350px !important;
            }
        }
     </style>";


            // Hapus alert dari session setelah ditampilkan
            unset($_SESSION['alert']);

            // Script untuk menyembunyikan alert setelah 3 detik dengan efek fade-out
            echo "<script>
                setTimeout(function() {
                    var alertBox = document.getElementById('alertBox');
                    if (alertBox) {
                        alertBox.style.opacity = '0';
                        setTimeout(function() {
                            alertBox.remove(); 
                        }, 500);
                    }
                }, 5000); // Muncul selama 5 detik sebelum fade-out
            </script>";
        }
    }
}