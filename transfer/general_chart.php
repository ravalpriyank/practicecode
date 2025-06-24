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
        if ($toplace == "All") {
            $toplace = $Str_allplace;
        }
        ?>
        <table width="100%" class="border-0">
            <tr class="border-0 ">
                <td colspan="2" width="50%" class="border-0">
                    <p class="float-start pt-3">|| સંગે માંગલ ||</p>
                </td>
                <td width="100%" class="border-0 d-flex justify-content-end">
                    <p class="pt-3">|| શ્રી મોગલ કૃપા ||</p>
                </td>
            </tr>
            <tr class="border-0">
                <?php if ($timesofgeneralhere == 0) { ?>
                    <td width="20%" class="border-0"><img width="96px" src="<?php echo $companylogof; ?>" alt="LOGO"></td>
                <?php } else { ?>
                    <td width="20%" class="border-0"></td>
                <?php } ?>
                <td width="60%" class="border-0 text-center fw-bold custom_fonts"><br>
                    <?php
                    if ($timesofgeneralhere == 0) {
                        if ($newdateone == $newdatetwo) {
                            echo $newdateone . " નું <br>";
                        } else {
                            echo $newdateone . " થી " . $newdatetwo . " નું <br>";
                        }
                    }
                    echo $toplace . " થી " . $fromplace . " નું ડિલિવરી ચાર્ટ <br>";
                    ?><br>
                </td>

                <?php if ($timesofgeneralhere == 0) { ?>
                    <td width="40%" class="border-0"></td>
                <?php } else { ?>
                    <td width="30%" class="border-0"></td>
                <?php } ?>
            </tr>
        </table>
        <?php
        if ($toplace != $Str_allplace) {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `place` = '$toplace' AND `branch` = '$fromplace' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn";
            } else {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `place` = '$toplace' AND `branch` = '$fromplace' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn";
            }
        } else {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND `place` = '$fromplace' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn";
            } else {
                $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND `place` = '$fromplace' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn";
            }
        }
        $PrintResult = mysqli_query($conn2, $PrintGeneraldatabase);

        ?>

        <table width="100%" class="table table-bordered" cellpadding="0" cellspacing="0">
            <thead class="thead-dark">
                <th width="8%">રસીદ</th>
                <th width="5%" colspan="1">દાગીના</th>
                <th width="6%">જમા</th>
                <th width="6%">બાકી</th>
                <th width="20%">તારીખ અને સમય</th>
                <th width="45%">લેનાર નું નામ & નંબર</th>
                <th width="10%">સહી</th>
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
                            <!-- LR Number Collumn  -->
                            <td class="tablecells"><?php echo $AllGetedValues["lrn"]; ?></td>
                            <!-- Dagina ni sankhya  -->
                            <td class="tablecells">
                                <?php echo $AllGetedValues["qty"];
                                $totaldagina = $totaldagina + $AllGetedValues["qty"]; ?>
                            </td>
                            <!-- Total Baki  -->

                            <?php $temptotal = intval($AllGetedValues["total"]); ?>
                            <td class="tablecells"><?php
                            if ($AllGetedValues["type"] == $topaid) {
                                echo $temptotal;
                                $totaljamaamount = $totaljamaamount + $temptotal;
                            } else {
                                echo "-";
                            } ?>
                            </td>
                            <!-- Total Jama  -->
                            <td class="tablecells"><?php
                            if ($AllGetedValues["type"] == $topay) {
                                echo $temptotal;
                                $totalbakiamount = $totalbakiamount + $temptotal;
                            } else {
                                echo "-";
                            } ?></td>
                            <td class="tablecells"></td>
                            <td class="tablecells"></td>
                            <td class="tablecells"></td>
                        </tr>
                        <?php
                    }
                    if ($AllGetedValues["status"] == "deleted") { ?>
                        <tr>
                            <td class="tablecells"><del><?php echo $AllGetedValues["lrn"]; ?></del></td>
                            <td class="tablecells" colspan="8">
                                <hr class="delete_hr" width="100%" size="0" noshade>
                            </td>
                        </tr>
                    <?php }
                }
                ?>
            </tbody>
            <tfoot class="align-middle">
                <th class="tablecells text-right align-middle lasttablerow">Total</th>
                <th colspan="1" class="tablecells align-middle"><?php echo $totaldagina; ?></th>
                <th class="tablecells align-middle"><?php echo $totaljamaamount; ?></th>
                <th class="tablecells align-middle"><?php echo $totalbakiamount; ?></th>
                <th class="tablecells align-middle lasttablerow"></th>
                <th></th>
            </tfoot>
        </table>
        <?php $timesofgeneralhere++; ?>
</body>

</div>

<script>
    window.print();
</script>

</html>