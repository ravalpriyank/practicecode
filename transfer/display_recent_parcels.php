<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("main_const.php");

?>

<head>
    <title><?php echo $language["Parcels"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script scr="assets/js/custome.js"></script>

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

</head>

<?php
require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');
?>

<div id="layout-wrapper">
    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="container-fluid">
        <div class="main-content pt-5 mt-5">
            <div class="date_3 pt-4 row align-items-center">
                <div class="col-lg-7">
                </div>
                <div class="col-lg-5">
                    <div class="row">

                        <?php if (isset($_GET["sendername"]) && isset($_GET["receivername"])) { ?>
                            <input type="hidden" name="sender" id="sender"
                                value="<?php echo !empty($_GET["sendername"]) ? $_GET["sendername"] : ""; ?>">
                            <input type="hidden" name="receiver" id="receiver"
                                value="<?php echo !empty($_GET["receivername"]) ? $_GET["receivername"] : ""; ?>">
                        <?php }
                        ; ?>

                        <?php if (isset($_GET["type"])) { ?>
                            <input type="hidden" name="type"
                                value="<?php echo !empty($_GET["type"]) ? $_GET["type"] : ""; ?>" id="type" class="type">
                        <?php }
                        ; ?>

                        <form action="#" method="GET">
                            <div class="row">
                                <div class="col-lg-7 pb-3">
                                    <div class="date">
                                        <input type="date" name="filter_date" id="filter_date"
                                            class="p-2 w-100 model_inputs">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <?php if (isset($_GET["filter_date"])) {
                                        ; ?>
                                        <input type="hidden" id="fdate" name="fdate"
                                            value="<?php echo !empty($_GET["filter_date"]) ? $_GET["filter_date"] : ""; ?>">
                                    <?php }
                                    ; ?>
                                    <button type="submit"
                                        class="btn btn-filter btn-success w-100"><?php echo !empty($language["FindAllLR"]) ? $language["FindAllLR"] : ""; ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </form>
            </div>
            <div class="mb-5">
                <input type="hidden" id="extra_charge" name="extra_charge"
                    value="<?php echo !empty($extra) ? $extra : 0; ?>">
                <input type="hidden" name="current_receipt_format" id="current_receipt_format"
                    value="<?php echo isset($printreceiptformat) && !empty($printreceiptformat) ? $printreceiptformat : ""; ?>">
                <?php require_once("display_parcel_details.php"); ?>
            </div>
        </div>
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

</body>

</html>