<?php
date_default_timezone_set('Asia/Kolkata');

require_once('layouts/mainheader.php');
require_once("connection.php");

if (isset($_GET) && isset($_GET["date"]) && isset($_GET["branch_filter"])) {
    $date = !empty($_GET["date"]) ? $_GET["date"] : "";
    $place = !empty($_GET["branch_filter"]) ? $_GET["branch_filter"] : "";
} else {
    $date = date("Y-m-d");
}

if (isset($_GET) && isset($_GET["date"]) && isset($_GET["branch_filter"])) {
    $query = "SELECT * FROM `transportz` WHERE branch = '$userbranch' AND `place` = '$place' AND DATE(entrydate) = '$date' AND `status` NOT IN ('deleted','close')";
    $run_query = mysqli_query($conn2, $query);
}

$serial_no = array();
if (mysqli_num_rows($run_query) > 0) {
    while ($raw = mysqli_fetch_assoc($run_query)) {
        $serial_no[] = $raw["sno"];
    }
}

?>

<head>
    <title><?php echo $language["Dispatch"]; ?> | GT Solution</title>

    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>

    <link rel="stylesheet" href="assets/css/dispatch.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/css/app.min.css">

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <!-- calender cdn -->
    <link href="theme/demo1/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">


</head>

<?php require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');
?>

<div id="layout-wrapper">
    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content ">
            <div class="container-flude m-0 p-1">
                <!-- Bread Cump -->
                <div class="row align-items-center pt-2 pb-2">
                    <div class="col-md-4 col-lg-9 col-sm-6">
                        <form action="dispatch.php" method="GET">
                            <div class="row align-items-end   ">
                                <div class=" col-md-7 col-lg-4 col-sm-4 pb-3">
                                    <div class="form-group ">
                                        <label for="kt_datepicker"><?php echo $language["Select"]; ?></label>
                                        <input type="date" class="form-control w-100" id="kt_daterangepicker"
                                            placeholder="Select date" name="date">
                                    </div>
                                </div>
                                <div class="col-5">
                                    <label for="" class="form-label">Select Branch</label>
                                    <select name="branch_filter" id="filter_place" class="form-select form-select mb-3"
                                        aria-label=".form-selec example">
                                        <option value="select" selected hidden disabled>Select branch name</option>
                                        <?php foreach($allbranchlist as $branch){ ;?>
                                        <option value="<?php echo $branch ;?>"><?php echo $branch ;?></option>
                                        <?php } ;?>
                                    </select>
                                </div>

                                <div class="col-md-3 col-sm-6 pb-3">
                                    <?php $todaydate = date("Y-m-d"); ?>
                                    <button type="submit"
                                        class="btn btn-success m-0  w-100 fetch_data"><?php echo $language['fetch']; ?></button>
                                    <input type="hidden" id="ddate"
                                        value="<?php echo !empty($_GET["date"]) ? $_GET["date"] : $date; ?>">
                                        <input type="hidden" id="place_filter"
                                        value="<?php echo !empty($_GET["branch_filter"]) ? $_GET["branch_filter"] : ""; ?>">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-lg-3 ">
                        <?php $Serials = implode(',', $serial_no);
                        ;
                        if ($Serials != "" || $Serials != null) { ?>
                            <form action="print_dispatch_receipt.php" method="POST" class="d-flex justify-content-end mt-3"
                                target="_blank">
                                <div class="col-sm-12">
                                    <input type="hidden" name="serials" id="serials"
                                        value="<?php echo !empty($Serials) ? $Serials : ""; ?>">
                                    <button type="submit"
                                        class="btn btn-primary custom_btn w-100"><?php echo $language['Print_dispatch']; ?></button>
                                </div>
                            </form>
                        <?php }
                        ; ?>

                    </div>
                </div>

                <div class="row mt-4 mb-5">
                    <div class="col-lg-8 col-12 col-md-8">
                        <div class="table-responsive mb-3 h-100">
                            <table id="get_dispatch_detail" class="get_dispatch_detail w-100 table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th class="p-1">
                                            <span class=""><?php echo $language['SelectAll']; ?></span>
                                            <input type="checkbox" id="checkAll" class="checkAll mr-5 ">
                                        </th>
                                        <th><?php echo $language['Rno']; ?></th>
                                        <th><?php echo $language['Item_detail']; ?></th>
                                        <th><?php echo $language['Item_qty']; ?></th>
                                        <th><?php echo $language['Place_send']; ?></th>
                                        <th><?php echo $language['Dstatus']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 pt-3   ">
                        <form action="" class="pt-5 vehicle_no ">
                            <div class="form-group pb-5 ">
                                <label for="" class="form_lab"><?php echo $language['Vno']; ?></label>
                                <input type="text" class="form-control vehicle_number" id="vehicle_number"
                                    placeholder="<?php echo $language['Vno']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="" class="form_lab"><?php echo $language["Select"]; ?></label>
                                <?php $currentDateandtime = new DateTime(); ?>
                                <input type="date" class="form-control w-100" id="kt_daterangepicker2"
                                    placeholder="Select date" name="date">
                                <input type="hidden" id="entry_date"
                                    value="<?php echo !empty($_GET["date"]) ? $_GET["date"] : date("Y-m-d"); ?>">
                            </div>
                            <div class="form-group d-flex  mt-4 mb-3 ">
                                <button type="button"
                                    class="btn btn-dispatch btn-lg  btn-md"><?php echo $language["Dispatch"]; ?></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php require_once 'layouts/main/footer.php'; ?> -->
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

<script>
    jQuery(document).ready(function () {
        var currentUrl = window.location.href;
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('date') && urlParams.has('branch_filter')) {
            var newUrl = currentUrl.split('?')[0];
            window.history.replaceState({}, document.title, newUrl);
        }
    });
</script>

</body>

</html>