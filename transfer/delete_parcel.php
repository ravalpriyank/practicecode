<?php
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $lrno = !empty($_POST["id"]) ? $_POST["id"] : "";
    $time = !empty($_POST["time"]) ? date_create($_POST["time"]) : "";
    $date = !empty($time) ? date_format($time, "Y-m-d H:i:s") : "";

    $query = "UPDATE `transportz` SET `status` = 'deleted' WHERE `lrn` = '$lrno' AND `timestamp` = '$date'";
    $run_query = mysqli_query($conn2, $query);

    if ($run_query) {
        echo "Parcel Details Deleted Successfully";
    } else {
        echo "Something Went Wrong";
    }
}
?>