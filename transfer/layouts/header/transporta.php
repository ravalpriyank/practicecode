<?php
$myitemdetailsen = getdirectarray("itemdetail", "itemen");
$myitemdetailsgu = getdirectarray("itemdetail", "itemgu");
$myitemdetails = array_combine($myitemdetailsen, $myitemdetailsgu);
$drivenames = getdirectarray("thirdparties", "name");
$drivenumbers = getdirectarray("transportz", "drivernumber");
$branchcustomerssender = getarraywithstring("transportz", "branch", $userbranch, "nameone");
$branchcustomersreciver = getarraywithstring("transportz", "branch", $userbranch, "nametwo");
?>
<style>
    #overlaydelete {
        position: fixed;
        display: block;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0);
        z-index: 2;
        cursor: pointer;
    }

    #overlaydeletetext {
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 50px;
        color: white;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
    }

    .glow {
        animation: glow 0.5s ease-in-out infinite alternate;
    }
</style>
<script>
    function multiplication_calculate(qty, rate) {
        var total = Math.round(qty * rate);
        return total;
    }
</script>
<?php
if ($lang == "gu") { ?>
    <script type="text/javascript">
        google.load("elements", "1", {
            packages: "transliteration"
        });

        function onLoad() {
            var options = {
                sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
                destinationLanguage: [google.elements.transliteration.LanguageCode.GUJARATI],
                shortcutKey: 'ctrl+g',
                transliterationEnabled: true
            };
            var control =
                new google.elements.transliteration.TransliterationControl(options);
            control.makeTransliteratable(['remarkEdit', 'senderEdit', 'reciverEdit']);
        }
        google.setOnLoadCallback(onLoad);
    </script>
<?php } ?>

<body>
    <?php

    if (isset($_POST['FindCustomerTable'])) {
        $FindSender = $_POST['FindCustomerSender'];
        $FindReciever = $_POST['FindCustomerReciver'];
    }

    if (isset($_POST['EditLR'])) {
        $EditLR = $_POST['EditLR'];
        $viewlastnumber = $EditLR;
        $editLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$EditLR' LIMIT 1";
        $EditResult = mysqli_query($conn2, $editLRdatabase);
        while ($AllGetedValues = mysqli_fetch_assoc($EditResult)) {
            $EditSender = $AllGetedValues['nameone'];
            $EditSenderNumber = $AllGetedValues['numone'];
            $EditSenderGST = $AllGetedValues['gstone'];
            $EditReciverGST = $AllGetedValues['gsttwo'];
            $EditReciver = $AllGetedValues['nametwo'];
            $EditReciverNumber = $AllGetedValues['numtwo'];
            // All Items 
            $ArrayofItemDetails = explode(",", $AllGetedValues['item']);
            $totalnumberofiteminbill = 0;
            foreach ($ArrayofItemDetails as $itemishere) {
                $totalnumberofiteminbill++;
            }
            $ArrayofColorDetails = explode(",", $AllGetedValues['color']);
            $ArrayofqtyDetails = explode(",", $AllGetedValues['qtyarray']);
            $ArrayofqtyarraytwoDetails = explode(",", $AllGetedValues['weightarray']);
            $EditQTYDetails = $AllGetedValues['qty'];
            $EditweightDetails = $AllGetedValues['weight'];
            $ArrayofRates = explode(",", $AllGetedValues['rate']);
            $EditTotalDetails = $AllGetedValues['total'];
            $ArrayofTotal = explode(",", $AllGetedValues['totalarray']);
            $EditTypeDetails = $AllGetedValues['type'];
            $EditPlaceSendDetails = $AllGetedValues['place'];
            $EditRemarkDetails = $AllGetedValues['remark'];
            $EditDriverNumberDetails = $AllGetedValues['drivernumber'];
            $EditNewrate = round($EditTotalDetails / $EditQTYDetails, 2);
        }
    } elseif (isset($_POST['AddDeliveryNow'])) {
        $PrintLR = $_POST['AddDeliveryNow'];
        $PrintLRdatabase = "SELECT * FROM `transportz` WHERE lrn = '$PrintLR' LIMIT 1";
        $PrintResult = mysqli_query($conn2, $PrintLRdatabase);
        while ($AllGetedValues = mysqli_fetch_assoc($PrintResult)) {
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
            $PrintTypeDetails = $AllGetedValues['type'];
            $PrintPlaceSendDetails = cleanbranch($AllGetedValues['place']);
            $PrintRemarkDetails = $AllGetedValues['remark'];
            $PrintBranchDetails = $AllGetedValues['branch'];
            $PrintCreatorDetails = $AllGetedValues['createby'];
            $PrintStatusDetails = $AllGetedValues['status'];
            $PrintDriverNumberDetails = $AllGetedValues['drivernumber'];
            $PrintDateandTime = date('d-m-Y h:i A', strtotime($AllGetedValues['timestamp']));
            if ($PrintStatusDetails == "close") {
                $PrintRecNameis = $AllGetedValues['receiver'];
                $PrintRecNumberis = $AllGetedValues['recivernumber'];
                $PrintDeliveryDateOLD = $AllGetedValues['exitdate'];
                $PrintDeliveryDate = date_create_from_format("Y-m-d", $PrintDeliveryDateOLD)->format("d-m-Y");
                $PrintCollectonsDetails = $AllGetedValues['collection'];
                $PrintDeliverydoneBy = $AllGetedValues['deliverby'];
            }
        }
        if (isset($PrintPlaceSendDetails)) {
            $PrintBranchdatabase = "SELECT * FROM `branchlog` WHERE name = '$PrintPlaceSendDetails' LIMIT 1";
            $BranchResult = mysqli_query($conn2, $PrintBranchdatabase);
            while ($AllBranchValues = mysqli_fetch_assoc($BranchResult)) {
                $PrintBranchAddress = $AllBranchValues['address'];
                $PrintBranchPhone = $AllBranchValues['phone'];
            }
        }
    }

    ?>