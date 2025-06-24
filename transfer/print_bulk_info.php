<?php

require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("main_const.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $posteddate = $_POST['FromJeneralDates'];
    $sampledate = str_replace(' ', '', $_POST['FromJeneralDates']);
    $datearray = explode("-", $sampledate);
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
    $method = !empty($_POST["ThisPrintMethod"]) ? $_POST["ThisPrintMethod"] : "";

    if (isset($_POST["gstbillonly"])) {
        $gstbillonlycheck = !empty($_POST["gstbillonly"]) ? $_POST["gstbillonly"] : "";
    }

    if ($method == "AllPrint") {
        require_once('print_bulkmethod_one.php');
    }

    if ($method == "SelectedPrint") {
        require_once('styles.php');
        if (isset($_POST['gstbillonly'])) {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND place = '$toplace' AND branch = '$frombranch' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' AND COALESCE(gstone, '') <> '' AND COALESCE(gsttwo, '') <> '' ORDER BY lrn ASC";
            } else {
                $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND place = '$toplace' AND branch = '$frombranch' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' AND COALESCE(gstone, '') <> '' AND COALESCE(gsttwo, '') <> '' ORDER BY lrn ASC";
            }
        } else {
            if (isset($_POST["gst"]) && $_POST["gst"] == "on") {
                $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND place = '$toplace' AND branch = '$frombranch' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn asc";
            } else {
                $PrintLRdatabase = "SELECT * FROM `transportz` WHERE `gst` = 'NO' AND place = '$toplace' AND branch = '$frombranch' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' ORDER BY lrn asc";
            }
        }
        $PrintResult = mysqli_query($conn2, $PrintLRdatabase);
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
        <style>
            .custom_check {
                width: 30px !important;
                height: 30px !important;

            }

            h3 {
                font-family: inherit;
            }

            .rno {
                font-size: 20px !important;
            }
        </style>


        <body>
            <div class="container-fluid">
                <div class="main_contant">
                    <div class="top_titele_page d-flex justify-content-between">
                        <h5 class="float-start pt-3 fw-bold">|| સંગે માંગલ ||</h5>
                        <h5 class="pt-3 fw-bold">|| શ્રી મોગલ કૃપા ||</h5>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-3">
                            <div class="border-0">
                                <img width="96px" src="<?php echo $companylogof; ?>" alt="LOGO">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h3 class="text-center lh-base">
                                <?php
                                echo "Prajapati Express Parcel Service <br>";
                                if ($newdateone == $newdatetwo) {
                                    echo $newdateone . " નું <br>";
                                } else {
                                    echo $newdateone . " થી " . $newdatetwo . " નું <br>";
                                }
                                echo $toplace . " થી " . $frombranch . " નું ડિલિવરી ચાર્ટ <br>";
                                ?>
                            </h3>
                            <div class="col-lg-4">
                            </div>
                        </div>

                    </div>
                    <hr class="mt-4">
                    <div class="main_content_detail pt-4 p-3">
                        <div class="row">
                            <h2 class="text-center">જે જે રસીદ ની પ્રિન્ટ કાઢવા ની હોય એ રસીદ સિલેક્ટ કરો.</h2>
                        </div>

                    </div>
                    <div class="row pb-5">
                        <div class="col-md-12 col-lg-4">
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <form action="print_bulk_info.php" method="POST" target="_blank">
                                <input type="hidden" name="ToThisBranch" value="<?php echo $toplace; ?>">
                                <input type="hidden" name="FromThisBranch" value="<?php echo $frombranch; ?>">
                                <input type="hidden" name="FromJeneralDates" value="<?php echo $posteddate; ?>">
                                <input type="hidden" name="ThisPrintMethod" value="AllPrint">
                                <?php if (isset($_POST["gst"])) { ?>
                                    <input type="hidden" name="gst" value="on">
                                <?php }
                                ; ?>
                                <?php $i = 1;
                                while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
                                    $PrintLR = $AllGetedValues['lrwithcode'];
                                    $LR = $AllGetedValues['lrn']; ?>
                                    <div class=" m-auto" style="width:120px">
                                        <div class="d-flex gap-3 align-items-center pb-3">
                                            <input type="checkbox" class="custom_check" value="<?php echo $LR; ?>"
                                                name="lrlisttoprint[]" id="lr<?php echo $LR; ?>" />
                                            <label for="lr<?php echo $PrintLR; ?>"
                                                class="mr-50 fw-bold m-0 text-dark rno "><?php echo " " . $PrintLR; ?></label>
                                        </div>
                                    </div>
                                    <?php if ($i == 8) {
                                        $i = 0; ?>
                                        <br><br>
                                    <?php }
                                    $i++;
                                } ?>
                                <div class="btns row mt-3">
                                    <div class="col-lg-6 col-md-6 ">
                                        <button class="btn btn-dark w-100 p-2 mt-3" type="button"
                                            onclick="selectAllCheckboxes()">Select
                                            All</button>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3 ">
                                        <button class="btn btn-primary w-100 p-2" type="button"
                                            onclick="deselectAllCheckboxes()">Deselect
                                            All</button>
                                    </div>
                                    <div class=" mt-4">
                                        <button type="submit" class="btn bg-success text-white p-3 w-100"><i aria-current=""
                                                class="fa fa-search"></i><?php echo " " . $print; ?></button>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="col-lg-4 col-md-12">
                        </div>
                    </div>
                </div>

            </div>


        </body>

        </html>

        <?php

    }
}

?>
<script>
    function selectAllCheckboxes() {
        // Get all checkboxes with the name 'lrlisttoprint[]'
        var checkboxes = document.getElementsByName('lrlisttoprint[]');

        // Loop through each checkbox and set checked to true
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
        }
    }

    function deselectAllCheckboxes() {
        // Get all checkboxes with the name 'lrlisttoprint[]'
        var checkboxes = document.getElementsByName('lrlisttoprint[]');

        // Loop through each checkbox and set checked to false
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }
</script>