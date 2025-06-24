<?php
require_once("connection.php");
require_once("layouts/mainheader.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $posteddate = !empty($_POST['FromJeneralDates']) ? $_POST['FromJeneralDates'] : "";
    $sampledate = str_replace(' ', '', $_POST['FromJeneralDates']);
    $datearray = explode("-", $sampledate);

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

    $fromcity = !empty($_POST["FromThisCity"]) ? $_POST["FromThisCity"] : "";
    $tocity = !empty($_POST["ToThisCity"]) ? $_POST["ToThisCity"] : "";

    if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND DATE(`entrydate`) BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn` asc";
    } else {
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND DATE(`entrydate`) BETWEEN '$dateone' AND '$datetwo' ORDER BY `lrn` asc";
    }

    $PrintResult = mysqli_query($conn2, $PrintLRdatabase);
    $ResultArray = array();

    if(mysqli_num_rows($PrintResult) > 0)
    {
        while($row=mysqli_fetch_assoc($PrintResult))
        {
            $ResultArray[] = $row;
        }
    }
   
    $timesofgeneralhere = 0;
    
    if(!empty($ResultArray)){
        foreach ($ResultArray as $result) {
            if (getCity($result["branch"], $conn2) == $fromcity && getCity($result["place"], $conn2) == $tocity) {
                $filter_data[] = $result;
            }
        }
    }
    

    $filter_data = !empty($filter_data) ? $filter_data : [];
    $branches = array_unique(array_column($filter_data, 'branch'));

}

$topaid = "To Paid";
$topay = "To Pay";
$account = "Accounting Software";
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

<body>

    <div class="container-fluid mb-5">
        <table width="100%" class="border-0 table-responsive-sm text-center ">
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
                    echo $fromcity . " થી " . $tocity . " નું જનરલ <br>";

                    ?><br>
                </td>

                <?php if ($timesofgeneralhere == 0) { ?>

                    <td class="border-0" width="25%"></td>
                <?php } else { ?>
                    <td class="border-0"></td>
                <?php } ?>
            </tr>
        </table>
        <?php foreach ($branches as $branch) {
            ; ?>
            <?php $branchData = filterByBranch($filter_data, $branch); ?>
            <div class="table-responsive text-center mt-2">
                <h4 class="text-center"><?php echo $branch; ?></h4>
                <table width="100%" class="table table-bordered text-center mb-4" cellpadding="0" cellspacing="0">
                    <thead class="thead-dark">
                        <th width="5%" class="tablecells">રસીદ</th>
                        <?php if ($dateone != $datetwo) { ?>
                            <th width="10%" class="tablecells">તારીખ</th>
                        <?php } ?>
                        <th width="5%">દાગીના</th>
                        <th width="2%">વજન(Kg)</th>
                        <th width="18%">વિગત</th>
                        <th width="10%">મોકલનાર</th>
                        <th width="10%">લેનાર</th>
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
                        $branchwiseBaki = 0;
                        $branchAccount = 0;
                        $branchwiseJama = 0;


                        if (isset($branchData) && !empty($branchData)) {
                            foreach ($branchData as $AllGetedValues) {
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
                                        <td class="tablecells">

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
                        <th class="tablecells">
                            <?php echo $totaldagina; ?>
                        </th>
                        <th class="tablecells align-middle">
                            <?php echo $totalkg . " કિલો"; ?>
                        </th>
                        <th width="5%" class="tablecells">

                        </th>
                        <th colspan="3" class="tablecells float-end border-0 fw-bold font_bold">
                        </th>
                        <th class="tablecells">Total</th>
                        <th class="tablecells align-middle">
                            <?php echo $totalkhata; ?>
                        </th>
                        <th class="tablecells align-middle">
                            <?php echo $totaljamaamount; ?>
                        </th>
                        <th class="tablecells align-middle lasttablerow"><?php echo $totalbakiamount; ?></th>
                    </thead>
                </table>
                <?php
                $final_array[] = array(
                    "branch" => $branch,
                    "totalBaki" => $totalbakiamount,
                    "totalJama" => $totaljamaamount,
                    "totalKhata" => $totalkhata
                );

        }
        ;
        ?>
            <?php if(!empty($final_array)){?><h3 class="pt-2 pb-3">Branch wise Total</h3><?php };?>
            <table class="w-100 text-center mt-4 pb-5">
                <?php
                $mainBaki = 0;
                $mainJama = 0;
                $mainKhata = 0;
                $mainBranchTotal = 0;
                ?>
                <thead>
                    <th class="text-dark">Branch Name</th>
                    <th class="text-dark">ખાતું</th>
                    <th class="text-dark">જમા</th>
                    <th class="text-dark">બાકી</th>
                    <th class="text-dark">બ્રાંચ કુલ ટોટલ</th>
                    <th class="text-dark">સહી</th>
                </thead>
                <tbody>
                    <?php 
                    $final_array = !empty($final_array) ? $final_array : [];
                    foreach ($final_array as $data) { ?>
                        <tr>
                            <td class="p-1"><?php echo $data["branch"]; ?></td>
                            <td><?php echo $data["totalKhata"]; ?></td>
                            <td><?php echo $data["totalJama"]; ?></td>
                            <td><?php echo $data["totalBaki"]; ?></td>
                            <td><?php echo $data["totalKhata"] + $data["totalJama"] + $data["totalBaki"]; ?></td>
                            <td></td>
                        </tr>
                        <?php
                        $mainBaki = $mainBaki + $data["totalBaki"];
                        $mainJama = $mainJama + $data["totalJama"];
                        $mainKhata = $mainKhata + $data["totalJama"];
                        $mainBranchTotal = $mainBranchTotal + ($data["totalKhata"] + $data["totalJama"] + $data["totalBaki"]);
                    }
                    ; ?>
                </tbody>
                <thead>
                    <th>Grand Total</th>
                    <th><?php echo $mainKhata; ?></th>
                    <th><?php echo $mainJama; ?></th>
                    <th><?php echo $mainBaki; ?></th>
                    <th><?php echo $mainBranchTotal; ?></th>
                </thead>
            </table>
        </div>
    </div>

</body>
<script type="text/javascript">
    window.print();
</script>

</html>