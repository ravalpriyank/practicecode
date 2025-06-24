<?php
require_once("connection.php");
require_once("layouts/mainheader.php");

if (isset($_GET["PrintLR"]) || isset($_GET["PrintLR"])) {
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

if (isset($_GET["PrintLR"]) || isset($_GET["PrintLR"])) {
    if (isset($_GET["gst"])) {
        if ($_GET["gst"] == "yes") {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrwithcode` = '$PrintLR' AND `gst` = 'YES' ORDER BY `sno` DESC LIMIT 1";
        } else {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrwithcode` = '$PrintLR' AND `gst` = 'NO' ORDER BY `sno` DESC LIMIT 1";
        }
    } else {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrn` = '$PrintLR' ORDER BY `sno` DESC LIMIT 1";
    }
} else {
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
    $PrintColorDetails = $AllGetedValues['color'];
    $isGST = $AllGetedValues['gst'];
    $PrintTotalDetails = $AllGetedValues['total'];
    $PrintBookingDoneBy = $AllGetedValues['branch'];
    $PrintTypeDetails = $AllGetedValues['type'];
    $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
    $PrintRemarkDetails = $AllGetedValues['remark'];
    $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
    $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));
    $PrintBranchCode = !empty($AllGetedValues["barcode"]) ? base64_decode($AllGetedValues["barcode"]) : "";
}

if ($PrintBranchCode !== false) {
    $outputFilePath = 'barcode.png';
    file_put_contents($outputFilePath, $PrintBranchCode);
}

// Finding Branch Code 
$findingbranchcode = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE `name` = '$PrintBookingDoneBy'");
while ($row = mysqli_fetch_array($findingbranchcode)) {
    $bookingbranchcode = $row['code'];
    $bookingbranchgstcode = $row['gst_code'];
    $PrintSenderBranchNumber = $row['phone'];
    $PrintSenderBranchAddress = $row['address'];
    $top_margin = $row['margintop'];
    $title_color = $row["titlecolor"];
    $vertical_scale = !empty($row['yscales']) ? ($row['yscales'] * 100) . "%" : (0.7 * 100) . "%";
}

if (isset($_GET["PrintLR"]) || isset($_GET["PrintLR"])) {
    $scale_ratio = $vertical_scale;
} else {
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
    $disp_type = "બાકી";
} elseif ($PrintTypeDetails == "To Paid") {
    $printornot = $get_data["jama"];
    $disp_type = "જમા";
} elseif ($PrintTypeDetails == "Accounting Software") {
    $printornot = $get_data["account"];
    $disp_type = "ખાતું";
} else {
    $printornot = 'on';
    $disp_type = "ફ્રી";
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
            font-size: 80% !important;
        }
    </style>


</head>

<body style="transform: scaleY(<?php echo $scale_ratio; ?>);line-height:1.3!important;">
    <div class="container-fluid">
        <div class="receipt" style="margin-top:<?php echo $top_margin . "px"; ?>">
            <div class="row g-4 p-0">
                <div class="two_receipt d-flex gap-4 m-0">
                    <div class="left_receipt w-50">
                    <table class="table table-bordered">
                            <tr>
                                <td class="p-1 receipt_color"
                                    style="background-color: <?php echo isset($title_color) && !empty($title_color) ? $title_color : " #5C4280"; ?> "
                                    colspan="3">
                                    <?php if ($printplacesendonrasid == "on") {
                                        ; ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">માલ
                                            મેળવાનુ સ્થળ : </strong>
                                    <?php } else {
                                        ; ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                            બ્રાન્ચ મોબાઈલ નંબર : </strong>
                                    <?php }
                                    ; ?>
                                    <span class="text-break"
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBranchPhone) ? $PrintBranchPhone : ""; ?></span>
                                </td>
                            </tr>
                            <?php if ($printplacesendonrasid == "on") {
                                ; ?>
                                <tr>
                                    <td colspan="3" class="p-1">
                                        <p class="m-0"><span class="text-break"
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBranchAddress) ? $PrintBranchAddress : ""; ?></span>
                                        </p>
                                    </td>
                                </tr>
                            <?php }
                            ; ?>
                            <tr>
                                <td colspan="3" class="p-1"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        // મો.નંબર : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span>
                                    <?php if ($printgstonrasid == "on" && !empty($PrintSenderGST)) { ?>
                                        <br><strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                            GST : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span>
                                    <?php }
                                    ; ?>
                                    <br>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        // લે.નંબર : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span>
                                    <?php if ($printgstonrasid == "on" && !empty($PrintReciverGST)) { ?>
                                        <br>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                            GST : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span>
                                    <?php }
                                    ; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="<?php echo ($printbookingtimerasid == 'off' && $printprinttimerasid == 'off') ? "3" : "2"; ?>"
                                    class=" border-bottom border-dark text-center p-1 text-center" style="width:40%">
                                    <h4 class="p-0 m-0"
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        <?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?>
                                    </h4>
                                </td>
                                <td
                                    class="border-bottom border-dark px-1 py-1 text-center<?php echo ($printbookingtimerasid == 'off' && $printprinttimerasid == 'off') ? "d-none" : ""; ?>">
                                    <?php if ($printtimeonrasid == "on") {
                                        if ($printbookingtimerasid == 'on') { ?>
                                            <strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                                તારીખ :</strong><span
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                                <?php
                                                $PrintDateandTimeFormat = strtotime($PrintDateandTime);
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
                                                echo $currentDateandtime->format('d-m-Y h:i:s A');

                                                ?>
                                            </span>
                                        <?php }
                                    }
                                    ; ?>
                                </td>
                            </tr>
                            <tr class="border-top border-dark ">
                                <td class="px-1 py-1 text-center"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">દાગીના
                                    </strong><br><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintQTYDetails) ? $PrintQTYDetails : ""; ?></span>
                                </td>
                                <td class="border-top border border-dark px-1 py-1 text-center"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo !empty($disp_type) ? $disp_type : ""; ?>
                                    </strong><br><?php if ($printornot == "on") { ?><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintTotalDetails) ? $PrintTotalDetails : ""; ?></span><?php }
                                    ; ?>
                                </td>
                                <td class="text-center p-0"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">રસીદ
                                        નંબર</strong><br>
                                    <h1 class="m-0"
                                        style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>">
                                        <?php echo isset($search_lr) ? $search_lr : $lr_num; ?>
                                    </h1>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2" class="p-1 px-1 <?php echo $total == 0 ? "border-0" : "border-1"; ?>">
                                    <div class="wrapper d-flex align-item-center gap-3 text-start">
                                        <h5 class="m-0"
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
                                                echo "<div style='text-align:text-start;'>કુલ " . $PrintQTYDetails . " દાગીના";
                                                if ($PrintQTYtwoDetails != 0) {
                                                    echo " & " . $PrintQTYtwoDetails . " Kg વજન";
                                                }
                                                echo "</div>";
                                            }
                                            ?>
                                        </h5>

                                    </div>
                                </td>
                                <td class="p-0  <?php echo $total == 0 ? "border-0" : "border-1"; ?>">
                                    <div class="fiels row m-auto">
                                        <?php
                                        $Count = 0;
                                        foreach ($data as $key => $value) {
                                            $Count++;

                                            // Check if this is the second field
                                            if ($Count == 2) {
                                                ?>
                                                <div class="col-12 px-1">
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
                                            } else {
                                                ?>
                                                <div class="col px-1">
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


                                        ?>

                                    </div>
                                </td>
                            </tr>
                            <tr class="<?php echo $printremarkrasid == "off" ? "d-none" : ""; ?>">
                                <td colspan="3" class="remark px-1 py-1"
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <span><?php echo !empty($PrintRemarkDetails) ? $PrintRemarkDetails : ""; ?></span>
                                </td>
                            </tr>
                            <tr class="p-0 "
                                style="background-color: <?php echo isset($title_color) && !empty($title_color) ? $title_color : " #5C4280"; ?> ">
                                <td colspan="<?php echo $sql1_data["print_barcode"] == "off" ? "3" : "2" ;?>" class="px-1 py-1 receipt_color border-end-0 ">
                                    <h5 class="m-0 text-white"
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        (GST બિલ વગર ના માલ ની જવાબદારી પાર્ટી ની રહેશે)</h5>
                                </td>
                                <td style="width:45%;" class="p-0 border-start-0 <?php echo $sql1_data["print_barcode"] == "off" ? "d-none" : "" ;?>">
                                    <div class="barcode d-flex justify-content-center">
                                        <img src="barcode.png" class="bg-white p-1" alt="Barcode Image">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4" class="p-1">
                                    <?php if ($printbookingonrasid == "on") { ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                            ઓફિસ : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderBranchAddress) ? $PrintSenderBranchAddress : ""; ?></span><b>
                                            / </b>
                                    <?php }
                                    ; ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        ફોન : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderBranchNumber) ? $PrintSenderBranchNumber : ""; ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="right_receipt w-50">
                    <table class="table table-bordered">
                            <tr>
                                <td class="p-1 receipt_color"
                                    style="background-color: <?php echo isset($title_color) && !empty($title_color) ? $title_color : " #5C4280"; ?> "
                                    colspan="3">
                                    <?php if ($printplacesendonrasid == "on") {
                                        ; ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">માલ
                                            મેળવાનુ સ્થળ : </strong>
                                    <?php } else {
                                        ; ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                            બ્રાન્ચ મોબાઈલ નંબર : </strong>
                                    <?php }
                                    ; ?>
                                    <span class="text-break"
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBranchPhone) ? $PrintBranchPhone : ""; ?></span>
                                </td>
                            </tr>
                            <?php if ($printplacesendonrasid == "on") {
                                ; ?>
                                <tr>
                                    <td colspan="3" class="p-1">
                                        <p class="m-0"><span class="text-break"
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBranchAddress) ? $PrintBranchAddress : ""; ?></span>
                                        </p>
                                    </td>
                                </tr>
                            <?php }
                            ; ?>
                            <tr>
                                <td colspan="3" class="p-1"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        // મો.નંબર : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span>
                                    <?php if ($printgstonrasid == "on" && !empty($PrintSenderGST)) { ?>
                                        <br><strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                            GST : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span>
                                    <?php }
                                    ; ?>
                                    <br>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        // લે.નંબર : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span>
                                    <?php if ($printgstonrasid == "on" && !empty($PrintReciverGST)) { ?>
                                        <br>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                            GST : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span>
                                    <?php }
                                    ; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="<?php echo ($printbookingtimerasid == 'off' && $printprinttimerasid == 'off') ? "3" : "2"; ?>"
                                    class=" border-bottom border-dark text-center p-1 text-center" style="width:40%">
                                    <h4 class="p-0 m-0"
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        <?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?>
                                    </h4>
                                </td>
                                <td
                                    class="border-bottom border-dark px-1 py-1 text-center<?php echo ($printbookingtimerasid == 'off' && $printprinttimerasid == 'off') ? "d-none" : ""; ?>">
                                    <?php if ($printtimeonrasid == "on") {
                                        if ($printbookingtimerasid == 'on') { ?>
                                            <strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                                તારીખ :</strong><span
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                                <?php
                                                $PrintDateandTimeFormat = strtotime($PrintDateandTime);
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
                                                echo $currentDateandtime->format('d-m-Y h:i:s A');

                                                ?>
                                            </span>
                                        <?php }
                                    }
                                    ; ?>
                                </td>
                            </tr>
                            <tr class="border-top border-dark ">
                                <td class="px-1 py-1 text-center"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">દાગીના
                                    </strong><br><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintQTYDetails) ? $PrintQTYDetails : ""; ?></span>
                                </td>
                                <td class="border-top border border-dark px-1 py-1 text-center"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo !empty($disp_type) ? $disp_type : ""; ?>
                                    </strong><br><?php if ($printornot == "on") { ?><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintTotalDetails) ? $PrintTotalDetails : ""; ?></span><?php }
                                    ; ?>
                                </td>
                                <td class="text-center p-0"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">રસીદ
                                        નંબર</strong><br>
                                    <h1 class="m-0"
                                        style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>">
                                        <?php echo isset($search_lr) ? $search_lr : $lr_num; ?>
                                    </h1>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2" class="p-1 px-1 <?php echo $total == 0 ? "border-0" : "border-1"; ?>">
                                    <div class="wrapper d-flex align-item-center gap-3 text-start">
                                        <h5 class="m-0"
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
                                                echo "<div style='text-align:text-start;'>કુલ " . $PrintQTYDetails . " દાગીના";
                                                if ($PrintQTYtwoDetails != 0) {
                                                    echo " & " . $PrintQTYtwoDetails . " Kg વજન";
                                                }
                                                echo "</div>";
                                            }
                                            ?>
                                        </h5>

                                    </div>
                                </td>
                                <td class="p-0  <?php echo $total == 0 ? "border-0" : "border-1"; ?>">
                                    <div class="fiels row m-auto">
                                        <?php
                                        $Count = 0;
                                        foreach ($data as $key => $value) {
                                            $Count++;

                                            // Check if this is the second field
                                            if ($Count == 2) {
                                                ?>
                                                <div class="col-12 px-1">
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
                                            } else {
                                                ?>
                                                <div class="col px-1">
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


                                        ?>

                                    </div>
                                </td>
                            </tr>
                            <tr class="<?php echo $printremarkrasid == "off" ? "d-none" : ""; ?>">
                                <td colspan="3" class="remark px-1 py-1"
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <span><?php echo !empty($PrintRemarkDetails) ? $PrintRemarkDetails : ""; ?></span>
                                </td>
                            </tr>
                            <tr class="p-0 "
                                style="background-color: <?php echo isset($title_color) && !empty($title_color) ? $title_color : " #5C4280"; ?> ">
                                <td colspan="<?php echo $sql1_data["print_barcode"] == "off" ? "3" : "2" ;?>" class="px-1 py-1 receipt_color border-end-0 ">
                                    <h5 class="m-0 text-white"
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        (GST બિલ વગર ના માલ ની જવાબદારી પાર્ટી ની રહેશે)</h5>
                                </td>
                                <td style="width:45%;" class="p-0 border-start-0 <?php echo $sql1_data["print_barcode"] == "off" ? "d-none" : "" ;?>">
                                    <div class="barcode d-flex justify-content-center">
                                        <img src="barcode.png" class="bg-white p-1" alt="Barcode Image">
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4" class="p-1">
                                    <?php if ($printbookingonrasid == "on") { ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                            ઓફિસ : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderBranchAddress) ? $PrintSenderBranchAddress : ""; ?></span><b>
                                            / </b>
                                    <?php }
                                    ; ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        ફોન : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderBranchNumber) ? $PrintSenderBranchNumber : ""; ?></span>
                                </td>
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