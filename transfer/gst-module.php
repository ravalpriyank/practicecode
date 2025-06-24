<?php
require_once('layouts/mainheader.php');
require_once("connection.php");


$lrno = !empty($_GET["lr_no"]) ? $_GET["lr_no"] : "";
$time = !empty($_GET["time"]) ? date_create($_GET["time"]) : "";
$date = !empty($time) ? date_format($time, "Y-m-d H:i:s") : "";

$query = "SELECT * FROM `transportz` WHERE `lrn` = '$lrno' AND `timestamp` ='$date' AND `branch` = '$userbranch'";
$run_query = mysqli_query($conn2, $query);
$data = mysqli_fetch_assoc($run_query);

$total_item = isset($data["item"]) ? count(explode(",", $data["item"])) : "";

$bquery = "SELECT * FROM `parcel_companies`";
$run_bquery = mysqli_query($conn1, $bquery);
$bdata = mysqli_fetch_assoc($run_bquery);

?>

<head>
    <title><?php echo $language["Transport"]; ?> | GT Solution</title>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<style>
    .error {
        color: red;
    }
</style>
<?php
require_once("layouts/main/body.php");
require_once("layouts/header/transporta.php");
require_once("layouts/logic/transportlogic.php");
?>

<div id="layout-wrapper">
    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="title pt-2 text-center ">
                    <h3 class=" mb-4">
                        <?php echo !empty($companynamef) ? $companynamef : "Prajapati Express Parcel Service"; ?>
                    </h3>
                </div>
                <!-- Bread Cump -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card" style="width: 98%;">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 d-flex gap-2 align-items-center">
                                    <h1 class="mb-0"> <span
                                            class="bg-success border border-success rounded ps-4 pe-4 text-white">
                                            <?php echo isset($_GET["lr_no"]) ? $_GET["lr_no"] : $viewlastgstnumber; ?>
                                        </span></h1>
                                    <form action="#" method="POST" class="get_customer">
                                        <div class="relation_id">
                                            <input type="text" class="form-control py-2" name="relation_no"
                                                id="relation_no" placeholder="Enter Relation Id">
                                            <input type="submit" id="submit" class="submit d-none">
                                        </div>
                                    </form>
                                </div>
                                <div class="flex-shrink-0">
                                    <ul class="nav nav-tabs-custom card-header-tabs pr-4" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="jamabakibutton" href="transport.php?page=transport">
                                                <?php echo $language['topay'] . "/" . $language['topaid']; ?>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link active" href="gst-module.php?page=gst" id="gstbutton">
                                                <?php echo $language['gst']; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="ml-2" style="margin-left: 25px;">
                                    <button class="btn btn-danger delete" id="removeRows" type="button">-</button>
                                    <button class="btn btn-success" id="addRows" type="button">+</button>
                                    <button class="btn btn-dark" id="manual" type="button">M</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <?php
                                    require_once('layouts/form/transportentry.php');
                                    ?>
                                </div>
                                <!-- end tab content -->
                            </div>

                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
            <div>
                <?php require_once("bill_receipt_modals.php"); ?>
            </div>
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

<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<?php require_once('layouts/footer/transportb.php'); ?>

</body>

</html>