<!--end::Main-->
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="<?= base_url ?>assets/plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url ?>assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="<?= base_url ?>assets/js/custom/widgets.js"></script>
<!--end::Page Custom Javascript-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>





<?php if (isset($_SESSION['error'])) : ?>
    <script>
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "<?php echo $_SESSION['error']; ?>",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif ?>

<?php if (isset($_SESSION['success'])) : ?>
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "<?php echo $_SESSION['success']; ?>",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif ?>

<?php if (isset($_SESSION['kembalian'])) : ?>
    <script>
        Swal.fire({
            title: "<?php echo $_SESSION['kembalian']; ?>",
            icon: "info"
        });
    </script>
    <?php unset($_SESSION['kembalian']); ?>
<?php endif ?>
<!--end::Javascript-->
</body>
<!--end::Body-->