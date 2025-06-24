<?php
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = !empty($_POST["id"]) ? $_POST["id"] : "";

    $query = "DELETE FROM `itemdetail` WHERE `sno` = '" . $id . "'";
    $run_query = mysqli_query($conn2, $query);

    if ($run_query) {
        echo "Item Record Deleted Successfully";
    } else {
        echo "Something Went Wrong";
    }
}
?>