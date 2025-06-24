<?php
$currentDateandtime = new DateTime();
?>
<html>

<head>
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="stylesheet" href="assets/css/print_recipt.css">
    <title>GT Solutions: <?php echo "Print -" . $PrintLR; ?></title>
</head>

<body style="line-height: 1 !important;  font-size: 16px !important">
    <div class="container-fluid">
        <table class="table table-bordered mb-0 mt-5">
            <tr>
                <td width="40%" colspan="2" class="">
                    <div class="mb-2">
                        <b class="mb-2">બુકિંગ ઓફિસ : </b><span
                            class=" mb-3"><?php echo $PrintBookingDoneBy; ?></span><br>
                    </div>
                    <div>
                        <b>ફોન નંબર : </b><span class="m-0"><?php echo $PrintSenderBranchNumber; ?></span>
                    </div>
                </td>
                <td width="40%" colspan="2">
                    <div class="pb-2">
                        <b class="pb-2"> મોકલવા ની જગ્યા : </b><span
                            class="pb-2"><?php echo $PrintPlaceSendDetails; ?></span>
                    </div>
                    <div><b>ફોન નંબર :</b> <span><?php echo $PrintBranchPhone; ?></span></div>


                </td>
                <td colspan="2">
                    <div class="text-center p-3">
                        <span><?php echo $bookingbranchcode . "-" . $PrintLR; ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="pb-2">
                        <?php echo "<b> Sender :</b> " . $PrintSender; ?>
                    </div>
                    <div class="pb-2">
                        <?php if ($PrintSenderNumber != "") {
                            echo "<b>Sender Num :</b> " . $PrintSenderNumber;
                        } ?>
                    </div>
                    <div>
                        <?php if (isset($PrintSenderGST) && !empty($PrintSenderGST)) {
                            echo "<b>GST : </b>" . $PrintSenderGST;
                        } ?>
                    </div>
                </td>
                <td colspan="<?php echo $printornot == "on" ? "2" : "3"; ?>">
                    <div class="pb-2">
                        <?php echo " <b>Reciver :</b> " . $PrintReciver; ?>
                    </div>
                    <div class="pb-2">
                        <?php if ($PrintReciverNumber != "") {
                            echo "<b>Reciver Num :</b> " . $PrintReciverNumber;
                        } ?>
                    </div>
                    <div>
                        <?php if (isset($PrintReciverGST) && !empty($PrintReciverGST)) {
                            echo "<b>GST : </b>" . $PrintReciverGST;
                        } ?>
                    </div>
                </td>
                <?php if ($printornot == "on") { ?>
                    <td class="tablecells bakijama " colspan="2">
                        <div class="text-center p-3">
                            <?php echo "<b>Payment :</b>" . $PrintTypeDetails; ?>
                        </div>
                    </td>
                <?php }
                ; ?>
            </tr>
            <tr>
                <td colspan="5" class="tablecells vigat">
                    <div>
                        <?php echo "Item Detail : " . $PrintQTYDetails . " " . $PrintColorDetails . " " . $PrintItemDetails; ?>
                    </div>
                </td>
            </tr>
            <tr class="border-0">
                <td colspan="4" class="tablecells remark p-0 border-0">
                    <table class="w-100 p-2 border-0">
                        <tr class="border-0">
                            <td class="w-50 p-2 border-end border-start border-dark border-top-0 border-bottom-0">
                                <?php echo "માલ મેળવવા નું " . "<b>Address : </b>" . $PrintBranchAddress; ?>
                            </td>
                            <td class="w-50 p-2 border-0">
                                <?php echo $PrintDriverNumberDetails . " " . $PrintRemarkDetails; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td rowspan="2" class="tablecells total text-center">
                    <?php if ($printornot == "on") { ?>
                        <b> કુલ : </b><span><?php echo intval($PrintTotalDetails); ?></span>
                    <?php } else {
                        ; ?>
                        <span><?php echo $PrintTypeDetails; ?></span>
                    <?php }
                    ; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="datesprint">
                    <?php
                    $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                    if ($printtimeonrasid == 'on') {
                        $final = date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                    } else {
                        $final = date('d-m-Y', $PrintDateandTimeFormat);
                    }
                    ?>
                    <h5><?php echo "બુકિંગ સમય : " . $final; ?></h5>
                </td>
                <td colspan="2" class="tablecells datesprint">
                    <?php
                    $PrintDateandTimeFormat = strtotime($PrintDateandTime);
                    if ($printtimeonrasid == 'on') {
                        $final = date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                    } else {
                        $final = date('d-m-Y', $PrintDateandTimeFormat);
                    }
                    ?>
                    <?php $PrintDateandTimeFormat = strtotime($PrintDateandTime); ?>
                    <h5><?php echo "પ્રિન્ટ સમય : " . $final ?></h5>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<script>
    // window.print();
    // setTimeout(window.close, 500);
</script>