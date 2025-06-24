<?php
require_once("connection.php");
require_once("layouts/mainheader.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $PrintLR = !empty($_GET['PrintLR']) ? $_GET['PrintLR'] : "";
    $time = !empty($_GET["time3"]) ? date_create($_GET["time3"]) : "";
    $date = !empty($time) ? date_format($time, "Y-m-d H:i:s") : "";
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $PrintLR = $_POST['PrintLR'];
}

$currentDateandtime = new DateTime();
$sno = 1;
$get_sql = "SELECT * FROM `settingprint` WHERE `settingprint`.`sno` = '$sno'";
$run_get_sql = mysqli_query($conn2, $get_sql);
$get_data = mysqli_fetch_assoc($run_get_sql);

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="shortcut icon" href="assets\favicon.ico" type="image/x-icon">
    <title>GT Solution: <?php echo "Print -" . $PrintLR; ?></title>
    <link rel="stylesheet" href="printstyle.css">
    <?php
    ?>
</head>

<?php

if (isset($_GET["time"])) {
    $PrintLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$PrintLR' AND `timestamp` = '$date' LIMIT 1";
} else {
    $PrintLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$PrintLR' LIMIT 1";
}

$PrintResult = mysqli_query($conn2, $PrintLRdatabase);
while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
    $PrintSender = $AllGetedValues['nameone'];
    $PrintSenderNumber = $AllGetedValues['numone'];
    $PrintReciver = $AllGetedValues['nametwo'];
    $PrintReciverNumber = $AllGetedValues['numtwo'];
    $PrintItemDetails = $AllGetedValues['item'];
    $PrintColorDetails = $AllGetedValues['color'];
    $PrintQTYDetails = $AllGetedValues['qty'];
    $PrintRateDetails = $AllGetedValues['rate'];
    $PrintTotalDetails = $AllGetedValues['total'];
    $PrintTypeDetails = $AllGetedValues['type'];
    $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
    $PrintRemarkDetails = $AllGetedValues['remark'];
    $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
    $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));
}

$PrintBranchdatabase = "SELECT * FROM `branchlog` WHERE name = '$PrintPlaceSendDetails' LIMIT 1";
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

?>
<table width="100%" style="font-size:90%;" class="table table-xl mb-0" cellpadding="0" cellspacing="0">
    <tr>
        <td rowspan="6" width="27%" class="nulltable"></td>
        <td width="46%" class="tablecells tabletop partiestable" colspan="6">
            <?php echo "Sender Name : " . $PrintSender; ?>
            <?php if ($PrintSenderNumber != "") {
                echo " / " . "Sender Number : " . $PrintSenderNumber;
            } ?></br>
            <?php echo "Receiver Name : " . $PrintReciver; ?>
            <?php if ($PrintReciverNumber != "") {
                echo " / " . "Receiver Number : " . $PrintReciverNumber;
            } ?></br>
        </td>
        <td rowspan="6" width="27%"></td>
    </tr>
    <tr>
        <td class="tablecells MainBox morebig" colspan="2">
            <?php echo $PrintPlaceSendDetails; ?>
        </td>
        <td colspan="4" rowspan="3" class="MainBox tablecells">
            <?php
            $PrintDateandTimeFormat = strtotime($PrintDateandTime);
            if ($printtimeonrasid == 'on') {
                $final = date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
            } else {
                $final = date('d-m-Y', $PrintDateandTimeFormat);
            }
            ?>
            <span class="littlesmall"><?php echo "Date : " . $final; ?></span></br>
            <hr>
            <?php echo "LR Number" ?><br><span style="font-size:250%;"><?php echo $PrintLR; ?></span>
        </td>
    </tr>
    <tr>
        <td class="tablecells MainBox" rowspan="2">
            <?php echo "Qty" . "<br>" . $PrintQTYDetails; ?>
        </td>
        <td class="tablecells MainBox" rowspan="2">
            <?php if ($printornot == 'on') { ?>
                <?php echo $PrintTypeDetails . "<br>" . $PrintTotalDetails; ?>
            <?php } else { ?>
                <?php echo $PrintTypeDetails; ?>
            <?php } ?>
        </td>
    </tr>
    <tr class="DoNotTouchThisClass"></tr>
    <tr>
        <td class="tablecells tabletop" colspan="6">
            <?php if ($PrintRemarkDetails != "") {
                echo "Item Detail : " . $PrintColorDetails . " " . $PrintItemDetails . " ( " . $PrintRemarkDetails . " ) ";
            } else {
                echo "Item Detail : " . $PrintQTYDetails . " - " . $PrintItemDetails;
            } ?>
        </td>
    </tr>
    <tr>
        <td class="tablecells tabletop" colspan="6">
            <?php
            echo "માલ મેળવવા નું " . "<b>Address : </b>" . $PrintBranchAddress . " ";
            if ($PrintDriverNumberDetails != "") {
                echo " , " . "Driver Name" . " : " . $PrintDriverNumberDetails;
            } else {
                echo "// Mo: " . $PrintBranchPhone;
            }
            ?>
        </td>
    </tr>
</table>

</body>

<script type="text/javascript">
    window.print();
    setTimeout(window.close, 500);
</script>