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
    $PrintLrwithCode = $AllGetedValues['lrwithcode'];
    $PrintSenderGST = $AllGetedValues['gstone'];
    $PrintReciverGST = $AllGetedValues['gsttwo'];
    $PrintItemDetails = explode(",", $AllGetedValues['item']);
    $PrintQTYDetails = $AllGetedValues['qty'];
    $PrintQTYarray = explode(",", $AllGetedValues['qtyarray']);
    $PrintQTYtwoDetails = $AllGetedValues['qtytwo'];
    $PrintQTYtwoarray = explode(",", $AllGetedValues['qtytwoarray']);
    $PrintRateDetails = explode(",", $AllGetedValues['rate']);
    $PrintColorDetails = $AllGetedValues['color'];
    $PrintTotalDetails = $AllGetedValues['total'];
    $isGST = $AllGetedValues['gst'];
    $PrintBookingDoneBy = $AllGetedValues['branch'];
    $PrintTypeDetails = $AllGetedValues['type'];
    $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
    $PrintRemarkDetails = $AllGetedValues['remark'];
    $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
    $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));
    $PrintBuiltycharge = 10;
}

// Finding Branch Code 
$findingbranchcode = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE `name` = '$PrintBookingDoneBy'");
while ($row = mysqli_fetch_array($findingbranchcode)) {
    $bookingbranchcode = $row['code'];
    $bookingbranchgstcode = $row['gst_code'];
    $PrintSenderBranchNumber = $row['phone'];
    $PrintSenderBranchAddress = $row['address'];
    $top_margin = $row['margintop'];
    $vertical_scale = !empty($row['yscales']) ? ($row['yscales'] * 100) . "%" : (0.7 * 100) . "%";
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
    $print_type = "બાકી";
} elseif ($PrintTypeDetails == "To Paid") {
    $printornot = $get_data["jama"];
    $print_type = "જમા";
} elseif ($PrintTypeDetails == "Accounting Software") {
    $printornot = $get_data["account"];
    $print_type = "ખાતું";
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
$str_count = 0;

if ($GST == "YES") {
    $additional_sql = "SELECT raf.`field_name` , raf.`field_value` FROM `runtime_additional_fields` raf JOIN `additional_fields` af ON raf.`field_name` = af.`field_name`
    WHERE af.`display_field` IN ('both', 'gst') AND raf.`field_id` = '$search_lr'";
} else {
    $additional_sql = "SELECT raf.`field_name` , raf.`field_value` FROM `runtime_additional_fields` raf JOIN `additional_fields` af ON raf.`field_name` = af.`field_name`
    WHERE af.`display_field` IN ('both', 'none_gst') AND raf.`field_id` = '$search_lr'";
}
$run_add_sql = mysqli_query($conn2, $additional_sql);
$data = array();
if (mysqli_num_rows($run_add_sql) > 0) {
    while ($row = mysqli_fetch_assoc($run_add_sql)) {
        $data[$row['field_name']] = $row['field_value'];
        if(!is_numeric($row["field_value"]))
        {
            $str_count = $str_count + 1;
        }
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
    
    <style>
        * {
            font-weight: 700 !important;
        }
        .date {
            font-size : 80% !important;
        }
    </style>


</head>

<body style="transform: scaleY(<?php echo $scale_ratio; ?>);line-height:1.3!important;">
    <div class="container-fluid">
        <div class="receipt" style="margin-top:<?php echo $top_margin . "px"; ?>">
            <div class="row  p-0">
                
                <div class="table-responshive mt-0">
                    <table class="w-100  <?php echo $count == $total_receipt ? "mb-5" : "" ;?> border-1 border-dark p-2 table-bordered ">
                        <tr>
                            <td colspan="2" class="border-0"> <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span><br>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મો.નંબર
                                    : </strong><span class="date" 
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span><br>
                                <?php if (isset($PrintSenderGST) && !empty($PrintSenderGST)) { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મો.GST
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span><br>
                                <?php }
                                ; ?>
                                <strong class="mb-1"
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><mark
                                        class="bg-dark text-white px-2 "><?php echo !empty($PrintBookingDoneBy) ? $PrintBookingDoneBy : ""; ?></mark></strong>
                            </td>
                            <td class="border-0">
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span><br>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લે.નંબર
                                    : </strong><span class="date" 
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span><br>
                                <?php if (isset($PrintReciverGST) && !empty($PrintReciverGST)) { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લે.GST
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span><br>
                                <?php }
                                ; ?>
                                <strong class="mb-1"
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><mark
                                        class="bg-dark text-white px-2 "><?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?></mark></strong>
                            </td>
                            <td class="p-0 border-none">
                                <div
                                    class="border-bottom border-dark p-1 <?php echo ($printbookingtimerasid == 'off' && $printprinttimerasid == 'off') ? "d-none" : ""; ?>">
                                    <?php if ($printtimeonrasid == "on") {
                                        if ($printbookingtimerasid == 'on') { ?>
                                            <strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ_તારીખ:</strong><span
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                                <?php
                                                $PrintDateandTimeFormat = strtotime(datetime: $PrintDateandTime);
                                                echo date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                                                ?>
                                            </span><br>
                                        <?php }
                                    } ?>
                                    <?php if ($printtimeonrasid == "on") {
                                        if ($printprinttimerasid == 'on') { ?>
                                            <strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">પ્રિન્ટ
                                                તારીખ :</strong><span
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                                <?php
                                                echo $currentDateandtime->format('d-m-Y H:i:s A');
                                                ?>
                                            </span>
                                        <?php }
                                    }
                                    ; ?>
                                </div>
                                <div class=" p-1"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">LR
                                        નંબર :</strong>
                                    <br><span
                                        style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>">
                                        <?php echo isset($_GET["gst"]) ? $_GET["PrintLR"] : $lr_num; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-top-0 border-bottom-0 ">
                            <?php if ($printremarkrasid == "on") { ?>
                                <td colspan="3" class="border-bottom-0">
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">વિગત
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
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
                            <?php }
                            ; ?>
                            <td class="p-0 border-0">
                                <table class="border-0">
                                    <tr class="border-0 text-center">
                                        <td class="border-start-0 border-bottom-1 border-end  border-dark border-top-0">
                                            <span width="20%"><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">જમા/બાકી
                                                </strong></span>
                                        </td>
                                        <td class="border-start-0 border-bottom-1 border-end  border-dark border-top-0">
                                            <span width="20%"><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">દાગીના</strong>
                                            </span>
                                        </td>
                                        <?php foreach ($data as $key => $value) {
                                            $disp_sql = "SELECT * FROM `additional_fields` WHERE `field_name` = '$key'";
                                            $run_disp_sql = mysqli_query($conn2, $disp_sql);
                                            $disp_data = mysqli_fetch_assoc($run_disp_sql);
                                            if ($GST == "YES") {
                                                if (($disp_data["display_field"] == "gst" || $disp_data["display_field"] == "both") && $disp_data["total"] == "on") {

                                                    ?>
                                                    <td class="border-start-0 border-bottom-1 border-end  border-dark border-top-0">
                                                        <span width="20%"><strong
                                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $key; ?>
                                                            </strong></span>
                                                    </td>
                                                <?php }
                                            } else {
                                                if (($disp_data["display_field"] == "none_gst" || $disp_data["display_field"] == "both") && $disp_data["total"] == "on") {
                                                    ; ?>
                                                    <td class="border-start-0 border-bottom-1 border-end  border-dark border-top-0">
                                                        <span width="20%"><strong
                                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $key; ?>
                                                            </strong></span>
                                                    </td>
                                                <?php }
                                            } ?>
                                        <?php } ?>
                                        <td class="border-start-0 border-bottom-1 border-end  border-dark border-top-0">
                                            <span><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">રકમ</strong></span>
                                        </td>
                                        <td
                                            class="border-start-0 border-bottom-1 border-end-0  border-dark border-top-0">
                                            <span><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">કુલ
                                                    રૂપિયા</strong></span>
                                        </td>
                                    </tr>
                                    <tr class="border-0 text-center">
                                        <td class="border-start-0 border-bottom-0 border-end  border-dark border-top-0">
                                            <span width="20%"><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $print_type; ?>
                                                </strong></span>
                                        </td>
                                        <td class="border-start-0 border-bottom-0 border-end  border-dark border-top-0">
                                            <span width="20%"><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $PrintQTYDetails; ?></strong>
                                            </span>
                                        </td>
                                        <?php foreach ($data as $key => $value) {
                                            $disp_sql = "SELECT * FROM `additional_fields` WHERE `field_name` = '$key'";
                                            $run_disp_sql = mysqli_query($conn2, $disp_sql);
                                            $disp_data = mysqli_fetch_assoc($run_disp_sql);
                                        
                                            if($disp_data["total"] == "on")
                                            {
                                                $extra = $extra + $value;
                                            }

                                            if ($GST == "YES") {

                                                if (($disp_data["display_field"] == "gst" || $disp_data["display_field"] == "both") && $disp_data["total"] == "on") {
                                                   
                                                    ?>
                                                    <td class="border-start-0 border-bottom-0 border-end  border-dark border-top-0">
                                                        <span width="20%"><strong
                                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $value; ?>
                                                            </strong></span>
                                                    </td>
                                                <?php }
                                            } else {

                                                if (($disp_data["display_field"] == "none_gst" || $disp_data["display_field"] == "both") && $disp_data["total"] == "on") {
                                                    
                                                    ; ?>
                                                    <td class="border-start-0 border-bottom-0 border-end  border-dark border-top-0">
                                                        <span width="20%"><strong
                                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $value; ?>
                                                            </strong></span>
                                                    </td>
                                                <?php }
                                            }
                                        }
                                        ; ?>
                                        <td class="border-start-0 border-bottom-0 border-end  border-dark border-top-0">
                                            <span><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $PrintTotalDetails - $extra; ?></strong></span>
                                        </td>
                                        <td class="border-0">
                                            <span><strong
                                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $PrintTotalDetails; ?>
                                                </strong></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                        <?php
                        if ($total == 0 || $str_count == 0) {
                            $border = "border-0";
                            $colspan = "3";
                        } else {
                            $border = "border-1 border-dark";
                            $colspan = "4";
                        }
                        ; ?>
                        <tr class="<?php echo $border; ?>">
                            <td colspan="<?php echo $colspan; ?>" class="p-0 border-top-0">
                                <div class="row m-auto align-items-center border-0">
                                    <?php
                                    // Count total displayed elements
                                    foreach ($data as $key => $value) {
                                        $disp_sql = "SELECT * FROM `additional_fields` WHERE `field_name` = '$key'";
                                        $run_disp_sql = mysqli_query($conn2, $disp_sql);
                                        $disp_data = mysqli_fetch_assoc($run_disp_sql);

                                        if ($GST == "YES") {
                                            if (($disp_data["display_field"] == "gst" || $disp_data["display_field"] == "both") && $disp_data["total"] == "off") { ?>
                                                <div class="col p-1 <?php echo $borderClass; ?> border-1">
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
                                        } else {
                                            if (($disp_data["display_field"] == "none_gst" || $disp_data["display_field"] == "both") && $disp_data["total"] == "off") { ?>
                                                <div class="col p-1 <?php echo $borderClass; ?> border-1">
                                                    <strong class="heading-style"
                                                        style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                        <?php echo $key . " : "; ?>
                                                    </strong>
                                                    <span class="receipt-body-style"
                                                        style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
                                                        <?php echo $value; ?>
                                                    </span>
                                                </div>
                                                <?php  }}} ;?>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-0">
                            <td colspan="3" class="border-0"><?php if ($printplacesendonrasid == "on") { ?><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">સરનામું
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBranchAddress) ? $PrintBranchAddress : ""; ?>
                                        // </span><?php }
                            ; ?><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">ફોન
                                    : </strong><span class="text-break"
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBranchPhone) ? $PrintBranchPhone : ""; ?></span>
                            </td>
                            <?php if ($printremarkrasid == "on") { ?>
                                <td class="">
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Remark
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintRemarkDetails) ? $PrintRemarkDetails : ""; ?></span>
                                </td>
                            <?php }
                            ; ?>
                            </td>
                        </tr>

                    </table>
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