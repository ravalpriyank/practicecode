<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$date = DATE('Y-m-d');
$month = DATE('m');

$query_paid = "SELECT `branch` , SUM(`total`) AS total FROM `transportz` WHERE `type` = 'To Paid' AND MONTH(`entrydate`) = '$month' GROUP BY `branch`";
$run_query_paid = mysqli_query($conn2, $query_paid);

$paid_data = array();
if (mysqli_num_rows($run_query_paid) > 0) {
    while ($row = mysqli_fetch_assoc($run_query_paid)) {
        $paid_data[] = $row;
        $paid_branch[] = $row["branch"];
        $paid_total[] = $row["total"];
    }
}

$query_topay = "SELECT `branch` , SUM(`total`) AS total FROM `transportz` WHERE `type` = 'To Pay' AND MONTH(`entrydate`) = '$month' GROUP BY `branch`";
$run_query_topay = mysqli_query($conn2, $query_topay);

$topay_data = array();
if (mysqli_num_rows($run_query_topay) > 0) {
    while ($row = mysqli_fetch_assoc($run_query_topay)) {
        $topay_data[] = $row;
        $topay_branch[] = $row["branch"];
        $topay_total[] = $row["total"];
    }
}

$query_account = "SELECT `branch` , SUM(`total`) AS total FROM `transportz` WHERE `type` = 'Accounting Software' AND MONTH(`entrydate`) = '$month' GROUP BY `branch`";
$run_query_account = mysqli_query($conn2, $query_account);

$account_data = array();
if (mysqli_num_rows($run_query_account) > 0) {
    while ($row = mysqli_fetch_assoc($run_query_account)) {
        $account_data[] = $row;
        $account_branch[] = $row["branch"];
        $account_total[] = $row["total"];
    }
}

$query_all = "SELECT `branch` , SUM(`total`) AS total FROM `transportz` WHERE MONTH(`entrydate`) = '$month'  GROUP BY `branch`";
$run_query_all = mysqli_query($conn2, $query_all);

$all_data = array();
if (mysqli_num_rows($run_query_all) > 0) {
    while ($row = mysqli_fetch_assoc($run_query_all)) {
        $all_data[] = $row;
        $all_branch[] = $row["branch"];
        $all_total[] = !empty($row["total"]) ? $row["total"] : 0;
    }
}

$query = "SELECT `type` , SUM(`total`) AS total FROM `transportz` WHERE `branch` = '$userbranch' AND `entrydate` = '$date' GROUP BY `type`";
$run_query = mysqli_query($conn2, $query);
$data = array();
if (mysqli_num_rows($run_query) > 0) {
    while ($row = mysqli_fetch_assoc($run_query)) {
        $data[] = $row;
    }
}

$query_total = "SELECT SUM(`total`) AS `total` FROM `transportz` WHERE `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_query_total = mysqli_query($conn2, $query_total);
$data_total = mysqli_fetch_assoc($run_query_total);

$mquery = "SELECT `type` , SUM(`total`) as total FROM `transportz` WHERE `branch` = '$userbranch' AND MONTH(`entrydate`) = '$month' GROUP BY `type`";
$run_mquery = mysqli_query($conn2, $mquery);

$mdata = array();

if (mysqli_num_rows($run_mquery) > 0) {
    while ($row = mysqli_fetch_assoc($run_mquery)) {
        $mdata[] = $row;
    }
}


$query_ctotal = "SELECT SUM(`total`) AS `total` FROM `transportz` WHERE `branch` = '$userbranch' AND MONTH(`entrydate`) = '$month'";
$run_query_ctotal = mysqli_query($conn2, $query_ctotal);
$data_ctotal = mysqli_fetch_assoc($run_query_ctotal);

//dashbord first-column data for current day

$query1 = "SELECT SUM(`total`) as `total` FROM `transportz` WHERE `type` = 'To Paid' AND `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_query1 = mysqli_query($conn2, $query1);
$data1 = mysqli_fetch_assoc($run_query1);

$query2 = "SELECT SUM(`total`) as `total` FROM `transportz` WHERE `type` = 'To Pay' AND `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_query2 = mysqli_query($conn2, $query2);
$data2 = mysqli_fetch_assoc($run_query2);

$query3 = "SELECT SUM(`total`) as `total` FROM `transportz` WHERE `type` = 'Accounting Software' AND `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_query3 = mysqli_query($conn2, $query3);
$data3 = mysqli_fetch_assoc($run_query3);

//dashbord first-column data for current month

$dquery1 = "SELECT SUM(`total`) as `total` FROM `transportz` WHERE `type` = 'To Paid' AND `branch` = '$userbranch' AND MONTH(`entrydate`) = '$month'";
$run_dquery1 = mysqli_query($conn2, $dquery1);
$mdata1 = mysqli_fetch_assoc($run_dquery1);

$dquery2 = "SELECT SUM(`total`) as `total` FROM `transportz` WHERE `type` = 'To Pay' AND `branch` = '$userbranch' AND MONTH(`entrydate`) = '$month'";
$run_dquery2 = mysqli_query($conn2, $dquery2);
$mdata2 = mysqli_fetch_assoc($run_dquery2);

$dquery3 = "SELECT SUM(`total`) as `total` FROM `transportz` WHERE `type` = 'Accounting Software' AND `branch` = '$userbranch' AND MONTH(`entrydate`) = '$month'";
$run_dquery3 = mysqli_query($conn2, $dquery3);
$mdata3 = mysqli_fetch_assoc($run_dquery3);

//data for invested overview

$iquery = "SELECT SUM(`amount`) as `amount` FROM `incomes` WHERE `branch` = '$userbranch' AND MONTH(`date`) = '$month'";
$run_iquery = mysqli_query($conn2, $iquery);
$idata = mysqli_fetch_assoc($run_iquery);

$equery = "SELECT SUM(`amount`) as `amount` FROM `expenses` WHERE `branch` = '$userbranch' AND MONTH(`date`) = '$month'";
$run_equery = mysqli_query($conn2, $equery);
$edata = mysqli_fetch_assoc($run_equery);

// all transaction history

$aquery = "SELECT `lrn` , `nameone` , `nametwo` , `total` , `type` FROM `transportz` WHERE `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_aquery = mysqli_query($conn2, $aquery);
$data_aquery = array();

if (mysqli_num_rows($run_aquery) > 0) {
    while ($row = mysqli_fetch_assoc($run_aquery)) {
        $data_aquery[] = $row;
    }
}

// paid transaction history

$pquery = "SELECT `lrn` , `nameone` , `nametwo` , `total` , `type` FROM `transportz` WHERE `type` = 'To Paid' AND `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_pquery = mysqli_query($conn2, $pquery);
$data_pquery = array();

if (mysqli_num_rows($run_pquery) > 0) {
    while ($row = mysqli_fetch_assoc($run_pquery)) {
        $data_pquery[] = $row;
    }
}

//topay transaction history

$payquery = "SELECT `lrn` , `nameone` , `nametwo` , `total` , `type` FROM `transportz` WHERE `type` = 'To Pay' AND `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_payquery = mysqli_query($conn2, $payquery);
$data_payquery = array();

if (mysqli_num_rows($run_payquery) > 0) {
    while ($row = mysqli_fetch_assoc($run_payquery)) {
        $data_payquery[] = $row;
    }
}

//accounting software transaction history

$acc_query = "SELECT `lrn` , `nameone` , `nametwo` , `total` , `type` FROM `transportz` WHERE `type` = 'Accounting Software' AND `branch` = '$userbranch' AND `entrydate` = '$date'";
$run_acc_query = mysqli_query($conn2, $acc_query);
$data_acc_query = array();

if (mysqli_num_rows($run_acc_query) > 0) {
    while ($row = mysqli_fetch_assoc($run_acc_query)) {
        $data_acc_query[] = $row;
    }
}

//parcel delivery records

$del_query = "SELECT * FROM `transportz` WHERE `status` = 'close' AND `exitdate` = '$date'";
$run_del_query = mysqli_query($conn2, $del_query);
$delivery_data = array();

if (mysqli_num_rows($run_del_query) > 0) {
    while ($row = mysqli_fetch_assoc($run_del_query)) {
        $delivery_data[] = $row;
    }
}

//chart 2 data variable
$monthly_total = !empty($data_ctotal["total"]) ? $data_ctotal["total"] : 0;
$income = !empty($idata["amount"]) ? $idata["amount"] : 0;
$expense = !empty($edata["amount"]) ? $edata["amount"] : 0;

$invested_total = $monthly_total + $income + $expense;
if ($invested_total == 0) {
    $invested_total = 1;
}
$income_per = (($monthly_total + $income) * 100) / $invested_total;
$income_per = !empty($income_per) ? (ceil($income_per)) : 0;
?>