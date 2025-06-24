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
    <title>GT Solutions: <?php echo "Print -" . $PrintLR; ?></title>
    <link rel="stylesheet" href="printstyle.css">
    <?php
    ?>
</head>

<body style="margin-top:<?php echo $SystemTopMargin; ?>px;">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET["time"])) {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$PrintLR' AND `timestamp` = '$date'";
        } else {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$PrintLR'";
        }

    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$PrintLR'";
    }
    $PrintResult = mysqli_query($conn2, $PrintLRdatabase);

    while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
        $PrintNumberLRN = $AllGetedValues['lrn'];
        $PrintSender = $AllGetedValues['nameone'];
        $PrintSenderNumber = $AllGetedValues['numone'];
        $PrintReciver = $AllGetedValues['nametwo'];
        $PrintReciverNumber = $AllGetedValues['numtwo'];
        $PrintGSTOne = $AllGetedValues['gstone'];
        $PrintGSTTwo = $AllGetedValues['gsttwo'];
        $PrintItemDetails = $AllGetedValues['item'];
        $PrintColorDetails = $AllGetedValues['color'];
        $PrintQTYDetails = $AllGetedValues['qty'];
        $PrintRateDetails = $AllGetedValues['rate'];
        $PrintTotalDetails = $AllGetedValues['total'];
        $PrintBookingDoneBy = $AllGetedValues['branch'];
        $PrintTypeDetails = $AllGetedValues['type'];
        $isGST = $AllGetedValues["gst"];
        $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
        $PrintRemarkDetails = $AllGetedValues['remark'];
        $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
        $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));
    }
    // Finding Branch Code 
    $findingbranchcode = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE name = '$PrintBookingDoneBy'");
    while ($row = mysqli_fetch_array($findingbranchcode)) {
        $bookingbranchcode = $row['code'];
        $bookingbranchgstcode = $row['gst_code'];
    }

    $PrintBranchdatabase = "SELECT * FROM `branchlog` WHERE name = '$PrintPlaceSendDetails' LIMIT 1";
    $BranchResult = mysqli_query($conn2, $PrintBranchdatabase);
    while ($AllBranchValues = mysqli_fetch_assoc($BranchResult)) {
        $PrintBranchAddress = $AllBranchValues['address'];
        $PrintBranchPhone = $AllBranchValues['phone'];
        $PrintBranchCode = $AllBranchValues['code'];

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

    if ($isGST == "NO") {
        $lr_num = $bookingbranchcode . "-" . $PrintNumberLRN;
    } else {
        $lr_num = $bookingbranchgstcode . "-" . $PrintNumberLRN;
    }

    ?>
    <table width="100%" class="table" cellpadding="0" cellspacing="0">
        <tr style="font-size: 90%;">
            <td width="35%" class="tablecells">
                <?php echo "Sender Name : " . $PrintSender; ?></br>
                <?php echo "Sender Number : " . $PrintSenderNumber; ?>
                <?php if ($PrintGSTOne != null) {
                    echo "<br>GST : " . $PrintGSTOne;
                } ?></br>
                <span style="background-color:#212121; color:#fff;"><?php echo $PrintBookingDoneBy; ?></span>
            </td>
            <td width="35%" class="tablecells">
                <?php echo "Receiver Name : " . $PrintReciver; ?></br>
                <?php echo "Receiver Number : " . $PrintReciverNumber; ?>
                <?php if ($PrintGSTTwo != null) {
                    echo "<br>GST : " . $PrintGSTTwo;
                } ?></br>
                <span style="background-color:#212121; color:#fff;"><?php echo $PrintPlaceSendDetails; ?></span>
            </td>
            <td width="30%" class="tablecells">
                <?php
                $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                if ($printtimeonrasid == 'on') {
                    $final = date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                } else {
                    $final = date('d-m-Y', $PrintDateandTimeFormat);
                }
                ?>
                <span class="littlesmall" style="font-size:80%;"><?php echo "Date : " . $final; ?></span></br>
                <hr>
                <?php echo "LR Number" ?><br><span style="font-size:150%;"><?php echo $lr_num; ?></span>
            </td>
        </tr>
    </table>
    <table width="100%" class="table">
        <tr style="font-size: 70%;">
            <td style="font-size: 130%;" width="70%" rowspan="2" class="tablecells">
                <?php echo "Item Detail : " . $PrintQTYDetails . " - " . $PrintItemDetails; ?>
            </td>
            <td class="tablecells">જમા /બાકી</td>
            <td class="tablecells">દાગીના</td>
            <?php if ($PrintTypeDetails != "Accounting Software") {
                if ($PrintTypeDetails != "ફ્રી") { ?>
                    <td width="8%" class="tablecells">રકમ </td>
                    <td width="5%" class="tablecells">બિલ્ટી ચાર્જ</td>
                    <td width="8%" class="tablecells">કુલ રૂપિયા</td>
                <?php }
            } ?>
        </tr>
        <tr>
            <?php if ($printornot == 'on') { ?>
                <td class="tablecells"><?php echo $PrintTypeDetails; ?></td>
                <td class="tablecells"><?php echo $PrintQTYDetails; ?></td>
                <?php if ($PrintTypeDetails != "Accounting Software") {
                    if ($PrintTypeDetails != "ફ્રી") { ?>
                        <td class="tablecells"><?php echo $PrintTotalDetails; ?></td>
                        <td class="tablecells"><?php echo "10"; ?></td>
                        <td class="tablecells"><?php echo $PrintTotalDetails + 10; ?></td>
                    <?php }
                } ?>
            <?php } else { ?>
                <td colspan=5 class="tablecells" style="text-align:center;"><?php echo $PrintTypeDetails; ?></td>
            <?php }
            ; ?>
        </tr>
    </table>
    <table width="100%" class="table">
        <tr>
            <td width="100%" colspan="8" style="font-size: 75%;" class="tablecells">
                <?php echo "માલ મેળવવા નું " . "<b>Address : </b>" . $PrintBranchAddress . " // Mo: " . $PrintBranchPhone; ?>
                <?php if (($PrintRemarkDetails != '') || ($PrintDriverNumberDetails != '')) {
                    echo "/ રિમાર્ક :" . $PrintDriverNumberDetails . " " . $PrintRemarkDetails;
                } ?>
            </td>
        </tr>
    </table>
</body>

<script type="text/javascript">
    window.print();
    setTimeout(window.close, 500);
</script>