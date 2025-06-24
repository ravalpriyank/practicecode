<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $option = !empty($_POST["option"]) ? $_POST["option"] : "";
    $date = DATE('Y-m-d');
    $yesterday = strtotime("-1 day");
    $yesterday = date("Y-m-d", $yesterday);

    $previous_week = strtotime("-1 week +1 day");
    $start_week = strtotime("last monday midnight", $previous_week);
    $end_week = strtotime("next sunday", $start_week);

    $start_week = date("Y-m-d", $start_week);
    $end_week = date("Y-m-d", $end_week);

    $start_last_month = strtotime("first day of last month midnight");
    $end_last_month = strtotime("last day of last month 23:59:59");

    if ($option == "Today") {
        $query = "SELECT * FROM `transportz` WHERE `status` = 'close' AND `exitdate` = '$date'";
    } elseif ($option == "Yesterday") {
        $query = "SELECT * FROM `transportz` WHERE `status` = 'close' AND `exitdate` = '$yesterday'";
    } elseif ($option == "Last Week") {
        $query = "SELECT * FROM `transportz` WHERE `status` = 'close' AND `exitdate` BETWEEN '$start_week' AND '$end_week'";
    } elseif ($option == "Last Month") {
        $query = "SELECT * FROM `transportz` WHERE `status` = 'close' AND `exitdate` BETWEEN '$start_last_month' AND '$end_last_month'";
    }

    $run_query = mysqli_query($conn2, $query);

    $delivery_data1 = array();

    if (mysqli_num_rows($run_query) > 0) {
        while ($row = mysqli_fetch_assoc($run_query)) {
            $delivery_data1[] = $row;
        }
    }

}
?>