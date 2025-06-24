<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

?>

<head>
    <title><?php echo $language["track_parcel"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <script scr="assets/js/custome.js"></script>

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

</head>

<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Bread Cump -->
                 <div class="row mt-4">
                    <div class="col-5">
                        <label for="" class="form-label">Scan LR Number :</label>
                        <input type="text" name="serial_number" id="serial_number" class="form-control border-primary p-3" autofocus>
                        <input type="hidden" name="userbranch" id="userbranch" class="userbranch" value="<?php echo $userbranch ;?>">
                    </div>
                 </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php require_once('layouts/main/footer.php'); ?>
    </div>
    <!-- end main content-->

</div>

<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?php require_once('layouts/menu/right-sidebar.php'); ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

<?php require_once('layouts/stylescript/vendor-scripts.php'); ?>

<!-- init js -->
<script src="assets/js/app.js"></script>

<!-- choices js -->
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<?php require_once('layouts/footer/transportb.php'); ?>

<!-- datatable js -->
<script type="text/javascript" charset="utf8"
    src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

</body>

</html>