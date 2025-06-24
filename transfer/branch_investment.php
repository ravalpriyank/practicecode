<?php
require_once("connection.php");
require_once("layouts/core/mainconstants.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $imonth = !empty($_POST["month"]) ? $_POST["month"] : "";
    $imonth = date('m', strtotime($imonth));

    $iquery = "SELECT SUM(`amount`) as `income_amount` FROM `incomes` WHERE `branch` = '$userbranch' AND MONTH(`date`) = '$imonth'";
    $run_iquery = mysqli_query($conn2, $iquery);
    $idata = mysqli_fetch_assoc($run_iquery);

    $equery = "SELECT SUM(`amount`) as `expense_amount` FROM `expenses` WHERE `branch` = '$userbranch' AND MONTH(`date`) = '$imonth'";
    $run_equery = mysqli_query($conn2, $equery);
    $edata = mysqli_fetch_assoc($run_equery);

    $bquery = "SELECT SUM(`total`) as `total` FROM `transportz` WHERE `branch` = '$userbranch' AND MONTH(`entrydate`) = '$imonth'";
    $run_bquery = mysqli_query($conn2, $bquery);
    $bdata = mysqli_fetch_assoc($run_bquery);

    $data = array(
        "total" => !empty($bdata["total"]) ? $bdata["total"] : 0,
        "income" => !empty($idata["income_amount"]) ? $idata["income_amount"] : 0,
        "expense" => !empty($edata["expense_amount"]) ? $edata["expense_amount"] : 0
    );
    echo json_encode($data);
}
?>