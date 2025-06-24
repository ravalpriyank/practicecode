<?php
require_once("layouts/mainheader.php");
require_once("layouts/footer/transportb.php");
require_once("connection.php");

if(isset($_GET["PrintLR"]) || isset($_GET["PrintLR"]))
{
    if (isset($_GET["PrintLR"])) {
        $PrintLR = !empty($_GET['PrintLR']) ? $_GET['PrintLR'] : "";
    }
    
    if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $PrintLR = !empty($_POST['PrintLR']) ? $_POST['PrintLR'] : "";
    }
}


$currentDateandtime = new DateTime();
$sno = 1;
$get_sql = "SELECT * FROM `settingprint` WHERE `settingprint`.`sno` = '$sno'";
$run_get_sql = mysqli_query($conn2, $get_sql);
$get_data = mysqli_fetch_assoc($run_get_sql);

if(isset($_GET["PrintLR"]) || isset($_POST["PrintLR"])){
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
    $PrintBookingDoneBy = $AllGetedValues['branch'];
    $isGST = $AllGetedValues['gst'];
    $PrintTypeDetails = $AllGetedValues['type'];
    $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
    $PrintRemarkDetails = $AllGetedValues['remark'];
    $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
    $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));

}

$search_lr = isset($_GET["time3"]) && isset($_GET["PrintLR"]) ? $_GET["PrintLR"] : $PrintLrwithCode;
$GST = isset($_GET["time3"]) && isset($_GET["gst"]) ? strtoupper($_GET["gst"]) : $isGST;

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
            <form action="#" method="POST">
                <input type="hidden" name="receipt_format" value="format1">
                <div class="table-responshive mt-0">
                    <table class="w-100 <?php echo $count == $total_receipt ? "mb-5" : "" ;?> border-1 border-dark p-1 ">
                        <tr>
                            <td colspan="2"><?php if ($printbookingonrasid == "on") { ?><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                        ઓફિસ : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBookingDoneBy) ? $PrintBookingDoneBy : ""; ?></span><br><?php } ?><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">ફોન
                                    નંબર : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderBranchNumber) ? $PrintSenderBranchNumber : ""; ?></span>
                            </td>
                            <td><?php if ($printbookingonrasid == "on") { ?><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલવા
                                        ની જગ્યા : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?></span><br><?php } ?><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    ફોન નંબર : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBranchPhone) ? $PrintBranchPhone : ""; ?></span>
                            </td>
                            <td class="text-center fw-bold">
                                <h2 class="m-0"
                                    style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>">
                                    <?php echo isset($_GET["gst"]) ? $_GET["PrintLR"] : $lr_num; ?>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="m-0"> <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                        મોકલનાર : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span>
                                </p>
                                <p class="m-0"><Strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મો.નંબર
                                        : </Strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span>
                                </p>
                                <?php if ($printbookingonrasid == "on") { ?>
                                    <?php if (isset($PrintSenderGST) && !empty($PrintSenderGST)) { ?>
                                        <p class="m-0"><Strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">GST
                                                : </Strong><span
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span>
                                        </p>
                                    <?php }
                                } ?>
                            </td>
                            <td colspan="1">
                                <p class="m-0"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span>
                                </p>
                                <p class="m-0"><Strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લે.નંબર
                                        : </Strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span>
                                </p>
                                <?php if ($printbookingonrasid == "on") { ?>
                                    <?php if (isset($PrintReciverGST) && !empty($PrintReciverGST)) { ?>
                                        <p class="m-0">
                                            <Strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">GST
                                                : </Strong><span
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span>
                                        </p>
                                    <?php }
                                }
                                ; ?>
                            <td class="text-center">
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">પેમેન્ટ
                                    :</strong>
                                <span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintTypeDetails) ? $PrintTypeDetails : ""; ?></span><br>
                            </td>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">વિગત
                                    :</strong>
                                <span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    $i = 0;
                                    foreach ($PrintItemDetails as $itemishere) {
                                        echo $PrintQTYarray[$i];
                                        echo "-" . $itemishere;
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
                        </tr>
                        <tr>
                            <td colspan="3" class="p-0">
                                <table class="border-0">
                                    <tr class="border-0">
                                        <td class="p-1 border-0"
                                            style="<?php echo $printremarkrasid == "off" ? "border-bottom:1px solid #000;" : ""; ?>">
                                            <strong
                                                style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">માલ
                                                મેળવવા નું સરનામું : </strong><span class="text-break"
                                                style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo $PrintBranchAddress . "<b> // Mo: </b>" . $PrintBranchPhone; ?></span>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom-0 border-end-0 border-start-0">
                                        <td class="p-0 border-0" colspan="3">
                                            <table class="border-0">
                                                <tr class="border-0">
                                                    <td 
                                                        class="border-top-0 border-bottom-0 border-start-0 border-end-0 p-0">
                                                        <table class="border-0">
                                                            <tr class="border-0">
                                                                <?php if ($printremarkrasid == "on") { ?>
                                                                  
                                                                    <td 
                                                                        class="remark border-start-0 <?php echo $total > 0 ? "border-end-1" : "border-end-0"; ?> border-top-0 border-bottom-0">
                                                                        <strong
                                                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">Remark
                                                                            : </strong>
                                                                        <span class="text-break"
                                                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintRemarkDetails) ? $PrintRemarkDetails : ""; ?></span><?php } ?>
                                                                  </td>

                                                                <?php

                                                                $Count = 0; 
                                                                
                                                                // Display elements with dynamic border-end logic
                                                                foreach ($data as $key => $value) {
                                                                    $Count++;
                                                                    ?>
                                                                            <td 
                                                                                class="<?php echo $printremarkrasid == "on" ? "border-start" : ""; ?> border-top-0 border-bottom-0 px-2 <?php echo $Count == $total ? "border-end-0" : ""; ?>">
                                                                                <span>
                                                                                    <strong
                                                                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                                                                        <?php echo $key . " : "; ?>
                                                                                    </strong>
                                                                                    <span
                                                                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                                                                        <?php echo $value; ?>
                                                                                    </span>
                                                                                </span>
                                                                            </td>
                                                                            <?php } ?>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom-0 border-end-0 border-start-0">
                                        <?php if ($printtimeonrasid == "on") {
                                            if ($printbookingtimerasid == 'on') { ?>
                                                <td class="border-start-0 border-bottom-0 w-50 <?php echo $printprinttimerasid == "off" ? "border-end-0" : "border-end-1" ;?>">
                                                    <p class="m-0"><strong
                                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ સમય :</strong>
                                                        <span
                                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                                            <?php

                                                            echo $currentDateandtime->format('d-m-Y H:i:s A');


                                                            ?>
                                                        </span>
                                                    </p>

                                                </td>
                                            <?php }
                                        } ?>
                                        <?php if ($printtimeonrasid == "on") {
                                            if ($printprinttimerasid == 'on') { ?>
                                                <td class="border-0">
                                                    <p class="m-0"><strong
                                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">પ્રિન્ટ
                                                            સમય :</strong>
                                                        <span
                                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                                            <?php

                                                            echo $currentDateandtime->format('d-m-Y H:i:s A');


                                                            ?>
                                                        </span>
                                                    </p>

                                                </td>
                                            <?php }
                                        } ?>

                                    </tr>
                                </table>


                            </td>
                            <td class="text-center">
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $printornot == 'on' ? "કુલ : " : ""; ?>
                                </strong>
                                <span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                    <?php
                                    if ($printornot == 'on') {
                                        echo intval($PrintTotalDetails);
                                    } else {
                                        echo "<b>" . $PrintTypeDetails . "</b>";
                                    }
                                    ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>

</body>

</html>

<script type="text/javascript">
    // window.print();
    // setTimeout(window.close, 500);
</script>