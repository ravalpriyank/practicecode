<?php
require_once("layouts/core/mainconstants.php");
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $ddate = !empty($_POST["date"]) ? $_POST["date"] : date('d/m/Y');
    $place = !empty($_POST["place"]) ? $_POST["place"] : "";
    $start = isset($_POST['start']) ? $_POST['start'] : 0;
    $search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";
    $length = isset($_POST['length']) ? $_POST['length'] : 10;

    $sort_column = !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
    $sort_order = !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : "desc";

    $search_condition = " ";
    if (!empty($_POST["search"]["value"])) {
        $search_condition = "AND `lrn` LIKE '{$search}%'";
    }

    $query = "SELECT * FROM `transportz` WHERE branch = '$userbranch' AND `place` = '$place' AND `status` NOT IN ('deleted','close') AND `entrydate` = '$ddate' $search_condition ORDER BY $sort_column $sort_order LIMIT $start , $length";
    $run_query = mysqli_query($conn2, $query);
    $total_raw = mysqli_num_rows($run_query);

    $ddata = array();
    if (mysqli_num_rows($run_query) > 0) {
        while ($raw = mysqli_fetch_assoc($run_query)) {
            if ($raw["dstatus"] == "na") {
                $raw["dstatus"] = "At Stock";
            }
            $ddata[] = $raw;
        }
    }

    if (empty($ddata)) {
        $response = [
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
        ];
    } else {
        $response = [
            'recordsTotal' => !empty($total_raw) ? $total_raw : "",
            'recordsFiltered' => !empty($total_raw) ? $total_raw : "",
            'data' => !empty($ddata) ? $ddata : [],
        ];
    }

    echo json_encode($response);
}
?>