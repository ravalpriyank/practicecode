<?php
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = !empty($_POST["id"]) ? $_POST["id"] : "";

    $query = "DELETE FROM `customer_relation` WHERE `sno` = '" . $id . "'";
    $run_query = mysqli_query($conn2, $query);

    if ($run_query) {
        echo "Customer Record Deleted Successfully";
    } else {
        echo "Something Went Wrong";
    }
}
?>