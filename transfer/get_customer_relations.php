<?php
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = !empty($_POST["cust_id"]) ? $_POST["cust_id"] : "";

    if (is_numeric($cust_id)) {
        $rid_sql = "SELECT * FROM `customer_relation` WHERE `sno` = '$cust_id'";
    } else {
        $rid_sql = "SELECT * FROM `customer_relation` WHERE `rid` = '$cust_id'";
    }

    $run_cid = mysqli_query($conn2, $rid_sql);
    $cust_data = mysqli_fetch_assoc($run_cid);

    header('Content-Type: application/json');
    echo json_encode($cust_data);
}

?>