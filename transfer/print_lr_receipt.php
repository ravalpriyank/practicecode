<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("main_const.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $lrno = !empty($_POST["lr_no"]) ? $_POST["lr_no"] : "";

    $query = "SELECT * FROM `transportz` WHERE `lrn` = '$lrno'";
    $run_query = mysqli_query($conn2, $query);
    $data = mysqli_fetch_assoc($run_query);

    $sno = !empty($data["sno"]) ? $data["sno"] : "";
    $sender_name = !empty($data["nameone"]) ? $data["nameone"] : "";
    $sender_number = !empty($data["numone"]) ? $data["numone"] : "";
    $receiver_name = !empty($data["nametwo"]) ? $data["nametwo"] : "";
    $receiver_number = !empty($data["numtwo"]) ? $data["numtwo"] : "";
    $sender_gst = !empty($data["gstone"]) ? $data["gstone"] : "";
    $receiver_gst = !empty($data["gsttwo"]) ? $data["gsttwo"] : "";
    $item_qty = !empty($data["qty"]) ? $data["qty"] : "";
    $item_qtytwo = !empty($data["qtytwo"]) ? $data["qtytwo"] : "";
    $qtyone_array = !empty($data["qtyarray"]) ? explode(",", $data["qtyarray"]) : "";
    $qtytwo_array = !empty($data["qtytwoarray"]) ? explode(",", $data['qtytwoarray']) : "";
    $date_time = !empty($data["timestamp"]) ? date('d-m-Y h:i A', strtotime($data["timestamp"])) : "";
    $color = !empty($data["color"]) ? $data["color"] : "";
    $item_name = !empty($data["item"]) ? explode(",", $data["item"]) : "";
    $rate_details = !empty($data["qtyarray"]) ? explode(",", $data["qtyarray"]) : "";
    $branch = !empty($data["branch"]) ? $data["branch"] : "";
    $invoice_no = !empty($data["invoiceno"]) ? $data["invoiceno"] : "";
    $invoice_amt = !empty($data["invoiceamt"]) ? $data["invoiceamt"] : "";
    $hamali = !empty($data["hamali"]) ? explode(",", $data["hamali"]) : "";
    $bill_no = !empty($data["waybill"]) ? $data["waybill"] : "";
    $bill_type = !empty($data["type"]) ? $data["type"] : "";
    $place = !empty($data["place"]) ? $data["place"] : "";
    $remark = !empty($data["remark"]) ? $data["remark"] : "";
    $driver_no = !empty($data["drivernumber"]) ? $data["drivernumber"] : "";
    $total = !empty($data["total"]) ? $data["total"] : "";

    $findingbranchcode = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE `name` = '$branch'");
    while ($row = mysqli_fetch_array($findingbranchcode)) {
        $bookingbranchcode = $row["code"];
        $PrintSenderBranchNumber = $row["phone"];
        $PrintSenderBranchAddress = $row["address"];
    }

    $PrintBranchdatabase = "SELECT * FROM `branchlog` WHERE `branchwithcode` = '$place' LIMIT 1";
    $BranchResult = mysqli_query($conn2, $PrintBranchdatabase);
    while ($AllBranchValues = mysqli_fetch_assoc($BranchResult)) {
        $PrintBranchAddress = $AllBranchValues["address"];
        $PrintBranchPhone = $AllBranchValues["phone"];
    }

    if ($bill_type == "બાકી") {
        $printornot = $printsettingbaki;
    } elseif ($bill_type == "જમા") {
        $printornot = $printsettingjama;
    } elseif ($bill_type == "ખાતું") {
        $printornot = $printsettingaccount;
    } else {
        $printornot = 'yes';
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>From : <span><?php echo !empty($branch) ? $branch : ""; ?></span></th>
                    <th>To : <span><?php echo !empty($place) ? $place : ""; ?></span></th>
                    <th>LR :
                        <span><?php echo !empty(isset($bookingbranchcode) && $lrno) ? $bookingbranchcode . "-" . $lrno : ""; ?></span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-none">
                    <td class="border-none"><b>Sender :
                        </b><span><?php echo !empty($sender_name) ? $sender_name : ""; ?></span><br>
                        <b>Sender Number : </b>
                        <span><?php echo !empty($sender_number) ? $sender_number : ""; ?></span><br>
                        <b>Sender GST : </b> <span><?php echo !empty($sender_gst) ? $sender_gst : ""; ?>
                    </td>

                    <td>
                        <b>Receiver :</b><span><?php echo !empty($receiver_name) ? $receiver_name : ""; ?></span><br>
                        <b>Receiver Number
                            :</b><span><?php echo !empty($receiver_number) ? $receiver_number : ""; ?></span><br>
                        <b>Receiver GST :</b><span> <?php echo !empty($receiver_gst) ? $receiver_gst : ""; ?></span>
                    </td>
                    <td>
                        <b>Booking Time :</b><span>
                            <?php $PrintDateandTimeFormat = strtotime(isset($date_time)); ?>
                            <?php if ($printtimeonrasid == "yes") {
                                echo date('d-m-Y h:i:s A', $PrintDateandTimeFormat);
                            } else {
                                echo date('d-m-Y', $PrintDateandTimeFormat);
                            } ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="p-0">
                        <div class="d-flex">
                            <div class=" border w-50 p-2">
                                <b>Invoice No :</b><span><?php echo !empty($invoice_no) ? $invoice_no : ""; ?></span>
                            </div>
                            <div class=" border w-50 p-2">
                                <b>Invoice Amt :</b><span><?php echo !empty($invoice_amt) ? $invoice_amt : ""; ?></span>
                            </div>
                        </div>
                    </td>
                    <td class="p-0">
                        <div class="d-flex">
                            <div class=" border w-50 p-2">
                                <b>E-Way Bill :</b><span><?php echo !empty($bill_no) ? $bill_no : ""; ?></span>
                            </div>
                            <div class=" border w-50 p-2">
                                <b>Bill Charge :</b> <?php echo "10"; ?></span>
                            </div>
                        </div>
                    </td>
                    <td class="p-0">
                        <div class="d-flex">
                            <div class=" border w-50 p-2">
                                <b>Hamali : </b><span><?php
                                $i = 0;
                                $netHamali = 0;
                                if (isset($item_name)) {
                                    foreach ($item_name as $itemishere) {
                                        if ($hamali != null || $hamali != 0 || $hamali != "") {
                                            $netHamali += intval($hamali);
                                        }
                                        $i++;
                                    }
                                }
                                echo $netHamali; ?></span>
                            </div>
                            <div class=" border w-50 p-2">
                                <b>Gross Amt :</b><span><?php echo !empty($total) ? $total : ""; ?></span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>Item Detail :</b>
                        <span>
                            <?php

                            if (isset($item_name)) {
                                $i = 0;
                                foreach ($item_name as $itemishere) {
                                    echo $qtyone_array[$i];
                                    echo "-" . $itemishere;
                                    if (intval($qtytwo_array) != 0) {
                                        echo "(" . $qtytwo_array[$i] . "Kg)";
                                    }
                                    if ((count($item_name) > 1) && (count($item_name) != $i + 1)) {
                                        echo " / ";
                                    }
                                    $i++;
                                }
                            }
                            if ($i > 1) {
                                echo "<div style='text-align: right;'>Total " . $item_qty . " Item";
                                if ($item_qtytwo != 0) {
                                    echo " & " . $item_qtytwo . " Kg Weight";
                                }
                                echo "</div>";
                            }
                            ?>
                        </span>
                    </td>
                    <td colspan="2" class="text-center">
                        <span>
                            <b>
                                <?php

                                $netValue = 0;
                                $netValue += intval(isset($total));
                                $netValue += 10;
                                $netValue += $netHamali;
                                if (isset($printornot) == 'yes') {
                                    echo $bill_type . " <br> " . intval($netValue);
                                } else {
                                    echo !empty($bill_type) ? $bill_type : "";
                                }
                                ?>
                            </b>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class=" " colspan="2">
                        <div class="delivery w-100">
                            <?php
                            if (!empty($PrintBranchAddress) || !empty($place) || !empty($PrintBranchPhone)) {
                                echo "<strong>Delivery at : </strong>";
                                if (!empty($PrintBranchAddress)) {
                                    echo "<span>$PrintBranchAddress</span>";
                                }
                                if (!empty($place)) {
                                    echo "<span>$place</span>";
                                }
                                if (!empty($PrintBranchPhone)) {
                                    echo "<span> // Mo : " . "$PrintBranchPhone</span>";
                                }
                            } ?>
                        </div>
                    </td>
                    <td>
                        <div class="remark"> <?php if (isset($remark) != "") {
                            echo "" . $driver_no . " Remarks :" . $remark;
                        } ?></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
<script>
    window.print();
    setTimeout(window.close, 500);
</script>