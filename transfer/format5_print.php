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
    $isGST = $AllGetedValues['gst'];
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
<style>
    .container
    {
        max-width: 1210px;
        margin: 0 auto;
    }

</style>

<body style="transform: scaleY(<?php echo $scale_ratio ;?>);line-height:1.3!important;">
    <div class="container p-0">
        <div class="receipt mb-5 " style="margin-top:<?php echo $top_margin."px" ;?>">
            <div class="row g-4 p-0 m-auto">
                <div class="table-responshive mt-0 p-0">
                    <table class="border-1 <?php echo $count == $total_receipt ? "mb-5" : "" ;?> border  border-dark ">
                        <tr>
                            <td colspan="2">
                                <?php if ($printbookingonrasid == "on") { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                        ઓફિસ : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintBookingDoneBy) ? $PrintBookingDoneBy : ""; ?></span><br>
                                <?php }
                                ; ?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">ફોન
                                    નંબર :
                                </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span>
                            </td>
                            <td>
                                <?php if ($printplacesendonrasid == "on") { ?>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલવા
                                        ની જગ્યા : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintPlaceSendDetails) ? $PrintPlaceSendDetails : ""; ?></span><br>
                                <?php }
                                ; ?>
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">ફોન
                                    નંબર :</strong>
                                <span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span>
                            </td>
                            <td class="text-center"><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">LR
                                    No : </strong><span
                                    style="font-size:<?php echo !empty($get_data["lr_font"]) ? $get_data["lr_font"] : "x-large"; ?>"><?php echo isset($_GET["gst"]) ? $_GET["PrintLR"] : $lr_num; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="m-0"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSender) ? $PrintSender : ""; ?></span><br>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મો.નંબર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderNumber) ? $PrintSenderNumber : ""; ?></span><br>
                                    <?php if (!empty($PrintSenderGST)) { ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">મોકલનાર
                                            GST
                                            : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintSenderGST) ? $PrintSenderGST : ""; ?></span>
                                    <?php }
                                    ; ?>
                                </p>
                            </td>
                            <td colspan="1">
                                <p class="m-0"><strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciver) ? $PrintReciver : ""; ?></span><br>
                                    <strong
                                        style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લે.નંબર
                                        : </strong><span
                                        style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverNumber) ? $PrintReciverNumber : ""; ?></span><br>
                                    <?php if (!empty($PrintReciverGST)) { ?>
                                        <strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">લેનાર
                                            GST
                                            : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintReciverGST) ? $PrintReciverGST : ""; ?></span>
                                    <?php }
                                    ; ?>
                                </p>
                            <td><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">પેમેન્ટ
                                    : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintTypeDetails) ? $PrintTypeDetails : ""; ?></span><br>
                            </td>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="" class="border-0 " style="width:25%">
                                <strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">
                                    વસ્તુ ની વિગત :
                                </strong>
                                <span class="text-break"
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : 'medium'; ?>">

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
                            <td colspan="2" class="border-0 p-0 ">
                                <table class="border-0">
                                    <tr class="border-0">
                                        <?php
                                        $Count = 0;                                        
                                        foreach ($data as $key => $value) {
                                                $Count++;
                                                    ?>
                                                    <td
                                                        class="border-end-0 border-dark border-top-0 border-bottom-0 align-items-center <?php echo $Count == $total ? '' : 'border-end border-dark'; ?>">
                                                        <strong class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                            <?php echo $key . " : "; ?>
                                                        </strong>
                                                        <span class="receipt-body-style"
                                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
                                                            <?php echo $value; ?>
                                                        </span>
                                                    </td>
                                                    <?php
                                                }
                                            
                                        ?>
                                    </tr>
                                </table>
                            </td>
                            <td colspan=""><strong
                                    style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">દાગીના
                                    ની સંખ્યા : </strong><span
                                    style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>"><?php echo !empty($PrintQTYDetails) ? $PrintQTYDetails : ""; ?></span>
                            </td>
                        </tr>
                </div>


                </tr>
                <tr>
                    <td class="  border-bottom border-dark p-0 " colspan="3">
                        <table>
                            <tr class="border-0">
                                <td class="w-50 border-start border-top-0 border-bottom-0">
                                    <strong
                                        style="font-size:<?php echo !empty($get_data['heading_font']) ? $get_data['heading_font'] : 'medium'; ?>;">
                                        માલ મેળવવા નું સ્થાન :
                                    </strong>
                                    <span class="text-break"
                                        style="font-size:<?php echo !empty($get_data['receipt_font']) ? $get_data['receipt_font'] : 'medium'; ?>;">

                                        <?php echo !empty($PrintBranchAddress) ? $PrintBranchAddress : ''; ?>
                                    </span>
                                </td>

                                <td class="w-50 border-start border-top-0 <?php echo ($printbookingtimerasid == "off" && $printprinttimerasid == "off") ? "border-bottom-0" : "border-bottom-1" ;?> border-end-0">
                                    <strong class="<?php echo $printremarkrasid == 'off' ? 'd-none' : ''; ?>"
                                        style="font-size:<?php echo !empty($get_data['heading_font']) ? $get_data['heading_font'] : 'medium'; ?>;">
                                        Remark :
                                    </strong>
                                    <span class="<?php echo $printremarkrasid == 'off' ? 'd-none' : ''; ?>" style="font-size:<?php echo !empty($get_data['receipt_font']) ? $get_data['receipt_font'] : 'medium'; ?>;
                                        word-break: break-word; 
                                        white-space: normal; 
                                        overflow-wrap: break-word;">
                                        <?php echo !empty($PrintRemarkDetails) ? $PrintRemarkDetails : ''; ?>
                                    </span>
                                </td>

                            </tr>
                            <tr class="border-0">
                                <?php 
                                if ($printtimeonrasid == "on") {
                                    if ($printbookingtimerasid == 'on') {
                                    ?>
                                <td class="border-start-0 border-bottom-0 <?php echo $printprinttimerasid == "off" ? "border-end-0" : "" ;?>">
                                    <p class="m-0 p-1"><strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">બુકિંગ
                                            સમય : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                            <?php
                                            $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                                                    echo date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                                            ?>
                                        </span></p>
                                </td>
                                <?php }} ;?>
                                <?php if ($printtimeonrasid == "on") {
                                        if ($printprinttimerasid == 'on') { ?>
                                <td class="border-start-0 border-end-0 border-bottom-0">
                                    <p class="m-0"><strong
                                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>">પ્રિન્ટ
                                            સમય : </strong><span
                                            style="font-size:<?php echo !empty($get_data["receipt_font"]) ? $get_data["receipt_font"] : "medium"; ?>">
                                            <?php
                                                echo $currentDateandtime->format('d-m-Y H:i:s A');
                                            ?>
                                        </span></p>
                                </td>
                                <?php }} ;?>
                            </tr>
                        </table>
                    </td>

                    </td>
                    <td class="text-center">
                        <strong
                            style="font-size:<?php echo !empty($get_data["heading_font"]) ? $get_data["heading_font"] : "medium"; ?>"><?php echo $printornot == "on" ? "કુલ : " : ""; ?></strong>
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
        </div>
    </div>
    <script>
        window.print();
        setTimeout(window.close, 500);
    </script>
</body>

</html>