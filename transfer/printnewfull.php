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
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/print_recipt.css">

    <title>I Am Kidos: <?php echo "Print -" . $PrintLR; ?></title>
    <link rel="stylesheet" href="printstyle.css">
    <?php
    ?>
    <style>
        body {
            transform: scale(0.99,
                    <?php echo $SystemYScale; ?>
                );
            margin-top:
                <?php echo $SystemTopMargin; ?>
                px;
            line-height: 30px !important;
        }

        .doublesize {
            font-size: 200% !important;
            text-align: center;
        }

        .bakijama {
            font-size: 120%;
            text-align: center;
            font-weight: 700;
        }

        .vigat {
            font-size: 140%;
        }

        .places {
            font-size: 120%;
        }

        .total {
            font-size: 140%;
            text-align: center;
        }

        .bilcharge {
            text-align: center;
        }

        .datesprint {
            font-size: 80%;
            text-align: center;
        }

        div {
            font-size: 16px !important;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET["time"])) {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrn` = '$PrintLR' AND `timestamp` = '$date' ORDER BY `sno` DESC LIMIT 1";
    } else {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `lrn` = '$PrintLR' ORDER BY `sno` DESC LIMIT 1";
    }

    $PrintResult = mysqli_query($conn2, $PrintLRdatabase);
    while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
        $PrintSender = $AllGetedValues['nameone'];
        $PrintSenderNumber = $AllGetedValues['numone'];
        $PrintReciver = $AllGetedValues['nametwo'];
        $PrintReciverNumber = $AllGetedValues['numtwo'];
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
        $PrintTypeDetails = $AllGetedValues['type'];
        $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
        $PrintRemarkDetails = $AllGetedValues['remark'];
        $isGST = $AllGetedValues["gst"];
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

    if ($isGST == "NO") {
        $lr_num = $PrintLR;
    } else {
        $lr_num = $PrintLR;
    }
  
    ?>
    <table width="100%" style="margin-top:<?php echo !empty($top_margin) ? $top_margin."px" : "65px" ;?>;transform: scaleY(<?php echo $vertical_scale ;?>);" class="table table-bordered" cellpadding="0" cellspacing="0">
        <tr>
            <td width="40%" colspan="2" class="tablecells places">
                <div>
                    બુકિંગ ઓફિસ : <?php echo $PrintBookingDoneBy; ?>
                </div>
            </td>
            <td width="40%" colspan="2" class="tablecells places">
                <div>
                    મોકલવા ની જગ્યા : <?php echo $PrintPlaceSendDetails; ?>
                </div>
            </td>
            <td width="20%" class="tablecells">
                <div>
                    <span style="text-size:70%; float:left; rotate:90deg; margin-top: 15px;">LR:</span>
                </div>
                <div class="doublesize">
                    <?php echo $lr_num; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tablecells">
                <div>
                    <?php echo "Sender Name : " . $PrintSender; ?>
                </div>
                <div>
                    <?php if ($PrintSenderNumber != "") {
                        echo "Sender Number : " . $PrintSenderNumber;
                    } ?>
                </div>
                <?php if (isset($PrintSenderGST) && !empty($PrintSenderGST)) { ?>
                    <div>
                        <?php if (isset($PrintSenderGST)) {
                            echo "GST : " . $PrintSenderGST;
                        } ?>
                    </div>
                <?php }
                ; ?>
            </td>
            <td colspan="2" class="tablecells">
                <div>
                    <?php echo "Receiver Name : " . $PrintReciver; ?>
                </div>
                <div>
                    <?php if ($PrintReciverNumber != "") {
                        echo "Receiver Number : " . $PrintReciverNumber;
                    } ?>
                </div>
                <?php if (isset($PrintReciverGST) && !empty($PrintReciverGST)) { ?>
                    <div>
                        <?php if (isset($PrintReciverGST)) {
                            echo "GST : " . $PrintReciverGST;
                        } ?>
                    </div>
                <?php }
                ; ?>
            </td>
            <td class="tablecells datesprint">
                <div>
                    <?php
                    $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                    if ($printtimeonrasid == 'on') {
                        echo "બુકિંગ સમય : <br>" . date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                    } else {
                        echo "બુકિંગ તારીખ : <br>" . date('d-m-Y', $PrintDateandTimeFormat);
                    } ?>

                </div>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="tablecells vigat">
                <div>
                    <?php
                    echo "Item Detail : ";
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
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="tablecells remark p-0">
                <div class="p-1">
                    <?php echo "માલ મેળવવા નું " . "<b>Address : </b>" . $PrintBranchAddress . "// Mo: " . $PrintBranchPhone; ?>
                </div>
                <div class="m-0 border-top border-dark p-1">

                    <?php if ($PrintRemarkDetails != "") {
                        echo "<span>Remark :</span> " . $PrintDriverNumberDetails . " " . $PrintRemarkDetails;
                    } ?>
            </td>
            </div>
            </td>
            <td rowspan="1" class="tablecells">
                <div class="bakijama">
                    <?php echo "Payment" ?>
                </div>
                <div class="total">
                    <?php
                    if ($printornot == 'on') {
                        echo $PrintTypeDetails . " : " . intval($PrintTotalDetails);
                    } else {
                        echo $PrintTypeDetails;
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <table width="100%" class="table" cellpadding="0" cellspacing="0">
    </table>
    <table width="100%" class="table" cellpadding="0" cellspacing="0">
    </table>
</body>

<script type="text/javascript">
    // window.print();
    // setTimeout(window.close, 500);
</script>