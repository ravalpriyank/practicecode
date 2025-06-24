<?php
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
    <title>GT Solution</title>
    <link rel="stylesheet" href="printstyle.css">
    <style>
        table {
            page-break-after: always;
        }

        table:last-of-type {
            page-break-after: auto;
        }

        body {
            line-height: 0 !important;
            font-size: 120% !important;
            text-align: left;
        }

        .doublesize {
            font-size: 210% !important;
            text-align: center;
        }

        .bakijama {
            font-size: 120%;
            text-align: center;
            font-weight: 700;
        }

        .vigat {
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
    </style>
    <script type="text/javascript">
        // window.print();
        // setTimeout(window.close, 500);
    </script>
    <?php
    ?>
</head>
<?php


if (!isset($_POST["lrlisttoprint"])) {
    $PrintLRdatabase = "SELECT * FROM `transportz` WHERE place = '$toplace' AND branch = '$frombranch' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn desc";
    $PrintResult = mysqli_query($conn2, $PrintLRdatabase);
    while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
        $PrintLR = $AllGetedValues['lrn'];
        $PrintSender = $AllGetedValues['nameone'];
        $PrintSenderNumber = $AllGetedValues['numone'];
        $PrintReciver = $AllGetedValues['nametwo'];
        $PrintReciverNumber = $AllGetedValues['numtwo'];
        $PrintSenderGST = $AllGetedValues['gstone'];
        $PrintReciverGST = $AllGetedValues['gsttwo'];
        $PrintItemDetails = $AllGetedValues['item'];
        $PrintColorDetails = $AllGetedValues['color'];
        $PrintQTYDetails = $AllGetedValues['qty'];
        $PrintRateDetails = $AllGetedValues['rate'];
        $PrintTotalDetails = $AllGetedValues['total'];
        $PrintBookingDoneBy = $AllGetedValues['branch'];
        $PrintTypeDetails = $AllGetedValues['type'];
        $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
        $PrintRemarkDetails = $AllGetedValues['remark'];
        $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
        $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));

        $PrintBranchdatabase = "SELECT * FROM `branchlog` WHERE name = '$PrintPlaceSendDetails' LIMIT 1";
        $BranchResult = mysqli_query($conn2, $PrintBranchdatabase);
        while ($AllBranchValues = mysqli_fetch_assoc($BranchResult)) {
            $PrintBranchAddress = $AllBranchValues["address"];
            $PrintBranchPhone = $AllBranchValues["phone"];
        }
        // Finding Branch Code 
        $findingbranchcode = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE name = '$PrintBookingDoneBy'");
        while ($row = mysqli_fetch_array($findingbranchcode)) {
            $bookingbranchcode = $row["code"];
            $PrintSenderBranchNumber = $row["phone"];
            $PrintSenderBranchAddress = $row["address"];
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

        <body>
            <?php
            if(isset($final_format) && !empty($final_format))
            {
                require($final_format);
                $count++;
            }
            else if($softwarePrintStyle == "2in1") 
            {
                require('print_new_fullformat.php');
                
            } else{
                require('print_new_fullformat.php');
            }
            ?>
        </body>
        <?php
    }
} else {
    $total_receipt = !empty($_POST['lrlisttoprint']) ? count($_POST['lrlisttoprint']) : 0;
    $count = 1;
    foreach ($_POST['lrlisttoprint'] as $PrintLR) {
        if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `lrn` = '$PrintLR' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY `sno` desc LIMIT 1";
        } else {
            $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `lrn` = '$PrintLR' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY `sno` desc LIMIT 1";
        }
        $PrintResult = mysqli_query($conn2, $PrintLRdatabase);
        while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
            $PrintLR = $AllGetedValues['lrn'];
            $PrintSender = $AllGetedValues['nameone'];
            $PrintLrWithcode = $AllGetedValues['lrwithcode'];
            $PrintSenderNumber = $AllGetedValues['numone'];
            $PrintReciver = $AllGetedValues['nametwo'];
            $PrintReciverNumber = $AllGetedValues['numtwo'];
            $PrintSenderGST = $AllGetedValues['gstone'];
            $PrintReciverGST = $AllGetedValues['gsttwo'];
            $PrintItemDetails = $AllGetedValues['item'];
            $PrintColorDetails = $AllGetedValues['color'];
            $PrintQTYDetails = $AllGetedValues['qty'];
            $PrintRateDetails = $AllGetedValues['rate'];
            $PrintTotalDetails = $AllGetedValues['total'];
            $PrintBookingDoneBy = $AllGetedValues['branch'];
            $PrintTypeDetails = $AllGetedValues['type'];
            $PrintTGst = $AllGetedValues['gst'];
            $PrintPlaceSendDetails = !empty($AllGetedValues['place']) ? CleanBranchCode($AllGetedValues['place']) : "";
            $PrintRemarkDetails = $AllGetedValues['remark'];
            $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
            $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));

            $PrintBranchdatabase = "SELECT * FROM `branchlog` WHERE name = '$PrintPlaceSendDetails' LIMIT 1";
            $BranchResult = mysqli_query($conn2, $PrintBranchdatabase);
            while ($AllBranchValues = mysqli_fetch_assoc($BranchResult)) {
                $PrintBranchAddress = $AllBranchValues['address'];
                $PrintBranchPhone = $AllBranchValues['phone'];
            }
            // Finding Branch Code 
            $findingbranchcode = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE name = '$PrintBookingDoneBy'");
            while ($row = mysqli_fetch_array($findingbranchcode)) {
                $bookingbranchcode = $row['code'];
                $PrintSenderBranchNumber = $row['phone'];
                $PrintSenderBranchAddress = $row['address'];
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

            <body>
                <?php
                
                if(isset($final_format) && !empty($final_format))
                {
                    require($final_format);
                    $count++;
                }
                else if($softwarePrintStyle == "2in1") 
                {
                    require('print_new_fullformat.php');
                    
                } else{
                    require('print_new_fullformat.php');
                }
                ?>
            </body>
            <?php
        }
    }
} ?>