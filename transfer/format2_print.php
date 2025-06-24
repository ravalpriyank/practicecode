<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

if(isset($_GET["PrintLR"]) || isset($_GET["PrintLR"])){
    if (isset($_GET["PrintLR"])) {
        $PrintLR = !empty($_GET['PrintLR']) ? $_GET['PrintLR'] : "";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
        $PrintLR = !empty($_POST['PrintLR']) ? $_POST['PrintLR'] : "";
    }
}

$currentDateandtime = new DateTime();
$sno = 1;
$get_sql = "SELECT * FROM `settingprint` WHERE `settingprint`.`sno` = '$sno'";
$run_get_sql = mysqli_query($conn2, $get_sql);
$get_data = mysqli_fetch_assoc($run_get_sql);

if(isset($_GET["PrintLR"]) || isset($_GET["PrintLR"])){
    if (isset($_GET["gst"])) {
        if ($_GET["gst"] == "yes") {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrwithcode` = '$PrintLR' AND `gst` = 'YES' ORDER BY `sno` DESC LIMIT 1";
        } else {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrwithcode` = '$PrintLR' AND `gst` = 'NO' ORDER BY `sno` DESC LIMIT 1";
        }
    } else {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrn` = '$PrintLR' ORDER BY `sno` DESC LIMIT 1";
    }
}
else
{
    $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrwithcode` = '$PrintLrWithcode'";
}
$PrintResult = mysqli_query($conn2, $PrintLRdatabase);

while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {

    $PrintSender = $AllGetedValues['nameone'];
    $PrintSenderNumber = $AllGetedValues['numone'];
    $PrintReciver = $AllGetedValues['nametwo'];
    $PrintReciverNumber = $AllGetedValues['numtwo'];
    $PrintLrwithCode = $AllGetedValues['lrwithcode'];
    $PrintSenderGST = $AllGetedValues['gstone'];
    $PrintReciverGST = $AllGetedValues['gsttwo'];
    $PrintItemDetails = explode(",", $AllGetedValues['item']);
    $PrintQTYDetails = $AllGetedValues['qty'];
    $PrintQTYarray = explode(",", $AllGetedValues['qtyarray']);
    $PrintQTYtwoDetails = $AllGetedValues['qtytwo'];
    $PrintQTYtwoarray = explode(",", $AllGetedValues['qtytwoarray']);
    $PrintRateDetails = explode(",", $AllGetedValues['rate']);
    $Printinvoiceno = $AllGetedValues['invoiceno'];
    $Printinvoiceamt = $AllGetedValues['invoiceamt'];
    $Printewaybill = $AllGetedValues['waybill'];
    $Printhamali = $AllGetedValues['hamali'];
    $isGST = $AllGetedValues['gst'];
    $PrintColorDetails = $AllGetedValues['color'];
    $PrintTotalDetails = $AllGetedValues['total'];
    $PrintBookingDoneBy = $AllGetedValues['branch'];
    $PrintTypeDetails = $AllGetedValues['type'];
    $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
    $PrintRemarkDetails = $AllGetedValues['remark'];
    $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
    $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));
}

// Finding Branch Code 
$findingbranchcode = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE `name` = '$PrintBookingDoneBy'");
while ($row = mysqli_fetch_array($findingbranchcode)) {
    $bookingbranchcode = $row['code'];
    $bookingbranchgstcode = $row['gst_code'];
    $PrintSenderBranchNumber = $row['phone'];
    $PrintSenderBranchAddress = $row['address'];
    $top_margin = $row['margintop'];
    $vertical_scale = !empty($row['yscales']) ? ($row['yscales'] * 100)."%" : (0.7 * 100)."%";
}

if(isset($_GET["PrintLR"]) || isset($_GET["PrintLR"]))
{
    $scale_ratio = $vertical_scale;
}
else
{
    $scale_ratio = "100%";
}

$PrintBranchdatabase = "SELECT * FROM `branchlog` WHERE `name` = '$PrintPlaceSendDetails' LIMIT 1";
$BranchResult = mysqli_query($conn2, $PrintBranchdatabase);

while ($AllBranchValues = mysqli_fetch_assoc($BranchResult)) {
    $PrintBranchAddress = !empty($AllBranchValues['address']) ? $AllBranchValues['address'] : "";
    $PrintBranchPhone = !empty($AllBranchValues['phone']) ? $AllBranchValues['phone'] : "";
}


// Print value or not function
if ($PrintTypeDetails == "To Pay") {
    $printornot = $get_data["baki"];
} elseif ($PrintTypeDetails == "Paid") {
    $printornot = $get_data["jama"];
} elseif ($PrintTypeDetails == "Accounting Software") {
    $printornot = $get_data["account"];
} else {
    $printornot = 'on';
}

$printtimeonrasid = $get_data["dates"];
$printbookingonrasid = $get_data["booking_office"];
$printplacesendonrasid = $get_data["place_to_send"];
$printgstonrasid = $get_data["gst_detail"];
$printremarkrasid = $get_data["remarks"];
$printbookingtimerasid = $get_data["booking_time"];
$printprinttimerasid = $get_data["print_time"];

if ($isGST == "NO") {
    $lr_num = $bookingbranchcode . "-" . $PrintLR;
} else {
    $lr_num = $bookingbranchgstcode . "-" . $PrintLR;
}

$sql1 = "SELECT * FROM `settingprint` WHERE `sno` = 1";
$run_sql1 = mysqli_query($conn2, $sql1);
$sql1_data = mysqli_fetch_assoc($run_sql1);

$search_lr = isset($_GET["time3"]) && isset($_GET["PrintLR"]) ? $_GET["PrintLR"] : "$PrintLrwithCode";
$GST = isset($_GET["time3"]) && isset($_GET["gst"]) ? strtoupper($_GET["gst"]) : $isGST;

if($GST == "YES")
{
    $additional_sql = "SELECT raf.`field_name` , raf.`field_value` FROM `runtime_additional_fields` raf JOIN `additional_fields` af ON raf.`field_name` = af.`field_name`
    WHERE af.`display_field` IN ('both', 'gst') AND raf.`field_id` = '$search_lr'";
}
else
{
    $additional_sql = "SELECT raf.`field_name` , raf.`field_value` FROM `runtime_additional_fields` raf JOIN `additional_fields` af ON raf.`field_name` = af.`field_name`
    WHERE af.`display_field` IN ('both', 'none_gst') AND raf.`field_id` = '$search_lr'";
}
$run_add_sql = mysqli_query($conn2,$additional_sql);
$data = array();

if(mysqli_num_rows($run_add_sql) > 0)
{
    while($row=mysqli_fetch_assoc($run_add_sql))
    {
        $data[$row['field_name']] = $row['field_value'];
    }
}

$total = !empty($data) ? count($data) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $language["Transport"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="./assets/css/all_receipt.css">
    <script scr="assets/js/custome.js"></script>

</head>

<body style="transform: scaleY(<?php echo $scale_ratio ;?>);line-height:1.3!important;">
    <div class="container-fluid">
        <div class="receipt" style="margin-top:<?php echo $top_margin."px" ;?>">
            <div class="table-responshive mt-0">
                <table class="w-100 <?php echo $count == $total_receipt ? "mb-5" : "" ;?> border-1 border-dark">
                    <tr>
                        <?php if ($printbookingonrasid == "on") { ?>
                            <td colspan="<?php echo $printplacesendonrasid == "off" ? "3" : "2"; ?>"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">From
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBookingDoneBy) ? $PrintBookingDoneBy : ""; ?></span>
                            </td>
                        <?php }
                        ; ?>
                        <?php if ($printplacesendonrasid == "on") { ?>
                            <td colspan="<?php echo $printbookingonrasid == "off" ? "3" : "1"; ?>"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">To
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?></span><br>
                            </td>
                        <?php }
                        ; ?>
                        <td colspan="<?php echo $printbookingonrasid == "off" && $printplacesendonrasid == "off" ? "4" : ""; ?>"
                            class="text-<?php echo $printbookingonrasid == "off" && $printplacesendonrasid == "off" ? "left" : "center"; ?> fw-bold">
                            <h4 class="m-0"
                                style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>">
                                <?php echo isset($_GET["gst"]) ? $_GET["PrintLR"] : $lr_num; ?>
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="m-0"> <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    Sender Name : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span>
                            </p>
                            <p class="m-0"> <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    Sender Number : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span>
                            </p>
                            <?php if ($printgstonrasid == "on") { ?>
                                <?php if (isset($PrintSenderGST) && !empty($PrintSenderGST)) { ?>
                                    <p class="m-0"><strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">GST
                                            : </Strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span>
                                    </p>
                                <?php }
                            }
                            ; ?>
                        </td>
                        <td colspan="<?php echo ($printbookingtimerasid == 'off' && $printprinttimerasid == "off") ? "2" : "1" ;?>">
                            <p class="m-0"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Reciver
                                    Name : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span>
                            </p>
                            <p class="m-0"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Reciver
                                    Number : </Strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span>
                            </p>
                            <?php if ($printgstonrasid == "on") { ?>
                                <?php if (isset($PrintReciverGST) && !empty($PrintReciverGST)) { ?>
                                    <p class="m-0"><strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">GST
                                            : </Strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span>
                                    </p>
                                <?php }
                            }
                            ; ?>
                        <td class="w-25 <?php echo ($printbookingtimerasid == 'off' && $printprinttimerasid == "off") ? "d-none" : "1" ;?>">
                                <?php if($printtimeonrasid == "on"){
                                    if ($printbookingtimerasid == 'on'){?>
                                <strong
                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Booking
                                time : </strong><span
                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                <?php
                                $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                                        echo date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                                ?>
                            </span><br>
                            <?php }}?>
                            <?php if($printtimeonrasid == "on"){
                                    if ($printprinttimerasid == 'on'){?>
                            <strong
                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Print
                                time : </strong><span
                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                <?php
                                        echo $currentDateandtime->format('d-m-Y H:i:s A');
                                    } 
                                ?>
                            </span>
                            <?php };?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="<?php echo $total == 0 ? "" : "3"; ?>"
                            class="p-0 <?php echo $total == 0 ? "border-end-0" : "border-end-1"; ?>">
                            <div class="wrapper <?php echo $total == 0 ? "d-none" : ""; ?>">
                                <div class="field d-flex">
                                    <?php
                                    $Count = 0; // Initialize counter for currently displayed elements
                                    
                                    // Display elements with conditional `border-end`
                                    foreach ($data as $key => $value) {
                                            $Count++;
                                                ?>
                                                <div class="p-1 <?php echo $Count == $total ? 'border-end-0' : ' border-dark border-1'; ?> w-25"
                                                    style="<?php echo $Count == $total ? "" : "border-right:1px solid" ?>">
                                                    <strong class="heading-style"
                                                        style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                        <?php echo $key . " : "; ?>
                                                    </strong>
                                                    <span class="receipt-body-style"
                                                        style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
                                                        <?php echo $value; ?>
                                                    </span>
                                                </div>
                                                <?php
                                            }
                                        
                                    ?>

                                </div>
                            </div>
                        </td>
                        <td
                            class="px-1 py-0 <?php echo $displayedElementsCount == 0 ? "text-start" : "text-center"; ?> border-0">
                            <strong class="heading-style"
                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">GrossAmt
                                : </strong><span class="receipt-body-style"
                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo $PrintTotalDetails; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="p-0 ">
                            <div class="d-flex">
                                <div class="p-1 w-50"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Item
                                        Detail:</strong>
                                    <p class="m-0"
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?> word-wrap: break-word;">
                                        <?php
                                        $i = 0;
                                        foreach ($PrintItemDetails as $itemishere) {
                                            echo $PrintQTYarray[$i];
                                            echo " - " . $itemishere;
                                            if (!empty($PrintQTYtwoarray[$i]) && $PrintQTYtwoarray[$i] != 0) {
                                                echo "(" . $PrintQTYtwoarray[$i] . "Kg)";
                                            }
                                            if ((count($PrintItemDetails) > 1) && (count($PrintItemDetails) != $i + 1)) {
                                                echo " / ";
                                            }
                                            $i++;
                                        }
                                        if ($i > 1) {
                                            echo "<div style='text-align: right;'>કુલ " . $PrintQTYDetails . " દાગીના";
                                            if ($PrintQTYtwoDetails != 0) {
                                                echo " & " . $PrintQTYtwoDetails . " Kg વજન";
                                            }
                                            echo "</div>";
                                        }
                                        ?>
                                    </p>
                                </div>
                                <?php if ($printremarkrasid == "on") { ?>
                                    <div class="w-50">
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Remark
                                            :</strong>
                                        <p class="m-0 p-0"
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                            <?php echo $PrintRemarkDetails; ?></p>
                                    </div>
                                <?php }
                                ; ?>
                            </div>
                            <div class="p-1 border-top border-dark"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Delivery
                                    at :</strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>word-wrap: break-word;">
                                    <?php echo $PrintBranchAddress . "<b> // Mo: </b>" . $PrintBranchPhone; ?>
                                </span></div>

                        </td>
                        <td class="text-center">
                            <strong
                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo !empty($PrintTypeDetails) ? $PrintTypeDetails : ""; ?></strong><br>
                            <span
                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                <?php
                                if ($printornot == 'on') {
                                    echo intval($PrintTotalDetails);
                                }
                                ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>
        window.print();
        setTimeout(window.close, 500);
    </script>
</body>

</html>