<?php
require_once("layouts/core/mainconstants.php");
require_once("connection.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $inc_reason = !empty($_POST["inc_reason"]) ? $_POST["inc_reason"] : "";
    $inc_detail = !empty($_POST["inc_detail"]) ? $_POST["inc_detail"] : "";
    $inc_date = !empty($_POST["inc_date"]) ? $_POST["inc_date"] : "";
    $inc_amount = !empty($_POST["inc_amount"]) ? $_POST["inc_amount"] : "";
    $inc_eid = !empty($_POST["eid"]) ? $_POST["eid"] : "";
    $edit_permission = !empty($_POST["edit"]) ? $_POST["edit"] : "";

    if ($edit_permission == true) {
        $sql = "UPDATE `incomes` SET `income` = '" . $inc_reason . "' , `incomedetail` = '" . $inc_detail . "' , `date` = '" . $inc_date . "' , `amount` = '" . $inc_amount . "' WHERE `sno` = '" . $inc_eid . "'";
    } else {
        $sql = "INSERT INTO `incomes`(`income` , `incomer` , `incomedetail` , `amount` , `date` , `branch`) VALUES ('" . $inc_reason . "' , '" . $currentloggedinuser . "' , '" . $inc_detail . "' , '" . $inc_amount . "' , '" . $inc_date . "' , '" . $userbranch . "')";
    }

    $run_sql = mysqli_query($conn2, $sql);

    if (!$run_sql) {
        echo "Something Went Wrong";
    }

}
?>