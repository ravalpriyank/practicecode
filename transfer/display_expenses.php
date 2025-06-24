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
$order_columns = ["sno", "date", "expense", "expensedetail", "amount", "expenser"];
$order_column_name = $order_columns[$order_column_index];
$order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "asc";

// Total records count without filtering
$sql_total = "SELECT COUNT(*) AS total FROM `expenses` WHERE `branch` = '$userbranch'";
$result_total = mysqli_query($conn2, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$records_total = $row_total['total'];

// Filtering
$search_condition = "1"; // Default condition if no search
if (!empty($search)) {
    $search_condition = "`sno` LIKE '%$search%' OR `date` LIKE '%$search%' OR `expense` LIKE '%$search%' OR `expensedetail` LIKE '%$search%' OR `amount` LIKE '%$search%' OR `expenser` LIKE '%$search%'";
}

// Total records count with filtering
$sql_filtered_total = "SELECT COUNT(*) AS total FROM expenses WHERE $search_condition AND `branch` = '$userbranch'";
$result_filtered_total = mysqli_query($conn2, $sql_filtered_total);
$row_filtered_total = mysqli_fetch_assoc($result_filtered_total);
$records_filtered = $row_filtered_total['total'];

// Fetch data with limit and order
$sql_data = "SELECT * FROM expenses WHERE $search_condition AND `branch` = '$userbranch' ORDER BY $order_column_name $order_dir LIMIT $start, $length";
$result_data = mysqli_query($conn2, $sql_data);
$expense_data = array();
while ($row = mysqli_fetch_assoc($result_data)) {
    $expense_data[] = $row;
}

$response = [
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
    'recordsTotal' => $records_total,
    'recordsFiltered' => $records_filtered,
    'data' => !empty($expense_data) ? $expense_data : [],
];

echo json_encode($response);
?>