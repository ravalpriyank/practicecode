<?php

require_once("connection.php");

$search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

if (!empty($search)) {
    $search_condition = "AND `sno` LIKE '%$search%' OR `nameone` LIKE '%$search%'";
} else {
    $search_condition = "";
}
$query = "SELECT * FROM `transportz` WHERE `type` = 'Accounting Software' $search_condition LIMIT $start, $length";
$run_query = mysqli_query($conn2, $query);

$account_data = array();

if (mysqli_num_rows($run_query) >= 1) {
    while ($raw = mysqli_fetch_assoc($run_query)) {
        $account_data[] = $raw;
    }
}

$unique_data = array();
$seen_nameone = array();

foreach ($account_data as $entry) {
    $nameone = $entry['nameone'];
    if (!isset($seen_nameone[$nameone])) {
        $unique_data[] = array('sno' => $entry['sno'], 'nameone' => $nameone);
        $seen_nameone[$nameone] = true;
    }
}

$total_records = count($unique_data);

$response = [
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
    'recordsTotal' => !empty($total_records) ? $total_records : 0,
    'recordsFiltered' => !empty($total_records) ? $total_records : 0,
    'data' => !empty($unique_data) ? $unique_data : [],
];

echo json_encode($response);

?>