<?php
require_once("connection.php");
require_once("layouts/core/mainconstants.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $filter_date = !empty($_POST["date_range"]) ? $_POST["date_range"] : "";
    $khatedar = !empty($_POST["person"]) ? $_POST["person"] : "";
    $extra = !empty($_POST["charge"]) ? $_POST["charge"] : "";

    // Date Assiging 
    $sampledate = str_replace(' ', '', $filter_date);
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

    $extracharge = $extra;
    $khataprice = 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/print_recipt.css">
    <title>GT Solution: <?php echo "Invoice -" . $khatedar; ?></title>
</head>

<body id="printthispage">
    <div class="container-fluid">
        <table width="100%" class="border-0 mb-3">
            <tr class="border-0 top_title ">
                <td colspan="2" width="50%" class="border-0 pt-3">
                    <p class="float-start">|| સંગે માંગલ ||</p>
                </td>
                <td width="100%" class="border-0 d-flex justify-content-end pt-3">
                    <p class="float-right">|| શ્રી મોગલ કૃપા ||</p>
                </td>
            </tr>
            <tr class="border-0">
                <td width="20%" class="border-0"><img width="70px" height="70px" src="<?php echo $companylogof; ?>"
                        alt="LOGO"></td>
                <td width="45%" class="border-0 text-center">
                    <?php echo "<h4 class='m-0'>$companynamef</h4>" . $newdateone . " થી " . $newdatetwo . " સુધી નો <br>" . $khatedar . " નો હિસાબ<br>"; ?>

                </td>
                <td width="75%" class="border-0 float-end m-0 ">
                    <p class="text-end  m-0" style="font-size:16px">
                        <?php echo "<br>" . $userbranch . " - " . $usercity . "<br>";
                        echo date("F j, Y, g:i a"); ?>
                    </p>

                </td>
            </tr>
        </table>
        <?php
        $PrintGeneraldatabase = "SELECT * FROM `transportz` WHERE type = 'Accounting Software' AND nameone = '$khatedar' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn";
        $PrintResult = mysqli_query($conn2, $PrintGeneraldatabase);
        ?>

        <table width="100%" class="table table-bordered" cellpadding="0" cellspacing="0">
            <thead class="thead-dark">
                <th width="10%" class="tablecells">રસીદ</th>
                <th width="35%" class="tablecells">તારીખ</th>
                <th width="25%" class="tablecells">લેનાર</th>
                <th width="10%" class="tablecells">દાગીના</th>
                <th width="10%" class="tablecells">કુલ રૂપિયા</th>
            </thead>
            <tbody>

                <?php
                $totalnumbersoflr = 0;
                $totalrasid = 0;
                $totaldagina = 0;
                $grandtotalvalue = 0;
                while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
                    if ($AllGetedValues["status"] != "deleted") {
                        $totalnumbersoflr++; ?>
                        <tr>
                            <!-- LR Number Collumn  -->
                            <td class="tablecells"><?php echo $AllGetedValues["lrn"]; ?></td>
                            <!-- Date  -->
                            <?php if ($dateone != $datetwo) { ?>
                                <td class="tablecells"><?php $printdatehere = $AllGetedValues["entrydate"];
                                echo date_create_from_format("Y-m-d", $printdatehere)->format("d-m-Y");
                                ?></td>
                            <?php } ?>
                            <!-- Mokalnar  -->
                            <td class="tablecells"><?php echo $AllGetedValues["nametwo"]; ?></td>
                            <!-- Dagina ni sankhya  -->
                            <td class="tablecells">
                                <?php echo $AllGetedValues["qty"];
                                $totaldagina = $totaldagina + $AllGetedValues["qty"]; ?>
                            </td>
                            <!-- Total Jama  -->
                            <td class="tablecells"><?php
                            if (empty($extracharge)) {
                                $totalvalue = intval($AllGetedValues["total"] + !empty($extracharge));
                            } else {
                                $totalvalue = intval($AllGetedValues["total"] + $extracharge);
                            }
                            echo $totalvalue;
                            $grandtotalvalue = $grandtotalvalue + $totalvalue; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
            <thead class="align-middle">
                <?php if ($dateone != $datetwo) { ?>
                    <td class="tablecells"><?php echo $totalnumbersoflr; ?></td>
                <?php } ?>
                <th colspan="2" class="tablecells text-right align-middle lasttablerow"
                    style="font-size:120%; border-left-color: #ffffff; font-weight: 900; text-align:right;">Total</th>
                <th class="tablecells align-middle" style="font-size:90%; font-weight: 900;"><?php echo $totaldagina; ?>
                </th>
                <th class="tablecells align-middle" style="font-size:90%; font-weight: 900;">
                    <?php echo $grandtotalvalue; ?>
                </th>
            </thead>
        </table>
        <div id="elementH"></div>
    </div>
</body>


<script src="assets/js/html2canvas.min.js"></script>
<script src="assets/js/jspdf.min.js"></script>
<?php if (isset($_POST['PrintPDF'])) { ?>
    <script>
        var doc = new jsPDF('p', 'pt', 'letter');
        var elementHTML = document.getElementById('printthispage');
        doc.fromHTML(elementHTML);
    </script>
    <?php
} else { ?>
    <script type="text/javascript">
        <?php if (isset($_POST["print"]) && $_POST["print"] == "true") { ?>
            window.print();
        <?php } ?>
    </script>
<?php }
; ?>


</html>