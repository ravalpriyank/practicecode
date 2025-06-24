<?php
require_once("layouts/core/mainconstants.php");
require_once("connection.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";


$order_column_index = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 1;
$order_columns = ["sno", "date", "income", "incomedetail", "amount", "incomer"];
$order_column_name = $order_columns[$order_column_index];
$order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "asc";


$sql_total = "SELECT COUNT(*) AS total FROM incomes WHERE `branch` = '$userbranch'";
$result_total = mysqli_query($conn2, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$records_total = $row_total['total'];

$search_condition = "1";
if (!empty($search)) {
    $search_condition = "`sno` LIKE '%$search%' OR `date` LIKE '%$search%' OR `income` LIKE '%$search%' OR `incomedetail` LIKE '%$search%' OR `amount` LIKE '%$search%' OR `incomer` LIKE '%$search%'";
}

$sql_filtered_total = "SELECT COUNT(*) AS total FROM `incomes` WHERE $search_condition AND `branch` = '$userbranch'";
$result_filtered_total = mysqli_query($conn2, $sql_filtered_total);
$row_filtered_total = mysqli_fetch_assoc($result_filtered_total);
$records_filtered = $row_filtered_total['total'];

$sql_data = "SELECT * FROM incomes WHERE $search_condition AND `branch` = '$userbranch' ORDER BY $order_column_name $order_dir LIMIT $start, $length";
$result_data = mysqli_query($conn2, $sql_data);

$income_data = array();
while ($row = mysqli_fetch_assoc($result_data)) {
    $income_data[] = $row;
}

$response = [
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
    'recordsTotal' => $records_total,
    'recordsFiltered' => $records_filtered,
    'data' => !empty($income_data) ? $income_data : [],
];

echo json_encode($response);
?>