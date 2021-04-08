<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('templates/head'); ?>
</head>

<body>
    hello

    <?php $this->load->view('templates/scripts/scripts'); ?>
    <script>
        window.print();
        window.onafterprint = function(event) {
            window.location.href = "<?= site_url('Sales'); ?>"
        }
    </script>
</body>

</html>