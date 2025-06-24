<?php
require_once("connection.php");
require_once("main_const.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $search = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : "";

    $columns = ['sno', 'nameone'];
    $order_column = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
    $order_column = isset($columns[$order_column]) ? $columns[$order_column] : $columns[0];
    $order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';

    $search_condition = "";
    if (!empty($search)) {
        $search_condition = "AND `nameone` LIKE '%$search%'";
    }


    $branchnametoaccount = !empty($_POST["account_branch"]) ? $_POST["account_branch"] : "";
    $recordeddate = !empty($_POST["filter_date"]) ? $_POST["filter_date"] : "";
    $sampledate = str_replace(' ', '', $recordeddate);
    $datearray = explode("-", $sampledate);
    $extracharge = !empty($_POST['extra_charge']) ? $_POST['extra_charge'] : "";
    $i = 0;

    foreach ($datearray as $value) {
        ${'date' . $i} = str_replace("/", "-", $value);
        $i++;
    }

    // Date for Database Filter 
    $dateone = date_create_from_format("m-d-Y", $date0)->format("Y-m-d");
    $datetwo = date_create_from_format("m-d-Y", $date1)->format("Y-m-d");

    // Date for Print Titles 
    $newdateone = date_create_from_format("Y-m-d", $dateone)->format("d-m-Y");
    $newdatetwo = date_create_from_format("Y-m-d", $datetwo)->format("d-m-Y");

    if (!empty($dateone)) {
        $query = "SELECT `sno`,`nameone` FROM `transportz` WHERE  `branch` = '$branchnametoaccount'  AND `type` = 'Accounting Software' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' $search_condition ORDER BY $order_column $order_dir LIMIT $start , $length";
        $run_query = mysqli_query($conn2, $query);
        
        $records_total = mysqli_num_rows($run_query);

        $account_data = array();

        if (mysqli_num_rows($run_query) > 0) {
            while ($raw = mysqli_fetch_assoc($run_query)) {
                $account_data[] = $raw;
            }

        }

        $total_query = "SELECT COUNT(*) as 'total' FROM `transportz` WHERE  `branch` = '$branchnametoaccount'  AND `type` = 'Accounting Software' AND DATE(entrydate) BETWEEN '$dateone' AND '$datetwo' $search_condition";
        $run_total = mysqli_query($conn2, $total_query);
        $total_data = mysqli_fetch_assoc($run_total);

        $response = [
            'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
            'recordsTotal' => !empty($total_data["total"]) ? $total_data["total"] : 0,
            'recordsFiltered' => !empty($total_data["total"]) ? $total_data["total"] : 0,
            'data' => !empty($account_data) ? $account_data : "",
        ];

        echo json_encode($response);

    }

}
?>