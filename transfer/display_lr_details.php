<?php
require_once("display_lr_logic.php");
require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');

$lrn = !empty($data["lrn"]) ? $data["lrn"] : "";
$time = !empty($data["timestamp"]) ? $data["timestamp"] : "";

$sql = "SELECT * FROM `settingprint` WHERE `sno` = 1";
$run_sql = mysqli_query($conn2, $sql);
$print_data = mysqli_fetch_assoc($run_sql);
$selectedprintformat = $formatActions[$print_data["receipt_format"]] ?? "format6_print.php";
$counter = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $language['parcel_delivery']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/parcle.css">
    <link rel="stylesheet" href="assets/css/company_setting.css">
    <script scr="assets/js/custome.js"></script>

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <title>Document</title>
</head>
<style>

</style>

<body>
    <div id="layout-wrapper">
        <?php require_once('layouts/menu/menu.php'); ?>

        <div class="container-fluid">
            <div class="main-content ">
                <div class="page-content pb-3">
                    <?php
                    if (isset($permission)) {
                        echo $permission;
                    } else {
                        if (isset($find_lr)) {
                            echo $find_lr;
                        } else {
                            ?>
                            <div class="main_title ">
                                <h4 class="text-center text-primary mb-3">Parcel Delivery</h4>
                            </div>
                            <?php if ((CleanBranchCode($place) == $userbranch && $PrintStatusDetails == "open") || ($userrollpost == "SuperAdmin" || $userrollpost == "SuperDuperAdmin")) { ?>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <form action="transport.php" method="POST" class="parcle_data p-3 rounded ">
                                            <input type="hidden" name="ThisDeliveyAdded" id="ThisDeliveyAdded">
                                            <input type="hidden" value="<?php echo !empty($lrn) ? $lrn : ""; ?>"
                                                name="DeliveryLRNum" id="DeliveryLRNum" readonly>
                                            <input type="hidden" value="<?php echo !empty($time) ? $time : ""; ?>"
                                                name="DeliveryLRTime" id="DeliveryLRTime" readonly>
                                            <div class="form-grup pt-2 pb-2">
                                                <label for="receiver_name">Reciver Name :</label>
                                                <input type="text" name="receiver_name" id="receiver_name" class="form-control">
                                            </div>
                                            <div class="form-grup pt-2 pb-2">
                                                <label for="receiver_pno">Reciver's Phone Number :</label>
                                                <input type="text" id="receiver_pno" name="receiver_pno" class="form-control">
                                            </div>
                                            <div class="form-grup pt-2 pb-2">
                                                <?php if ($payment_type == "To Paid") { ?>
                                                    <label
                                                        for="collected_money"><?php echo "Collected Money" . " - ( " . $lr_branch . " માં જમા છે )"; ?></label>
                                                    <input type="number" max="0" min="0" value="0" name="collected_money"
                                                        id="collected_money" class="form-control">
                                                <?php } else {
                                                    ; ?>
                                                    <label for="collected_money">Collected Money : </label>
                                                    <input type="number" max="<?php echo !empty($lr_total) ? $lr_total : ""; ?>" min="0"
                                                        value="<?php echo !empty($lr_total) ? $lr_total : ""; ?>" name="collected_money"
                                                        id="collected_money" class="form-control">
                                                <?php }
                                                ; ?>
                                            </div>
                                            <div class="payment mb-2 mt-2">
                                                <label for="" class="">Payment Method :- </label><br>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="upi ">
                                                        <input type="radio" class="main_radio" name="pay_opt" value="upi" id="upi"
                                                            checked><label for="" class="mb-0 ps-2">UPI</label>
                                                    </div>
                                                    <div class="cash">
                                                        <input type="radio" class="main_radio" name="pay_opt" value="cash"
                                                            id="cash"><label for="" class="m-0 ps-2">Cash</label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-grup d-flex justify-content-center pt-2 ">
                                                <button class="btn btn-success w-">Add Delivary</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php }
                            ; ?>
                                <?php if (CleanBranchCode($place) == $userbranch || $userbranchishead == "Yes" || $userrollpost == "Admin" || $userrollpost == "SuperAdmin" || $userrollpost == "SuperDuperAdmin" || $userrollpost == "Office") { ?>
                                    <div class="<?php echo $userrollpost == "Admin" ? "col-lg-12" : "col-lg-9"; ?>">
                                        <table class="table lr_table_data table-bordered">
                                            <thead>
                                                <tr class="">
                                                    <th class="h3 p-2 border-0"><span>LR Number :
                                                            <?php echo !empty($data["lrwithcode"]) ? $data["lrwithcode"] : ""; ?></span>
                                                    </th>
                                                    <th class="p-2 fixed-width font border-0">
                                                        <span>Date :
                                                            <?php echo !empty($data["timestamp"]) ? date('d-m-Y h:i A', strtotime($data['timestamp'])) : ""; ?></span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <strong class="fw-bold">Sender Details:</strong> <br><br>
                                                        Sender :-
                                                        <?php echo !empty($data["nameone"]) ? $data["nameone"] : ""; ?><br>
                                                        Sender Num :-
                                                        <?php echo !empty($data["numone"]) ? $data["numone"] : ""; ?><br>
                                                        <?php if (!empty($data["gstone"])) {
                                                            ; ?>
                                                            Sender GST :-
                                                            <?php echo !empty($data["gstone"]) ? $data["numone"] : ""; ?>
                                                        <?php }
                                                        ; ?>
                                                    </td>
                                                    <td colspan="">
                                                        <strong class="fw-bold">Receiver Details:</strong> <br><br>
                                                        Receiver :-
                                                        <?php echo !empty($data["nametwo"]) ? $data["nametwo"] : ""; ?><br>
                                                        Receiver Num :-
                                                        <?php echo !empty($data["numtwo"]) ? $data["numtwo"] : ""; ?><br>
                                                        <?php if (!empty($data["gstone"])) {
                                                            ; ?>
                                                            Receiver GST :-
                                                            <?php echo !empty($data["gsttwo"]) ? $data["gsttwo"] : ""; ?>
                                                        <?php }
                                                        ; ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong><?php echo !empty($data["place"]) ? $data["place"] : ""; ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan=""><strong>Qty :
                                                            <?php echo !empty($data["qty"]) ? $data["qty"] : ""; ?></strong></td>
                                                    <td colspan="">
                                                        <strong><?php echo !empty($data["type"]) ? $data["type"] . " : " : ""; ?><?php echo !empty($data["total"]) ? $data["total"] : ""; ?></strong>
                                                    </td>
                                                </tr
                                                <tr>
                                                    <td colspan="">
                                                        <?php
                                                        $item_qty = !empty($data["qty"]) ? $data["qty"] : "";
                                                        $item_color = !empty($data["color"]) ? $data["color"] : "";
                                                        $item_name = !empty($data["item"]) ? $data["item"] : "";
                                                        $final_item = " " . $item_qty . " " . $item_color . " " . $item_name;
                                                        ?>
                                                        <strong>Item-Detail
                                                            :</strong><?php echo !empty($final_item) ? $final_item : ""; ?>
                                                    </td>
                                                </tr>
                                                <?php if(!empty($additional)){ ;?>
                                                <tr>
                                                    <td colspan="3" class="p-0 border-0"> 
                                                        <table class="border-0">
                                                            <tr>
                                                                <?php foreach($additional as $key => $value){ $counter++;?>
                                                                <td class="border-top-0 border-bottom-0 p-2 border-end-0" width="30%"><strong><?php echo $key." : " ;?></strong><span><?php echo $value ;?></span></td>
                                                                <?php };?>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php } ;?>
                                                <tr>
                                                    <td colspan="2">
                                                        <p><strong>Address :
                                                            </strong><?php echo !empty($address) ? $address : ""; ?><strong>
                                                                //Mobile
                                                                : </strong><?php echo !empty($mobile) ? $mobile : ""; ?></p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="">
                                                        <div class="lr_main_detail">
                                                            <div class="lr_detail_title">
                                                                <h3 class="text-center m-0">LR Maker Detail</h3>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td colspan="3">
                                                        <div class="d-flex justify-content-between gap-3">
                                                            <div class="lr_main_detail w-100">
                                                                <div class="lr_detail_title">
                                                                    <?php if ($print_data["format_changed"] == "yes") { ?>
                                                                        <form action="<?php echo $selectedprintformat; ?>"
                                                                            target="_blank" method="POST" class="float-center pl-1">
                                                                            <button type="submit" class='btn btn-success w-100 p-2'
                                                                                value="<?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>"
                                                                                name="PrintLR">
                                                                                Print Receipt
                                                                            </button>
                                                                        </form>
                                                                    <?php } else { ?>
                                                                        <?php if ($softwarePrintStyle == "2in1") { ?>
                                                                            <?php if ($softwarePrintMethod == "single") { ?>
                                                                                <form action="printnewhalf.php" target="_blank" method="POST"
                                                                                    class="float-center pl-1">
                                                                                    <button type="submit" class='btn btn-success w-100 p-2'
                                                                                        value="<?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>"
                                                                                        name="PrintLR">
                                                                                        Print Receipt
                                                                                    </button>
                                                                                </form>
                                                                            <?php } ?>
                                                                            <?php if ($softwarePrintMethod == "dual") { ?>
                                                                                <form action="printnewfull.php" target="_blank" method="POST"
                                                                                    class="float-center pl-1">
                                                                                    <button type="submit" class='btn btn-success w-100 p-2'
                                                                                        value="<?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>"
                                                                                        name="PrintLR">
                                                                                        Print Receipt
                                                                                    </button>
                                                                                </form>
                                                                            <?php }
                                                                        } ?>
                                                                        <?php if ($softwarePrintStyle == "old") { ?>
                                                                            <form action="printold.php" target="_blank" method="POST"
                                                                                class="float-center pl-1">
                                                                                <button type="submit" class='btn btn-success w-100 p-2'
                                                                                    value="<?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>"
                                                                                    name="PrintLR">
                                                                                    Print Receipt
                                                                                </button>
                                                                            </form>
                                                                        <?php }
                                                                    }
                                                                    ; ?>
                                                                </div>
                                                            </div>
                                                            <?php if (!empty($creator) && $creator == $currentloggedinuser) { ?>

                                                                <div class="lr_main_detail w-50">
                                                                    <div class="lr_detail_title">
                                                                        <form action="transport.php" method="GET">
                                                                            <input type="hidden" name="lr_no" id="lr_no" class="lr_no"
                                                                                value="<?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>">
                                                                            <input type="hidden" name="time" id="time" class="time"
                                                                                value="<?php echo !empty($data["timestamp"]) ? $data["timestamp"] : ""; ?>">
                                                                            <input type="hidden" name="edit" value="true">

                                                                            <button type="submit" class="btn btn-success w-100 p-2">Edit
                                                                                Receipt</button>

                                                                        </form>
                                                                    </div>
                                                                </div>

                                                            <?php }
                                                            ; ?>
                                                        </div>


                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p class="m-0">Booked By :
                                                            <?php echo !empty($data["createby"]) ? $data["createby"] : ""; ?>
                                                        </p>
                                                        <br>
                                                        <p>Driver :
                                                            <?php echo !empty($data["drivernumber"]) ? $data["drivernumber"] : ""; ?>
                                                        </p>
                                                    </td>
                                                    <td colspan="3">
                                                        <p class="m-0">Booking Branch :
                                                            <?php echo !empty($data["branch"]) ? $data["branch"] : ""; ?>
                                                        </p>
                                                    </td>
                                                    <?php if ($PrintStatusDetails == "close") { ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="row Parcel_delivery">
                                                                <h2 class="text-white text-center">Parcel Delivery Details</h2>
                                                            </div>
                                                        </td>
                                                    <tr>
                                                        <td colspan="3" class="pt-0 pb-0 pl-0 " style="padding:9px;">
                                                            <div class="row">
                                                                <div class="col-lg-4 border p-2 ">
                                                                    <b> Reciver Name :
                                                                    </b><span><?php echo !empty($PrintRecNameis) ? $PrintRecNameis : ""; ?></span>
                                                                    <br>
                                                                    <b>Reciver's Phone Number :
                                                                    </b><span><?php echo !empty($PrintRecNumberis) ? $PrintRecNumberis : ""; ?></span>

                                                                </div>
                                                                <div class="col-lg-4 border p-2">
                                                                    <?php $kasarhereis = $lr_total - $PrintCollectonsDetails; ?>
                                                                    <b>Collected Money :
                                                                    </b><span><?php echo $PrintCollectonsDetails; ?></span><br>
                                                                    <b>Discount :
                                                                    </b><span><?php echo !empty($kasarhereis) ? $kasarhereis : 0; ?></span>
                                                                </div>
                                                                <div class="col-lg-4 border p-2">
                                                                    <b>Delivery Date :
                                                                    </b><span><?php echo !empty($PrintDeliveryDate) ? $PrintDeliveryDate : ""; ?></span><br>
                                                                    <b>Delivered By :
                                                                    </b><span><?php echo !empty($PrintDeliverydoneBy) ? $PrintDeliverydoneBy : ""; ?></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                 <?php }
                                                    ; ?>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                        <?php if($total_scan > 0){ ?>
                                        <div class="table-responsive">
                                            <table class="table mt-4 table-bordered border-dark border-1 text-center mb-5 pb-3">
                                                <thead >
                                                    <tr class="Parcel_delivery ">
                                                        <td colspan="3" class="text-center p-1">
                                                            <h3 class="text-white">Track Parcels</h3>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col" class="p-2">Branch Name</th>
                                                        <th scope="col" class="p-2">Date & Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach($sql2_data as $data){
                                                            $sbranch = !empty($data["branch"]) ? $data["branch"] : "";
                                                            $sdate = !empty($data["created_at"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $data["created_at"])->format('d-m-Y h:i:s A') : "";
                                                    ?>
                                                    <tr>
                                                        <td class=""><?php echo $sbranch ;?></td>
                                                        <td><?php echo $sdate ;?></td>
                                                    </tr>   
                                                    <?php };?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php } ;?>
                                    </div>

                                <?php } else {
                                    echo "તમને આ રસીદ જોવા ની પરમીશન નથી, હેડ ઓફીસ માં વાત કરો.";
                                }
                                ; ?>
                            </div>
                        </div>
                    </div>
                <?php }
                    }
                    ; ?>
        </div>
    </div>
    <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php require_once('layouts/main/footer.php'); ?>
    </div>
    <!-- end main content-->

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


    </div>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript">
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'આજ નું': [moment(), moment()],
                'ગઈ કાલ નું': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'છેલ્લા ૭ દિવસ નું': [moment().subtract(6, 'days'), moment()],
                'છેલ્લા ૩૦ દિવસ નું': [moment().subtract(29, 'days'), moment()],
                'ચાલુ મહિના નું': [moment().startOf('month'), moment().endOf('month')],
                'ગયા મહિના નું': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    </script>
    <script type="text/javascript">
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#printrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#printrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'આજ નું': [moment(), moment()],
                'ગઈ કાલ નું': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'છેલ્લા ૭ દિવસ નું': [moment().subtract(6, 'days'), moment()],
                'છેલ્લા ૩૦ દિવસ નું': [moment().subtract(29, 'days'), moment()],
                'ચાલુ મહિના નું': [moment().startOf('month'), moment().endOf('month')],
                'ગયા મહિના નું': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    </script>
    <script type="text/javascript">
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#deliveryrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#deliveryrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'આજ નું': [moment(), moment()],
                'ગઈ કાલ નું': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'છેલ્લા ૭ દિવસ નું': [moment().subtract(6, 'days'), moment()],
                'છેલ્લા ૩૦ દિવસ નું': [moment().subtract(29, 'days'), moment()],
                'ચાલુ મહિના નું': [moment().startOf('month'), moment().endOf('month')],
                'ગયા મહિના નું': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    </script>
</body>

</html>