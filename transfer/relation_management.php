<?php
require_once('layouts/mainheader.php');
require_once("connection.php");
require_once("main_const.php");
require_once("relation_logic.php");

$edit_id = isset($_GET["sno"]) && !empty($_GET["sno"]) ? $_GET["sno"] : "";

$sql = "SELECT * FROM `customer_relation` WHERE `sno` = '$edit_id'";
$run_sql = mysqli_query($conn2, $sql);
$data = mysqli_fetch_assoc($run_sql);

?>

<head>
    <title><?php echo $language['relation_management']; ?> | GT Solution</title>

    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <!-- calender cdn -->
    <link href="theme/demo1/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
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
                <h2 class="text-center">
                    <?php echo isset($_GET["edit"]) ? $language['edit_cust'] : $language['add_new_cust']; ?></h2>
                <!-- <div class="pt-2"> -->
                <div class="add-customer_wrapper mt-4">
                    <form action="relation_management.php" method="POST" class="add_customer" id="add_customer">
                        <div class="row py-3">
                            <div class="col-md-4 col-xl-4">
                                <div class="input-group mb-md-3 mb-sm-3 mb-xl-0">
                                    <label for="sender_name"
                                        class="input-group-text form-label"><?php echo $language['sender']; ?></label>
                                    <input type="text" class="form-control distog border_round rounded-right"
                                        id="sender_name" name="sender_name"
                                        value="<?php echo !empty($data["sender_name"]) ? $data["sender_name"] : ""; ?>"
                                        autocomplete="on">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-md-3 mb-sm-3 mb-xl-0">
                                    <label for="sender_no"
                                        class="input-group-text form-label"><?php echo $language['sendern']; ?></label>
                                    <input type="text" class="form-control distog border_round rounded-right"
                                        id="sender_no" name="sender_no"
                                        value="<?php echo !empty($data["sender_mobile"]) ? $data["sender_mobile"] : ""; ?>"
                                        autocomplete="on" minlength="10" maxlength="10"
                                        onkeypress='return event.charCode >= 46 && event.charCode <= 57'>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-md-3 mb-sm-3 mb-xl-0">
                                    <label for="Sender_gst"
                                        class="input-group-text form-label"><?php echo $language['sender'] . " GST"; ?></label>
                                    <input type="text" class="form-control distog border_round rounded-right"
                                        id="Sender_gst" name="sender_gst"
                                        value="<?php echo !empty($data["sender_gst"]) ? $data["sender_gst"] : ""; ?>"
                                        autocomplete="on">
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-4">
                                <div class="input-group mb-md-3 mb-sm-3 mb-xl-0">
                                    <label for="receiver_name"
                                        class="input-group-text form-label"><?php echo $language['reciver']; ?></label>
                                    <input type="text" class="form-control distog border_round rounded-right"
                                        id="receiver_name" name="receiver_name"
                                        value="<?php echo !empty($data["receiver_name"]) ? $data["receiver_name"] : ""; ?>"
                                        autocomplete="on">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-md-3 mb-sm-3 mb-xl-0">
                                    <label for="receiver_no"
                                        class="input-group-text form-label"><?php echo $language['recivern']; ?></label>
                                    <input type="number" class="form-control distog border_round rounded-right"
                                        id="receiver_no" name="receiver_no"
                                        value="<?php echo !empty($data["receiver_mobile"]) ? $data["receiver_mobile"] : ""; ?>"
                                        autocomplete="on" minlength="10" maxlength="10"
                                        onkeypress='return event.charCode >= 46 && event.charCode <= 57'>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-md-3 mb-sm-3 mb-xl-0">
                                    <label for="receiver_gst"
                                        class="input-group-text form-label"><?php echo $language['reciver'] . " GST"; ?></label>
                                    <input type="text" class="form-control distog border_round rounded-right"
                                        id="receiver_gst" name="receiver_gst"
                                        value="<?php echo !empty($data["receiver_gst"]) ? $data["receiver_gst"] : ""; ?>"
                                        autocomplete="on">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3 mt-3">
                                    <label for="paymentEdit"
                                        class="input-group-text form-label"><?php echo $language['payment']; ?></label>
                                    <select name="paymentEdit" id="paymentEditbakijama"
                                        class="form-select form-control jamabakientry">
                                        <option value="To Pay" <?php echo isset($data["payment_method"]) && $data["payment_method"] == "To Pay" ? "selected" : ""; ?>>To Pay</option>
                                        <option value="To Paid" <?php echo isset($data["payment_method"]) && $data["payment_method"] == "To Paid" ? "selected" : ""; ?>>To Paid</option>
                                        <option value="Free of Charge" <?php echo isset($data["payment_method"]) && $data["payment_method"] == "Free of Charge" ? "selected" : ""; ?>>Free of
                                            Charge</option>
                                        <option value="Accounting Software" <?php echo isset($data["payment_method"]) && $data["payment_method"] == "Accounting Software" ? "selected" : ""; ?>>
                                            Accounting Software</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <div class="add_btn py-2">
                            <?php if (isset($_GET["edit"])) { ?>
                                <input type="hidden" name="edit"
                                    value="<?php echo isset($_GET["edit"]) && !empty($_GET["edit"]) ? $_GET["edit"] : ""; ?>">
                                <input type="hidden" name="eid"
                                    value="<?php echo isset($_GET["sno"]) && !empty($_GET["sno"]) ? $_GET["sno"] : ""; ?>">
                            <?php }
                            ; ?>
                            <button type="submit" class="btn btn-success py-2 w-sm-100 btn_add_customer"
                                style="width:19%"><?php echo isset($_GET["edit"]) ? $language['edit_cust'] : $language['add_new_cust']; ?></button>
                        </div>
                    </form>
                </div>

                <div class="All_customer add_customer mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100" id="tbl_customer_info">
                            <thead>
                                <th><?php echo $language['Serial_Number']; ?></th>
                                <th><?php echo $language['rid']; ?></th>
                                <th><?php echo $language['sender3']; ?></th>
                                <th><?php echo $language['sendern']; ?></th>
                                <th><?php echo $language['sender3'] . " GST"; ?></th>
                                <th><?php echo $language['reciver3']; ?></th>
                                <th><?php echo $language['recivern']; ?></th>
                                <th><?php echo $language['reciver3'] . " GST"; ?></th>
                                <th><?php echo $language['Uaction']; ?></th>
                            </thead>
                            <tbody class="border-bottom-0">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- <?php require_once('layouts/main/footer.php'); ?> -->
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
