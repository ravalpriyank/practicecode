<?php
date_default_timezone_set('Asia/Kolkata');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("connection.php");
require_once("layouts/core/mainconstants.php");

$sender = !empty($_POST["sender"]) ? $_POST["sender"] : "";
$receiver = !empty($_POST["receiver"]) ? $_POST["receiver"] : "";
$type = !empty($_POST["type"]) ? $_POST["type"] : "";
$fdate = !empty($_POST["filter_date"]) ? $_POST["filter_date"] : "";
$search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";
$search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";
$currentuser = $_SESSION["username"];
if (isset($fdate)) {
    if ($fdate == "") {
        $todaydate = date("Y-m-d");
    } else {
        $todaydate = $fdate;
    }
} else {
    $todaydate = date("Y-m-d");
}

$search_condition = "";
if (!empty($search)) {
    $search_condition = "AND (`nameone` LIKE '%$search%' OR `nametwo` LIKE '%$search%' OR `timestamp` LIKE '%$search%' OR `lrn` LIKE '%$search%' OR `item` LIKE '%$search%' OR `qty` LIKE '%$search%' OR `total` LIKE '%$search%' OR `type` LIKE '%$search%' OR `placefilter` LIKE '%$search%')";
}

if (isset($sender) && !empty($sender) || isset($receiver) && !empty($receiver)) {
    if ($sender != "" && $receiver == "") {
        $sql = "SELECT * FROM `transportz` WHERE `nameone` = '$sender' AND `branch` = '$userbranch' $search_condition ORDER BY `sno` DESC";
    } elseif ($sender == "" && $receiver != "") {
        $sql = "SELECT * FROM `transportz` WHERE `nametwo` = '$receiver' AND `branch` = '$userbranch' $search_condition ORDER BY `sno` DESC";
    } elseif ($sender != "" && $receiver != "") {
        $sql = "SELECT * FROM `transportz` WHERE `nameone` = '$sender' AND `nametwo` = '$receiver' AND `branch` = '$userbranch' $search_condition ORDER BY `sno` DESC";
    } else {
        $sql = "SELECT * FROM `transportz` WHERE `branch` = '$userbranch' AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate' $search_condition ORDER BY `sno` DESC";
    }
} elseif (isset($type) && !empty($type)) {
    if ($type == "paid") {
        $sql = "SELECT * FROM `transportz` WHERE `type` = 'To Paid' AND `branch` = '$userbranch' AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate' $search_condition ORDER BY `sno` DESC";
    } elseif ($type == "topay") {
        $sql = "SELECT * FROM `transportz` WHERE `type` = 'To Pay' AND `branch` = '$userbranch' AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate' $search_condition ORDER BY `sno` DESC";
    } elseif ($type == "account") {
        $sql = "SELECT * FROM `transportz` WHERE `type` = 'Accounting Software' AND `branch` = '$userbranch' AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate' $search_condition ORDER BY `sno` DESC";
    } else {
        $sql = "SELECT * FROM `transportz` WHERE `branch` = '$userbranch' AND entrydate BETWEEN '$todaydate' AND '$todaydate' $search_condition ORDER BY `sno` DESC";
    }
} else {
    $sql = "SELECT * FROM `transportz` WHERE `branch` = '$userbranch' AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate' $search_condition ORDER BY `sno` DESC";
}

$result = mysqli_query($conn2, $sql);
$result_data = array();
if (mysqli_num_rows($result) > 0) {
    while ($raw = mysqli_fetch_assoc($result)) {
        $raw["timestamp"] = date('d-m-Y h:i:s A', strtotime($raw['timestamp']));
        $result_data[] = $raw;
    }
}

//count filterd records

if (isset($sender) && !empty($sender) || isset($receiver) && !empty($receiver)) {
    if ($sender != "" && $receiver == "") {
        $query = "SELECT COUNT(*) AS `total` FROM `transportz` WHERE nameone = '$sender' $search_condition AND branch = '$userbranch'";
    } elseif ($sender == "" && $receiver != "") {
        $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE nametwo = '$receiver' $search_condition AND branch = '$userbranch'";
    } elseif ($sender != "" && $receiver != "") {
        $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE nameone = '$sender' $search_condition AND nametwo = '$receiver' AND branch = '$userbranch'";
    } else {
        $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE branch = '$userbranch' $search_condition AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate'";
    }
} elseif (isset($type) && !empty($type)) {
    if ($type == "paid") {
        $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE `type` = 'To Paid' AND `branch` = '$userbranch' $search_condition AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate'";
    } elseif ($type == "topay") {
        $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE `type` = 'To Pay' AND `branch` = '$userbranch' $search_condition AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate'";
    } elseif ($type == "account") {
        $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE `type` = 'Accounting Software' AND `branch` = '$userbranch' $search_condition AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate'";
    } else {
        $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE `branch` = '$userbranch'  $search_condition AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate'";
    }
} else {
    $query = "SELECT COUNT(*) AS total FROM `transportz` WHERE branch = '$userbranch' $search_condition AND DATE(entrydate) BETWEEN '$todaydate' AND '$todaydate'";
}

$run_query = mysqli_query($conn2, $query);
$total_records = mysqli_fetch_assoc($run_query);

$response = [
    'draw' => isset($_POST["draw"]) ? intval($_POST["draw"]) : 0,
    'recordsTotal' => !empty($total_records) ? $total_records["total"] : 0,
    'recordsFiltered' => !empty($total_records) ? $total_records["total"] : 0,
    'data' => !empty($result_data) ? $result_data : "",
];

echo json_encode($response);


?>