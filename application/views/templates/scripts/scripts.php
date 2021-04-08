    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/jquery-mask/jquery.mask.min.js"></script>
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/jquery-ui/jquery-ui.min.js"></script>


    <!-- DataTables -->
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Select2 -->
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/select2/js/select2.min.js"></script>

    <!-- Datepicker -->
    <script src="<?= base_url('assets/sbadmin2/'); ?>vendor/datepicker/datepicker.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/sbadmin2/'); ?>js/sb-admin-2.min.js"></script>

    <!-- My Scripts -->
    <script src="<?= base_url('assets/js/'); ?>main.js"></script>

    <?php $this->load->view('templates/scripts/datatables'); ?>

    <?php if (strtolower($this->uri->segment(1)) == 'sales') : ?>
        <?php $this->load->view('templates/scripts/sales_scripts'); ?>
    <?php endif; ?>

    <script>
        $('[data-toggle="datepicker"]').datepicker();
    </script>