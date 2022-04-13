<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php $this->renderSection("title") ?></title>

    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("pic/saturasi-logo.png") ?>">

    <link href="<?= base_url("main/lib/@fortawesome/fontawesome-free/css/all.min.css") ?>" rel="stylesheet">

    <link href="<?= base_url("main/assets/css/dashforge.min.css") ?>" rel="stylesheet">
    <link href="<?= base_url("main/assets/css/dashforge.demo.css") ?>" rel="stylesheet">
</head>
<body class="tx-lexend">

<div class="container mt-3 col-md-6 col-lg-4 col-xl-3">
    <h3>Kehadiran Acara HMSI</h3>
    <p class="tx-gray-700 tx-12">Silakan melakukan registrasi acara hari ini</p>

    <?php $this->renderSection("konten") ?>

    <footer class="content-footer tx-9 mb-3">
        <div class="order-sm-1 order-lg-1">
            <span>Copyright &copy; 2022 by <a href="https://arek.its.ac.id/hmsi" target="_blank">HMSI ITS</a></span>
        </div>
        <div class="order-sm-2 order-lg-2">
            <span>Support by <a href="https://www.tekan.id" target="_blank">Tekan.ID</a></span><br>
        </div>
    </footer>
</div>

<script src="<?= base_url("main/lib/jquery/jquery.min.js") ?>"></script>
<script src="<?= base_url("main/lib/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= base_url("main/lib/feather-icons/feather.min.js") ?>"></script>
<script src="<?= base_url("main/lib/parsleyjs/parsley.min.js") ?>"></script>
<script src="<?= base_url("main/assets/js/dashforge.js") ?>"></script>

<?php $this->renderSection("js") ?>
</body>
</html>