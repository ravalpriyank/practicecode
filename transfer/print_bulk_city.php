<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("main_const.php");

$sno = 1;
$get_sql = "SELECT * FROM `settingprint` WHERE `settingprint`.`sno` = '$sno'";
$run_get_sql = mysqli_query($conn2, $get_sql);
$get_data = mysqli_fetch_assoc($run_get_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $posteddate = !empty($_POST['FromJeneralDates']) ? $_POST['FromJeneralDates'] : "";
    $sampledate = !empty($_POST['FromJeneralDates']) ? str_replace(' ', '', $_POST['FromJeneralDates']) : "";
    $datearray = !empty($sampledate) ? explode("-", $sampledate) : "";

    $print = "Print";
    $i = 0;
    foreach ($datearray as $value) {
        ${'date' . $i} = str_replace("/", "-", $value);
        $i++;
    }

    // Date for Database Filter 
    $dateone = date_create_from_format("m-d-Y", $date0)->format("Y-m-d");
    $datetwo = date_create_from_format("m-d-Y", $date1)->format("Y-m-d");

    $newdateone = date_create_from_format("Y-m-d", $dateone)->format("d-m-Y");
    $newdatetwo = date_create_from_format("Y-m-d", $datetwo)->format("d-m-Y");

    // Get Post Values 
    $frombranch = !empty($_POST["FromThisBranch"]) ? CleanBranchCode($_POST["FromThisBranch"]) : "";
    $toplace = !empty($_POST["ToThisBranch"]) ? $_POST["ToThisBranch"] : "";

    $sql = "SELECT * FROM `transportz` WHERE `branch` = '$frombranch' AND `place` = '$toplace' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn ASC";
    $run_sql = mysqli_query($conn2, $sql);
    $city_data = array();

    if (mysqli_num_rows($run_sql) > 0) {
        while ($row = mysqli_fetch_assoc($run_sql)) {
            $city_data[] = $row;
        }
    }

    $total_lr = array();

    foreach ($city_data as $data) {
        $total_lr[] = $data["lrn"];
    }

    foreach ($total_lr as $lrno) {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$lrno' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY sno desc LIMIT 1";
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
                require_once('print_new_fullformat.php');
                ?>
            </body>
            <?php
        }
    }
}
?>