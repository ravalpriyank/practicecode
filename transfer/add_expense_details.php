<?php
require_once("layouts/core/mainconstants.php");
require_once("connection.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $exp_reason = !empty($_POST["exp_reason"]) ? $_POST["exp_reason"] : "";
    $exp_detail = !empty($_POST["exp_detail"]) ? $_POST["exp_detail"] : "";
    $exp_date = !empty($_POST["exp_date"]) ? $_POST["exp_date"] : "";
    $exp_amount = !empty($_POST["exp_amount"]) ? $_POST["exp_amount"] : "";
    $exp_eid = !empty($_POST["eid"]) ? $_POST["eid"] : "";
    $edit_permission = !empty($_POST["edit"]) ? $_POST["edit"] : "";

    if ($edit_permission == true) {
        $sql = "UPDATE `expenses` SET `expense` = '" . $exp_reason . "' , `expensedetail` = '" . $exp_detail . "' , `date` = '" . $exp_date . "' , `amount` = '" . $exp_amount . "' WHERE `sno` = '" . $exp_eid . "'";
    } else {
        $sql = "INSERT INTO `expenses`(`expense` , `expenser` , `expensedetail` , `amount` , `branch` , `date`) VALUES ('" . $exp_reason . "' , '" . $currentloggedinuser . "' , '" . $exp_detail . "' , '" . $exp_amount . "' , '" . $userbranch . "' , '" . $exp_date . "')";
    }

    $run_sql = mysqli_query($conn2, $sql);

    if (!$run_sql) {
        echo "Something Went Wrong";
    }
}
?>