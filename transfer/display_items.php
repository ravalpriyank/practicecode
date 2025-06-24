<?php
require_once("connection.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";

$order_column_index = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 1;
$order_columns = ["sno", "itemen", "itemgu"];
$order_column_name = $order_columns[$order_column_index];
$order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "asc";

$search_condition = "1";
if (!empty($search)) {
    $search_condition = "`sno` LIKE '%$search%' OR `itemen` LIKE '%$search%' OR `itemgu` LIKE '%$search%'";
}

$sql_filtered_total = "SELECT COUNT(*) AS `total` FROM `itemdetail` WHERE $search_condition";
$result_filtered_total = mysqli_query($conn2, $sql_filtered_total);
$row_filtered_total = mysqli_fetch_assoc($result_filtered_total);
$records_filtered = $row_filtered_total['total'];

$item_sql = "SELECT * FROM `itemdetail` WHERE $search_condition ORDER BY $order_column_name $order_dir LIMIT $start, $length";
$run_item_sql = mysqli_query($conn2, $item_sql);
$item_data = array();

$sql_total = "SELECT COUNT(*) AS `total` FROM `itemdetail`";
$result_total = mysqli_query($conn2, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$records_total = $row_total['total'];

if (mysqli_num_rows($run_item_sql) > 0) {
    while ($row = mysqli_fetch_assoc($run_item_sql)) {
        $item_data[] = $row;
    }
}

$response = [
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
    'recordsTotal' => $records_total,
    'recordsFiltered' => $records_filtered,
    'data' => !empty($item_data) ? $item_data : [],
];

echo json_encode($response);
?>