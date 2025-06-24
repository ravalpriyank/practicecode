<?php
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = !empty($_POST["sender_name"]) ? $_POST["sender_name"] : "";
    $sender_mobile = !empty($_POST["sender_no"]) ? $_POST["sender_no"] : "";
    $sender_gst = !empty($_POST["sender_gst"]) ? $_POST["sender_gst"] : "";
    $receiver = !empty($_POST["receiver_name"]) ? $_POST["receiver_name"] : "";
    $receiver_mobile = !empty($_POST["receiver_no"]) ? $_POST["receiver_no"] : "";
    $receiver_gst = !empty($_POST["receiver_gst"]) ? $_POST["receiver_gst"] : "";
    $payment_type = !empty($_POST["paymentEdit"]) ? $_POST["paymentEdit"] : "";

    $sql = "SELECT * FROM `customer_relation` ORDER BY `sno` DESC LIMIT 1";
    $run_sql = mysqli_query($conn2, $sql);
    $last_rid = mysqli_fetch_assoc($run_sql);

    if (isset($last_rid["sno"]) && !empty($last_rid["sno"])) {
        $last_rid = $last_rid["sno"] + 1;
    } else {
        $last_rid = 1;
    }

    if (isset($_POST["edit"]) && (!empty($_POST["edit"]) && $_POST["edit"] == "true")) {
        $insert_sql = "UPDATE `customer_relation` SET `sender_name` = '$sender' , `sender_mobile` = '$sender_mobile' , `sender_gst` = '$sender_gst' , `receiver_name` = '$receiver' , `receiver_mobile` = '$receiver_mobile' , `receiver_gst` = '$receiver_gst' , `payment_method` = '$payment_type' WHERE `sno` = '" . $_POST["eid"] . "'";
    } else {
        $insert_sql = "INSERT INTO customer_relation(`sno`,`rid`,`sender_name`,`sender_mobile`,`sender_gst`,`receiver_name`,`receiver_mobile`,`receiver_gst`,`payment_method`)VALUES('" . $last_rid . "' , '" . $branch_code_data["code"] . "-" . $last_rid . "' , '$sender' , '$sender_mobile' , '$sender_gst' , '$receiver' , '$receiver_mobile' , '$receiver_gst','$payment_type')";
    }

    $run_insert = mysqli_query($conn2, $insert_sql);

    if ($run_insert) {
        if (isset($_POST["edit"])) {
            echo "<script>alert('Customer updated successfully');</script>";
        } else {
            echo "<script>alert('Customer added successfully');</script>";
        }
    }
}
?>