<?php
require_once("connection.php");
require_once("layouts/mainheader.php");

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
    $PrintSenderGST = $AllGetedValues['gstone'];
    $PrintReciverGST = $AllGetedValues['gsttwo'];
    $PrintLrwithCode = $AllGetedValues['lrwithcode'];
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
    $PrintColorDetails = $AllGetedValues['color'];
    $PrintTotalDetails = $AllGetedValues['total'];
    $PrintBookingDoneBy = $AllGetedValues['branch'];
    $isGST = $AllGetedValues['gst'];
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
    $PrintBranchAddress = $AllBranchValues['address'];
    $PrintBranchPhone = $AllBranchValues['phone'];
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
            <div class="two_receipt d-flex gap-3 mt-0">
                <div class="left_receipt w-50 m-0">
                <table class="table <?php echo $count == $total_receipt ? "mb-5" : "mb-0" ;?> table-bordered">
                        <tr>
                            <td class="p-1" colspan="3"><?php if ($printbookingonrasid == "on") { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                        ઓફિસ : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBookingDoneBy) ? $PrintBookingDoneBy : ""; ?></span><b>
                                        /</b>
                                <?php }
                            ; ?><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    ફોન :
                                </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderBranchNumber) ? $PrintSenderBranchNumber : ""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p-1"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    / મોકલનાર ફોન નંબર : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span><br>
                                <?php if (isset($PrintSenderGST) && !empty($PrintSenderGST)) { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        મોકલનાર GST : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo isset($PrintSenderGST) && !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span><br>
                                <?php }
                                ; ?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    / લેનાર ફોન નંબર : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span><br>
                                <?php if (isset($PrintReciverGST) && !empty($PrintReciverGST)) {
                                    ; ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        લેનાર GST : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span>
                                <?php }
                                ; ?>
                            </td>
                        <tr>
                            <?php if ($printplacesendonrasid == "on") { ?>
                                <td colspan="<?php echo ($printbookingtimerasid == "off" && $printprinttimerasid == "off") ? "3" : "2" ;?>" class="border-bottom border-dark text-center p-1">
                                    <div>
                                        <h4 class="p-0 m-0"><strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?></strong>
                                        </h4>
                                    </div>
                                </td>
                            <?php } ?>
                            <td colspan="<?php echo $printplacesendonrasid == "off" ? "3" : 0; ?>"
                                class="border-bottom border-dark p-0 m-0 <?php echo ($printbookingtimerasid == "off" && $printprinttimerasid == "off") ? "d-none" : "" ;?>">
                                <?php if ($printtimeonrasid == 'on') {
                                        if ($printbookingtimerasid == "on") {?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                    તારીખ : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                                            echo date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                                    
                                    ?>
                                </span><br>
                                <?php }} ;?>
                                <?php if ($printtimeonrasid == "on") {
                                        if ($printprinttimerasid == 'on') { ?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">પ્રિન્ટ
                                    તારીખ : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                            echo $currentDateandtime->format('d-m-Y H:i:s A');
                                        

                                    ?>
                                </span>
                                <?php }} ;?>
                            </td>
                        </tr>
                        <tr class=" border-top border-dark ">
                            <td><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">દાગીના
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    echo !empty($PrintQTYDetails) ? $PrintQTYDetails : "0";
                                    ?>
                                </span></td>
                            <td class="border-top border border-dark"><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    if ($printornot == 'on') {
                                        echo "<strong>$PrintTypeDetails</strong>" . " : " . intval($PrintTotalDetails);
                                    } else {
                                        echo "<strong>" . $PrintTypeDetails . "</strong>";
                                    }
                                    ?>
                                </span></td>
                            <td rowspan="" class="text-center"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">રસીદ
                                    નંબર : </strong>
                                <span
                                    style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>"><?php echo !empty($lr_num) ? $lr_num : ""; ?></span>
                            </td>
                        </tr>
                        <?php if ($total != 0) { ?>
                            <tr>
                                <td colspan="3" class="p-0">
                                    <div class="row m-auto">
                                        <?php
                                        $Count = 0; 
                                        foreach ($data as $key => $value) {
                                            $Count++;
                                            $disp_sql = "SELECT * FROM `additional_fields` WHERE `field_name` = '$key'";
                                            $run_disp_sql = mysqli_query($conn2, $disp_sql);
                                            $disp_data = mysqli_fetch_assoc($run_disp_sql);

                                           
                                                    ?>
                                                    <div
                                                        class="p-1 <?php echo $Count == $total ? 'w-50' : 'w-25 border-end border-dark border-1'; ?>">
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
                                            }
                                        
                                        ; ?>
                                    </div>
                                </td>
                            </tr>
                        <tr>
                            <td>
                                <span lass="receipt-body-style"
                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
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
                                </span>
                            </td>

                            <?php if ($printremarkrasid == "on") { ?>
                                <td colspan="3" class="p-1"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Remark
                                        : </strong><span class="text-break"
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                        <?php echo !empty($PrintRemarkDetails) ? $PrintRemarkDetails : ""; ?>
                                    </span>
                                </td>
                            <?php }
                            ; ?>

                        </tr>
                    </table>
                </div>
                <div class="right_receipt w-50">
                    <table class="table table-bordered">
                        <tr>
                            <td class="p-1" colspan="3"><?php if ($printbookingonrasid == "on") { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                        ઓફિસ : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBookingDoneBy) ? $PrintBookingDoneBy : ""; ?></span><b>
                                        /</b>
                                <?php }
                            ; ?><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    ફોન :
                                </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderBranchNumber) ? $PrintSenderBranchNumber : ""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p-1"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    / મોકલનાર ફોન નંબર : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span><br>
                                <?php if (isset($PrintSenderGST) && !empty($PrintSenderGST)) { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        મોકલનાર GST : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo isset($PrintSenderGST) && !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span><br>
                                <?php }
                                ; ?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    / લેનાર ફોન નંબર : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span><br>
                                <?php if (isset($PrintReciverGST) && !empty($PrintReciverGST)) {
                                    ; ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        લેનાર GST : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span>
                                <?php }
                                ; ?>
                            </td>
                        <tr>
                            <?php if ($printplacesendonrasid == "on") { ?>
                                <td colspan="<?php echo ($printbookingtimerasid == "off" && $printprinttimerasid == "off") ? "3" : "2" ;?>" class="border-bottom border-dark text-center p-1">
                                    <div>
                                        <h4 class="p-0 m-0"><strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?></strong>
                                        </h4>
                                    </div>
                                </td>
                            <?php } ?>
                            <td colspan="<?php echo $printplacesendonrasid == "off" ? "3" : 0; ?>"
                                class="border-bottom border-dark p-0 m-0 <?php echo ($printbookingtimerasid == "off" && $printprinttimerasid == "off") ? "d-none" : "" ;?>">
                                <?php if ($printtimeonrasid == 'on') {
                                        if ($printbookingtimerasid == "on") {?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                    તારીખ : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                                            echo date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                                    
                                    ?>
                                </span><br>
                                <?php }} ;?>
                                <?php if ($printtimeonrasid == "on") {
                                        if ($printprinttimerasid == 'on') { ?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">પ્રિન્ટ
                                    તારીખ : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                            echo $currentDateandtime->format('d-m-Y H:i:s A');
                                        

                                    ?>
                                </span>
                                <?php }} ;?>
                            </td>
                        </tr>
                        <tr class=" border-top border-dark ">
                            <td><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">દાગીના
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    echo !empty($PrintQTYDetails) ? $PrintQTYDetails : "0";
                                    ?>
                                </span></td>
                            <td class="border-top border border-dark"><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    if ($printornot == 'on') {
                                        echo "<strong>$PrintTypeDetails</strong>" . " : " . intval($PrintTotalDetails);
                                    } else {
                                        echo "<strong>" . $PrintTypeDetails . "</strong>";
                                    }
                                    ?>
                                </span></td>
                            <td rowspan="" class="text-center"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">રસીદ
                                    નંબર : </strong>
                                <span
                                    style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>"><?php echo !empty($lr_num) ? $lr_num : ""; ?></span>
                            </td>
                        </tr>
                        <?php if ($total != 0) { ?>
                            <tr>
                                <td colspan="3" class="p-0">
                                    <div class="row m-auto">
                                        <?php
                                        $Count = 0; 
                                        foreach ($data as $key => $value) {
                                            $Count++;
                                                    ?>
                                                    <div
                                                        class="p-1 <?php echo $Count == $total ? 'w-50' : 'w-25 border-end border-dark border-1'; ?>">
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
                                            }
                                        ; ?>
                                    </div>
                                </td>
                            </tr>
                        <tr>
                            <td>
                                <span lass="receipt-body-style"
                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
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
                                </span>
                            </td>

                            <?php if ($printremarkrasid == "on") { ?>
                                <td colspan="3" class="p-1"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Remark
                                        : </strong><span class="text-break"
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                        <?php echo !empty($PrintRemarkDetails) ? $PrintRemarkDetails : ""; ?>
                                    </span>
                                </td>
                            <?php }
                            ; ?>

                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script>
        window.print();
        setTimeout(window.close, 500);
    </script>
</body>

</html>