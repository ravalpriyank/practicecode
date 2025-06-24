<?php
require_once("connection.php");
require_once("layouts/mainheader.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $frm_general_dt = !empty($_POST["FromJeneralDates"]) ? $_POST["FromJeneralDates"] : "";
    $frm_branch = !empty($_POST["FromThisBranch"]) ? $_POST["FromThisBranch"] : "";
    $to_branch = !empty($_POST["ToThisBranch"][0]) ? $_POST["ToThisBranch"][0] : "";
    $Str_allplace = "All Places Combined";
    $topaid = "To Paid";
    $topay = "To Pay";
    $account = "Accounting Software";

    // Date Assiging 
    $sampledate = str_replace(' ', '', $_POST["FromJeneralDates"]);
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
    $fromplace = !empty($frm_branch) ? CleanBranchCode($frm_branch) : "";
    $timesofgeneralhere = 0;

    if (isset($_POST['citybox'])) {
        $cityboxcheck = $_POST['citybox'];
        echo "<h1>I am Win</h1>";
    }
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
</head>
<style>

</style>

<body>
    <div class="container-fluid">


        <?php foreach ($_POST["ToThisBranch"] as $toplace) {
            if ($toplace == "All") {
                $toplace = $Str_allplace;
            }
        }

        ?>



        <table width="100%" class="border-0 table-responsive-sm ">
            <tr class="border-0">
                <td colspan="2" width="50%" class="border-0">
                    <p class="float-start pt-3">|| સંગે માંગલ ||</p>
                </td>
                <td width="100%" class="border-0 d-flex justify-content-end">
                    <p class="float-end pt-3">|| શ્રી મોગલ કૃપા ||</p>
                </td>
            </tr>
            <tr class="border-0">
                <?php if ($timesofgeneralhere == 0) { ?>
                    <td class="border-0" width="25%"><img width="96px" src="<?php echo $companylogof; ?>" alt="LOGO">
                    </td>
                <?php } else { ?>
                    <td class="border-0"></td>
                <?php } ?>
                <td class="border-0 text-center " width="50%">
                    <h3><?php echo $companynamef; ?></h3>
                    <?php
                    if ($timesofgeneralhere == 0) {
                        if ($newdateone == $newdatetwo) {
                            echo $newdateone . " નું <br>";
                        } else {
                            echo $newdateone . " થી " . $newdatetwo . " નું <br>";
                        }
                    }
                    echo $fromplace . " થી " . $toplace . " નું જનરલ <br>";

                    ?><br>
                </td>

                <?php if ($timesofgeneralhere == 0) { ?>

                    <td class="border-0" width="25%"></td>
                <?php } else { ?>
                    <td class="border-0"></td>
                <?php } ?>
            </tr>
        </table>

        <?php
        if ($toplace != $Str_allplace) {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `place` = '$toplace' AND `branch` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            } else {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `place` = '$toplace' AND `branch` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            }
        } else {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `branch` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            } else {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `branch` = '$fromplace' AND `entrydate` BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn`";
            }
        }
        $PrintResult = mysqli_query($conn2, $PrintGeneraldatabase);

        ?>

        <div class="table-responsive">
            <table width="100%" class="table table-bordered text-center" cellpadding="0" cellspacing="0">
                <thead class="thead-dark">
                    <th width="5%" class="tablecells">રસીદ</th>
                    <?php if ($dateone != $datetwo) { ?>
                        <th width="10%" class="tablecells">તારીખ</th>
                    <?php } ?>
                    <?php if ($toplace == "All Places Combined") { ?>
                        <th width="10%" class="tablecells">બ્રાંચ</th>
                    <?php } ?>
                    <th width="18%">વિગત</th>
                    <th width="10%">મોકલનાર</th>
                    <th width="10%">લેનાર</th>
                    <th width="20%" colspan="2">દાગીના</th>
                    <!-- <th width="2%">વજન(Kg)</th> -->
                    <th width="5%">ખાતું</th>
                    <th width="6%">જમા</th>
                    <th width="6%">બાકી</th>
                    <th width="7%">સહી</th>
                </thead>

                <tbody>
                    <?php
                    $totalnumbersoflr = 0;
                    $totalrasid = 0;
                    $totaldagina = 0;
                    $totalkg = 0;
                    $totalkhata = 0;
                    $totalfree = 0;
                    $totalbakiamount = 0;
                    $totaljamaamount = 0;
                    while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {

                        $totalnumbersoflr++;
                        if ($AllGetedValues['status'] != "deleted") { ?>
                            <tr>
                                <!-- LR Number Collumn  -->
                                <td class="tablecells"><?php echo $AllGetedValues['lrn']; ?></td>
                                <!-- Date  -->
                                <?php if ($dateone != $datetwo) { ?>
                                    <td class="tablecells"><?php $printdatehere = $AllGetedValues['entrydate'];
                                    echo date_create_from_format("Y-m-d", $printdatehere)->format("d-m-Y");
                                    ?></td>
                                <?php } ?>
                                <?php if ($toplace == "All Places Combined") { ?>
                                    <td><?php echo CleanBranchCode($AllGetedValues["place"]); ?></td>
                                <?php } ?>
                                <td class="tablecells">
                                    <?php $ArrayofItemDetails = explode(",", $AllGetedValues['item']);
                                    $i = 0;
                                    foreach ($ArrayofItemDetails as $key) {
                                        $i++;
                                        if ($i > 1) {
                                            echo "<hr>";
                                        }
                                        echo $key;
                                    } ?>
                                </td>
                                <!-- Mokalnar  -->
                                <td class="tablecells"><?php echo $AllGetedValues['nameone']; ?></td>
                                <!-- lenar  -->
                                <td class="tablecells"><?php echo $AllGetedValues['nametwo']; ?></td>
                                <!-- Dagina ni sankhya  -->
                                <td class="tablecells">
                                    <?php $ArrayofQtyDetails = explode(",", $AllGetedValues['qtyarray']);
                                    $i = 0;
                                    foreach ($ArrayofQtyDetails as $key) {
                                        $i++;
                                        if ($i > 1) {
                                            echo "<hr>";
                                        }
                                        echo $key;
                                    } ?>
                                    <?php $totaldagina = $totaldagina + $AllGetedValues['qty']; ?>
                                </td>
                                <!-- weight -->
                                <td class="tablecells" width="9%">

                                    <?php $ArrayofQtyTwoDetails = explode(",", $AllGetedValues['qtytwoarray']);
                                    $i = 0;
                                    foreach ($ArrayofQtyTwoDetails as $key) {
                                        $i++;
                                        if ($i > 1) {
                                            echo "<hr>";
                                        }
                                        if ($key != 0) {
                                            echo $key;
                                        } else {
                                            echo "-";
                                        }
                                    } ?>
                                    <?php $totalkg = $totalkg + floatval($AllGetedValues['qtytwo']); ?>
                                </td>
                                <!-- Khatu free  -->
                                <?php $temptotal = intval($AllGetedValues['total']); ?>
                                <td class="tablecells"><?php
                                if ($AllGetedValues['type'] == $account) {
                                    echo $temptotal;
                                    $totalkhata = $totalkhata + $temptotal;
                                } else {
                                    echo "-";
                                } ?>
                                </td>
                                <!-- Total Baki  -->
                                <td class="tablecells"><?php
                                if ($AllGetedValues['type'] == $topaid) {
                                    echo $temptotal;
                                    $totaljamaamount = $totaljamaamount + $temptotal;
                                } else {
                                    echo "-";
                                } ?>
                                </td>
                                <!-- Total Jama  -->
                                <td class="tablecells"><?php
                                if ($AllGetedValues['type'] == $topay) {
                                    echo $temptotal;
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
                                    <td class="tablecells"><del><?php echo cleanbranch($AllGetedValues['place']); ?></del></td>
                                <?php } ?>
                                <td class="tablecells" colspan="8">
                                    <hr width="100%" size="3" color="black" noshade>
                                </td>
                            </tr>
                        <?php }
                    }
                    ?>
                </tbody>
                <thead class="align-middle">
                    <?php if ($dateone != $datetwo) { ?>
                        <th></th>
                    <?php }
                    ; ?>
                    <th class="tablecells fw-bold font_bold">
                        <?php echo "Total" ?>
                    </th>
                    <th width="5%" class="tablecells">

                    </th>
                    <th colspan="3" class="tablecells float-end border-0 fw-bold font_bold"></th>
                    <th class="tablecells" colspan="2">Total</th>
                    <th class="tablecells">
                        <?php echo $totaldagina; ?>
                    </th>
                    <th class="tablecells align-middle">
                        <?php echo $totalkg . " કિલો"; ?>
                    </th>

                    <th class="tablecells align-middle">
                        <?php echo $totalkhata; ?>
                    </th>
                    <th class="tablecells align-middle">
                        <?php echo $totaljamaamount; ?>
                    </th>
                    <th class="tablecells align-middle lasttablerow"><?php echo $totalbakiamount; ?></th>
                </thead>
        </div>
        </table>
    </div>
</body>
<script type="text/javascript">
    window.print();
</script>

</html>