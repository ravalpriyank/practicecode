<?php
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

    $order_column_index = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 1;
    $order_columns = ["sno", "username", "branch", "roll", "date"];
    $order_column_name = $order_columns[$order_column_index];
    $order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "asc";

    if (!empty($search)) {
        $search_condition = "WHERE `sno` > 1 AND (`sno` LIKE '%$search%' OR `username` LIKE '%$search%' OR `branch` LIKE '%$search%' OR `roll` LIKE '%$search%' OR `date` LIKE '%$search%')";
    } else {
        $search_condition = "WHERE `roll` NOT IN ('SuperDuperAdmin')";
    }

    $query = "SELECT * FROM `users` $search_condition ORDER BY $order_column_name $order_dir LIMIT $start, $length";
    $run_query = mysqli_query($conn2, $query);

    $total_query = "SELECT COUNT(*) AS 'total' FROM `users` $search_condition";
    $run_total_query = mysqli_query($conn2, $total_query);
    $total_records = mysqli_fetch_assoc($run_total_query);

    $users_data = array();

    if (mysqli_num_rows($run_query) >= 1) {
        while ($raw = mysqli_fetch_assoc($run_query)) {
            $users_data[] = $raw;
        }
    }

    $response = [
        'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
        'recordsTotal' => !empty($total_records["total"]) ? $total_records["total"] : 0,
        'recordsFiltered' => !empty($total_records["total"]) ? $total_records["total"] : 0,
        'data' => !empty($users_data) ? $users_data : [],
    ];

    echo json_encode($response);
}

?>