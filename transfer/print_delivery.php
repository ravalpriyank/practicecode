<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("connection.php");
require_once("main_const.php");
require_once("layouts/mainheader.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $frm_general_dt = !empty($_POST["FromJeneralDates"]) ? $_POST["FromJeneralDates"] : "";
    $frm_branch = !empty($_POST["FromThisBranch"]) ? $_POST["FromThisBranch"] : "";
    $Str_allplace = "All Places Combined";
    $topaid = "To Paid";
    $topay = "To Pay";
    $account = "Accounting Software";
    $foc = "Free of Charge";

    // Date Assiging 
    $sampledate = str_replace(' ', '', $frm_general_dt);

    $datearray = explode("-", $sampledate);

    $i = 0;
    foreach ($datearray as $value) {
        ${'date' . $i} = str_replace("/", "-", $value);
        $i++;
    }

    // Date for Database Filter 
    $dateone = date_create_from_format("m-d-Y", $date0)->format("Y-m-d");
    $datetwo = date_create_from_format("m-d-Y", $date1)->format("Y-m-d");

    // Date for Print Titles 
    $newdateone = date_create_from_format("Y-m-d", $dateone)->format("d-m-Y");
    $newdatetwo = date_create_from_format("Y-m-d", $datetwo)->format("d-m-Y");
    $fromplace = $frm_branch;
    $timesofgeneralhere = 0;
    $users[] = !empty($_POST["usersofthisbranch"]) ? $_POST["usersofthisbranch"] : "";

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/print_recipt.css">
    <title>GT Solution: <?php echo "General -" . $dateone; ?></title>
    <style>
        @media print {
            .non-deliver-section {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <?php if (!empty($_POST["usersofthisbranch"])) {
            foreach ($_POST["usersofthisbranch"] as $toplace) {
                if ($toplace == "All") {
                    $toplace = $Str_allplace;
                }
                ?>

                <table class="w-100 border-0">
                    <tr class="border-0">
                        <td colspan="2" class="border-0 mt-4">
                            <p style="float: left;" class="mt-4">|| સંગે માંગલ ||</p>
                        </td>
                        <td class="border-0">
                            <p style="float: right; " class="mt-4">|| શ્રી મોગલ કૃપા ||</p>
                        </td>
                    </tr>
                    <tr class="border-0">
                        <?php if ($timesofgeneralhere == 0) { ?>
                            <td width="20%" class="border-0"><img width="96px" src="<?php echo $companylogof; ?>" alt="LOGO"></td>
                        <?php } else { ?>
                            <td width="20%" class="border-0"></td>
                        <?php } ?>
                        <td width="60%" class="border-0 text-center"><br>
                            <h4 class="lh-base">
                                <?php
                                if ($timesofgeneralhere == 0) {
                                    if ($newdateone == $newdatetwo) {
                                        echo $newdateone . " નો <br>";
                                    } else {
                                        echo $newdateone . " થી " . $newdatetwo . " નો <br>";
                                    }
                                }
                                echo $fromplace . " માં " . $toplace . " નો ડીલીવરી રીપોર્ટ <br>";
                                ?><br>
                            </h4>
                        </td>

                        <?php if ($timesofgeneralhere == 0) { ?>
                            <td width="20%" class="border-0"></td>
                        <?php } else { ?>
                            <td width="20%" class="border-0"></td>
                        <?php } ?>
                    </tr>
                </table>
                <?php
                $sql_upi = "SELECT * FROM `transportz` WHERE `placefilter` = '$fromplace' AND `payment_method` = '1' AND `deliverby` = '$toplace' AND DATE(exitdate) BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
                $PrintResult = mysqli_query($conn2, $sql_upi);
              
                ?>
                <h3>UPI</h3>
                <table class="table table-bordered" cellpadding="0" cellspacing="0">
                    <thead class="thead-dark">
                        <th width="6%">રસીદ</th>
                        <?php if ($dateone != $datetwo) { ?>
                            <th width="10%">તારીખ</th>
                        <?php } ?>
                        <th width="20%">પાર્સલ લેનાર</th>
                        <th width="20%">લેનાર નો ફોન</th>
                        <th width="5%" style="font-size:80%;">સ્ટેટસ</th>
                        <th width="10%">કલેક્શન</th>
                        <th width="7%">કસર</th>
                        <th width="7%">પ્રકાર</th>
                        <th width="5%">સહી</th>
                    </thead>
                    <tbody>
                        <?php
                        $totalnumbersoflr = 0;
                        $totalkhata = 0;
                        $totaljama = 0;
                        $totalfree = 0;
                        $totalrecovery = 0;
                        $totalkasaramount = 0;
                        while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
                            $totalnumbersoflr++ ?>
                            <tr>
                                <?php
                                $SenderGST = $AllGetedValues['gstone'];
                                $ReciverGST = $AllGetedValues['gsttwo']; ?>
                                <!-- LR Number Collumn  -->
                                <td class="tablecells"><?php echo $AllGetedValues['lrn']; ?></td>
                                <!-- Date  -->
                                <?php if ($dateone != $datetwo) { ?>
                                    <td class="tablecells"><?php $printdatehere = $AllGetedValues['exitdate'];
                                    echo date_create_from_format("Y-m-d", $printdatehere)->format("d-m-Y");
                                    ?></td>
                                <?php } ?>
                                <!-- Mokalnar  -->
                                <td class="tablecells"><?php echo $AllGetedValues['receiver']; ?></td>
                                <!-- lenar  -->
                                <td class="tablecells"><?php echo $AllGetedValues['recivernumber']; ?></td>
                                <!-- Khatu free  -->
                                <td class="tablecells"><?php echo $AllGetedValues['status']; ?>
                                </td>
                                <!-- Dagina ni sankhya  -->
                                <td class="tablecells">
                                    <?php
                                    if ($AllGetedValues['type'] == $topay) {
                                        echo $AllGetedValues['collection'];
                                        $totalrecovery = $totalrecovery + $AllGetedValues['collection'];
                                    } else {
                                        echo " - ";
                                    } ?>
                                </td>
                                <!-- Total Baki  -->
                                <td class="tablecells"><?php
                                $kasarvalue = $AllGetedValues['total'] - $AllGetedValues['collection'];
                                if ($kasarvalue != $AllGetedValues['total']) {
                                    $totalkasaramount = $totalkasaramount + $kasarvalue;
                                    echo $kasarvalue;
                                } ?>
                                </td>
                                <!-- Total Jama  -->
                                <td class="tablecells"><?php
                                if ($AllGetedValues['type'] == $topay) {
                                    echo "ખાતું";
                                    $totalkhata++;
                                } elseif ($AllGetedValues['type'] == $foc) {
                                    echo "ફ્રી";
                                    $totalfree++;
                                } elseif ($AllGetedValues['type'] == $topaid) {
                                    echo "જમા";
                                    $totaljama++;
                                } else {
                                    echo "-";
                                } ?></td>
                                <td class="tablecells"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <thead class="align-middle">
                        <?php if ($dateone != $datetwo) { ?>
                            <td class="tablecells"><?php echo $totalnumbersoflr; ?></td>
                        <?php } ?>
                        <th colspan="4" class="tablecells text-end pl-3 font-bold align-middle lasttablerow">
                            <h4>Total</h4>
                        </th>
                        <th class="tablecells"><?php echo $totalrecovery; ?></th>
                        <th class="tablecells align-middle">
                            <?php echo $totalkasaramount; ?>
                        </th>
                        <th class="tablecells align-middle">
                            <h5><?php echo "જમા-" . $totaljama . "<br>ખાતા-" . $totalkhata; ?></h5>
                        </th>
                        <th class="tablecells align-middle"></th>
                    </thead>
                </table>
                <h3>Cash</h3>
                <?php
                $sql_cash = "SELECT * FROM `transportz` WHERE `placefilter` = '$fromplace' AND `payment_method` = '2' AND `deliverby` = '$toplace' AND DATE(exitdate) BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
                $PrintResultCash = mysqli_query($conn2, $sql_cash);
                ?>
                <table class="table table-bordered" cellpadding="0" cellspacing="0">
                    <thead class="thead-dark">
                        <th width="6%">રસીદ</th>
                        <?php if ($dateone != $datetwo) { ?>
                            <th width="10%">તારીખ</th>
                        <?php } ?>
                        <th width="20%">પાર્સલ લેનાર</th>
                        <th width="20%">લેનાર નો ફોન</th>
                        <th width="5%" style="font-size:80%;">સ્ટેટસ</th>
                        <th width="10%">કલેક્શન</th>
                        <th width="7%">કસર</th>
                        <th width="7%">પ્રકાર</th>
                        <th width="5%">સહી</th>
                    </thead>
                    <tbody>
                        <?php
                        $totalnumbersoflr = 0;
                        $totalkhata = 0;
                        $totaljama = 0;
                        $totalfree = 0;
                        $totalrecovery = 0;
                        $totalkasaramount = 0;
                        while ($AllGetedValues = mysqli_fetch_assoc($PrintResultCash)) {
                            $totalnumbersoflr++ ?>
                            <tr>
                                <?php
                                $SenderGST = $AllGetedValues['gstone'];
                                $ReciverGST = $AllGetedValues['gsttwo']; ?>
                                <!-- LR Number Collumn  -->
                                <td class="tablecells"><?php echo $AllGetedValues['lrn']; ?></td>
                                <!-- Date  -->
                                <?php if ($dateone != $datetwo) { ?>
                                    <td class="tablecells"><?php $printdatehere = $AllGetedValues['exitdate'];
                                    echo date_create_from_format("Y-m-d", $printdatehere)->format("d-m-Y");
                                    ?></td>
                                <?php } ?>
                                <!-- Mokalnar  -->
                                <td class="tablecells"><?php echo $AllGetedValues['receiver']; ?></td>
                                <!-- lenar  -->
                                <td class="tablecells"><?php echo $AllGetedValues['recivernumber']; ?></td>
                                <!-- Khatu free  -->
                                <td class="tablecells"><?php echo $AllGetedValues['status']; ?>
                                </td>
                                <!-- Dagina ni sankhya  -->
                                <td class="tablecells">
                                    <?php
                                    if ($AllGetedValues['type'] == $topay) {
                                        echo $AllGetedValues['collection'];
                                        $totalrecovery = $totalrecovery + $AllGetedValues['collection'];
                                    } else {
                                        echo "0";
                                    } ?>
                                </td>
                                <!-- Total Baki  -->
                                <td class="tablecells"><?php
                                $kasarvalue = $AllGetedValues['total'] - $AllGetedValues['collection'];
                                if ($kasarvalue != $AllGetedValues['total']) {
                                    $totalkasaramount = $totalkasaramount + $kasarvalue;
                                    echo $kasarvalue;
                                } else {
                                    echo "0";
                                } ?>
                                </td>
                                <!-- Total Jama  -->
                                <td class="tablecells"><?php
                                if ($AllGetedValues['type'] == $topay) {
                                    echo "ખાતું";
                                    $totalkhata++;
                                } elseif ($AllGetedValues['type'] == $foc) {
                                    echo "ફ્રી";
                                    $totalfree++;
                                } elseif ($AllGetedValues['type'] == $topaid) {
                                    echo "જમા";
                                    $totaljama++;
                                } else {
                                    echo "-";
                                } ?></td>
                                <td class="tablecells"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <thead class="align-middle">
                        <?php if ($dateone != $datetwo) { ?>
                            <td class="tablecells"><?php echo $totalnumbersoflr; ?></td>
                        <?php } ?>
                        <th colspan="4" class="tablecells text-end pl-3 font-bold align-middle lasttablerow">
                            <h4>Total</h4>
                        </th>
                        <th class="tablecells"><?php echo $totalrecovery; ?></th>
                        <th class="tablecells align-middle">
                            <?php echo $totalkasaramount; ?>
                        </th>
                        <th class="tablecells align-middle">
                            <h5><?php echo "જમા-" . $totaljama . "<br>ખાતા-" . $totalkhata; ?></h5>
                        </th>
                        <th class="tablecells align-middle"></th>
                    </thead>
                </table>
                <?php
                $timesofgeneralhere++;
            }
        } ?>
        <?php
        $sql_non = "SELECT * FROM `transportz` WHERE `placefilter` = '$fromplace' AND `payment_method` = '0' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
        $PrintResultNon = mysqli_query($conn2, $sql_non);
        ?>
        <h3 class="non-deliver-section">Non deliver</h3>
        <table class="table table-bordered" cellpadding="0" cellspacing="0">
            <thead class="thead-dark">
                <th width="6%">રસીદ</th>
                <?php if ($dateone != $datetwo) { ?>
                    <th width="10%">તારીખ</th>
                <?php } ?>
                <th width="20%">પાર્સલ મોકલનાર</th>
                <th width="20%">મોકલનાર નો ફોન</th>
                <th width="5%" style="font-size:80%;">સ્ટેટસ</th>
                <th width="10%">કલેક્શન</th>
                <th width="7%">કસર</th>
                <th width="7%">પ્રકાર</th>
                <th width="5%">સહી</th>
            </thead>

            <tbody>
                <?php
                $totalnumbersoflr = 0;
                $totalkhata = 0;
                $totaljama = 0;
                $totalfree = 0;
                $totalrecovery = 0;
                $totalkasaramount = 0;
                while ($AllGetedValues = mysqli_fetch_assoc($PrintResultNon)) {
                    $totalnumbersoflr++ ?>
                    <tr>
                        <?php
                        $SenderGST = $AllGetedValues['gstone'];
                        $ReciverGST = $AllGetedValues['gsttwo']; ?>
                        <!-- LR Number Collumn  -->
                        <td class="tablecells"><?php echo $AllGetedValues['lrn']; ?></td>
                        <!-- Date  -->
                        <?php if ($dateone != $datetwo) { ?>
                            <td class="tablecells"><?php $printdatehere = $AllGetedValues['entrydate'];
                            echo date_create_from_format("Y-m-d", $printdatehere)->format("d-m-Y");
                            ?></td>
                        <?php } ?>
                        <!-- Mokalnar  -->
                        <td class="tablecells"><?php echo $AllGetedValues['nameone']; ?></td>
                        <!-- lenar  -->
                        <td class="tablecells"><?php echo $AllGetedValues['numone']; ?></td>
                        <!-- Khatu free  -->
                        <td class="tablecells"><?php echo $AllGetedValues['status']; ?>
                        </td>
                        <!-- Dagina ni sankhya  -->
                        <td class="tablecells">
                            <?php
                            if ($AllGetedValues['type'] == $topay) {
                                echo !empty($AllGetedValues['collection']) ? $AllGetedValues['collection'] : 0;
                                $totalrecovery = $totalrecovery + $AllGetedValues['collection'];
                            } else {
                                echo "0";
                            } ?>
                        </td>
                        <!-- Total Baki  -->
                        <td class="tablecells"><?php
                        $kasarvalue = $AllGetedValues['total'] - $AllGetedValues['collection'];
                        if ($kasarvalue != $AllGetedValues['total']) {
                            $totalkasaramount = $totalkasaramount + $kasarvalue;
                            echo !empty($kasarvalue) ? $kasarvalue : 0;
                        } else {
                            echo "0";
                        } ?>
                        </td>
                        <!-- Total Jama  -->
                        <td class="tablecells"><?php
                        if ($AllGetedValues['type'] == $topay) {
                            echo "ખાતું";
                            $totalkhata++;
                        } elseif ($AllGetedValues['type'] == $foc) {
                            echo "ફ્રી";
                            $totalfree++;
                        } elseif ($AllGetedValues['type'] == $topaid) {
                            echo "જમા";
                            $totaljama++;
                        } else {
                            echo "-";
                        } ?></td>
                        <td class="tablecells"></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <thead class="align-middle">
                <?php if ($dateone != $datetwo) { ?>
                    <td class="tablecells"><?php echo $totalnumbersoflr; ?></td>
                <?php } ?>
                <th colspan="4" class="tablecells text-end pl-3 font-bold align-middle lasttablerow">
                    <h4>Total</h4>
                </th>
                <th class="tablecells"><?php echo $totalrecovery; ?></th>
                <th class="tablecells align-middle">
                    <?php echo $totalkasaramount; ?>
                </th>
                <th class="tablecells align-middle">
                    <h5><?php echo "જમા-" . $totaljama . "<br>ખાતા-" . $totalkhata; ?></h5>
                </th>
                <th class="tablecells align-middle"></th>
            </thead>
        </table>
    </div>
</body>

<script type="text/javascript">
    window.print();
</script>

</html>