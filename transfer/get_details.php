<?php
require_once("connection.php");
require_once("layouts/core/mainfunctions.php");
require_once("main_const.php");


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {

    $mobile = !empty($_POST["mobile"]) ? $_POST["mobile"] : "";

    $sql = "SELECT * FROM `transportz` WHERE `gst` = 'YES' AND ( `numone` = '$mobile' OR `numtwo` = '$mobile' ) ORDER BY `sno` DESC LIMIT 1";
    $run_sql = mysqli_query($conn2, $sql);
    $data = mysqli_fetch_assoc($run_sql);

    echo json_encode($data);
}
?>