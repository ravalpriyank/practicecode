<?php
require_once("connection.php");
require_once("main_const.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $frm_general_dt = !empty($_POST["FromJeneralDates"]) ? $_POST["FromJeneralDates"] : "";
    $frm_branch = !empty($_POST["FromThisBranch"]) ? $_POST["FromThisBranch"] : "";
    $to_branch = !empty($_POST["ToThisBranch"][0]) ? $_POST["ToThisBranch"][0] : "";
    $Str_allplace = "All Places Combined";
    $topaid = "To Paid";
    $topay = "To Pay";
    $account = "Accounting Software";
    $foc = "Free of Charge";

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
    $toplace = $Str_allplace;

    $timesofgeneralhere = 0;

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
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">


        <?php
        if (isset($toplace) == "All") {
            $toplace = $Str_allplace;
        }
        ?>

        <table width="100%" class="border-0 w-100 table-responsive-sm">
            <tr class="border-0 top_title ">
                <td colspan="2" width="50%" class="border-0 pt-3">
                    <p class="float-start">|| સંગે માંગલ ||</p>
                </td>
                <td width="100%" class="border-0 d-flex justify-content-end pt-3">
                    <p class="float-right">|| શ્રી મોગલ કૃપા ||</p>
                </td>
            </tr>
            <tr class="border-0">
                <?php if ($timesofgeneralhere == 0) { ?>
                    <td width="30%" class="border-0"><img width="96px" src="<?php echo $companylogof; ?>" alt="LOGO"></td>
                <?php } else { ?>

                <?php } ?>
                <td width="40%" class="text-center border-0 fw-bold  ">
                    <h3><?php echo $companynamef; ?></h3>
                    <?php
                    if ($timesofgeneralhere == 0) {
                        if ($newdateone == $newdatetwo) {
                            echo $newdateone . " નું <br>";
                        } else {
                            echo $newdateone . " થી " . $newdatetwo . " નું <br>";
                        }
                    }
                    echo $toplace . " થી " . $fromplace . " નું જનરલ <br>";
                    ?><br>
                </td>

                <?php if ($timesofgeneralhere == 0) { ?>

                    <td width="30%" class="border-0"></td>
                <?php } else { ?>
                    <td width="20%" class="border-0"></td>
                <?php } ?>
            </tr>
        </table>

        <?php
        if ($toplace != $Str_allplace) {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `place` = '$toplace' AND branch = '$fromplace' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn";
            } else {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `place` = '$toplace' AND branch = '$fromplace' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn";
            }
        } elseif (isset($_POST['citybox'])) {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `place` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            } else {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `place` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            }
        } else {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `place` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            } else {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `place` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            }
        }
        $PrintResult = mysqli_query($conn2, $PrintGeneraldatabase);
        ?>
        <div class="table-responsive ">

            <table width="100%" class="table text-center" cellpadding="0" cellspacing="0">
                <thead class="thead-dark">
                    <th width="6%" class="tablecells">રસીદ</th>
                    <?php if ($dateone != $datetwo) { ?>
                        <th width="10%" class="tablecells">તારીખ</th>
                    <?php } ?>
                    <?php if ($toplace == $Str_allplace) { ?>
                        <th width="10%" class="tablecells">બુકિંગ જગ્યા</th>
                    <?php } ?>
                    <th width="20%">મોકલનાર</th>
                    <th width="20%">લેનાર</th>
                    <th width="5%">ખાતું/ફ્રી</th>
                    <th width="10%" colspan="2">દાગીના</th>
                    <th width="7%">જમા</th>
                    <th width="7%">બાકી</th>
                    <th width="5%">સહી</th>
                </thead>
                <tbody>

                    <?php
                    $totalnumbersoflr = 0;
                    $totalrasid = 0;
                    $totaldagina = 0;
                    $totalkhata = 0;
                    $totalfree = 0;
                    $totalbakiamount = 0;
                    $totaljamaamount = 0;
                    while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
                        $totalnumbersoflr++;
                        if ($AllGetedValues["status"] != "deleted") { ?>
                            <tr>

                                <td class="tablecells">
                                    <?php echo !empty($AllGetedValues["lrn"]) ? $AllGetedValues["lrn"] : ""; ?>
                                </td>

                                <?php if ($dateone != $datetwo) { ?>
                                    <td class="tablecells"><?php $printdatehere = $AllGetedValues['entrydate'];
                                    echo !empty($printdatehere) ? date_create_from_format("Y-m-d", $printdatehere)->format("d-m-Y") : "";
                                    ?></td>
                                <?php } ?>
                                <?php if ($toplace == $Str_allplace) { ?>

                                    <td class="tablecells">
                                        <?php echo !empty($AllGetedValues["branch"]) ? $AllGetedValues["branch"] : ""; ?>
                                    </td>
                                <?php } ?>

                                <td class="tablecells">
                                    <?php echo !empty($AllGetedValues["nameone"]) ? $AllGetedValues["nameone"] : ""; ?>
                                </td>

                                <td class="tablecells">
                                    <?php echo !empty($AllGetedValues["nametwo"]) ? $AllGetedValues["nametwo"] : ""; ?>
                                </td>

                                <td class="tablecells"><?php
                                if ($AllGetedValues["type"] == $account) {
                                    echo !empty($AllGetedValues["type"]) ? $AllGetedValues["type"] : "";
                                    $totalkhata++;
                                } elseif ($AllGetedValues["type"] == $foc) {
                                    echo !empty($AllGetedValues["type"]) ? $AllGetedValues["type"] : "";
                                    $totalfree++;
                                } else {
                                    echo "-";
                                } ?>
                                </td>

                                <td class="tablecells " colspan="2">
                                    <?php echo !empty($AllGetedValues["qty"]) ? $AllGetedValues["qty"] : "";
                                    $totaldagina = $totaldagina + $AllGetedValues['qty']; ?>
                                </td>

                                <?php $temptotal = intval($AllGetedValues['total']) + 10; ?>

                                <td class="tablecells"><?php
                                if ($AllGetedValues['type'] == $topaid) {
                                    echo !empty($temptotal) ? $temptotal : "";
                                    $totaljamaamount = $totaljamaamount + $temptotal;
                                } else {
                                    echo "-";
                                } ?>
                                </td>
                                <!-- Total Jama  -->
                                <td class="tablecells"><?php
                                if ($AllGetedValues['type'] == $topay) {
                                    echo !empty($temptotal) ? $temptotal : 0;
                                    $totalbakiamount = $totalbakiamount + $temptotal;
                                } else {
                                    echo "-";
                                } ?></td>
                                <td class="tablecells"></td>
                            </tr>
                            <?php
                        }
                        if ($AllGetedValues['status'] == "deleted") { ?>
                            <tr>
                                <td class="tablecells"><del><?php echo $AllGetedValues['lrn']; ?></del></td>
                                <?php if ($dateone != $datetwo) { ?>
                                    <td class="tablecells"><del><?php $printdatehere = $AllGetedValues['entrydate'];
                                    echo date_create_from_format("Y-m-d", $printdatehere)->format("d-m-Y");
                                    ?></del></td>
                                <?php } ?>
                                <?php if ($toplace == $Str_allplace) { ?>
                                    <!-- Mokalva ni Jagya  -->
                                    <td class="tablecells">
                                        <del><?php echo !empty($AllGetedValues["place"]) ? $AllGetedValues["place"] : ""; ?></del>
                                    </td>
                                <?php } ?>
                                <td class="tablecells" colspan="8">
                                    <hr width="100%" size="4" color="red" noshade>
                                </td>
                            </tr>
                        <?php }
                    }
                    ?>
                </tbody>
                <thead class="align-middle">
                    <?php if ($dateone != $datetwo) { ?>
                        <td class="tablecells"><?php echo $totalnumbersoflr; ?></td>
                    <?php } ?>
                    <?php if ($toplace == $Str_allplace) { ?>
                        <th colspan="4" class=" text-right align-middle"><span class="float-end pr-4">Total</span></th>
                    <?php } else { ?>
                        <th colspan="3" class="text-right align-middle"><span class=" text-right align-middle">Total</span>
                        </th>
                    <?php } ?>
                    <th class="tablecells"><?php echo $account . "=" . $totalkhata; ?></th>
                    <th colspan="2" class="tablecells align-middle">
                        <?php echo $totaldagina; ?>
                    </th>
                    <th class="tablecells align-middle">
                        <?php echo $totaljamaamount; ?>
                    </th>
                    <th class="tablecells align-middle">
                        <?php echo $totalbakiamount; ?>
                    </th>
                    <th class="tablecells align-middle"></th>
                </thead>
            </table>

        </div>
        <?php $timesofgeneralhere++; ?>
    </div>
</body>
<script>
    window.print();
</script>

</html>