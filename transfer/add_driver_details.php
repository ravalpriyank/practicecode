<?php
require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $dname = !empty($_POST["driver_name"]) ? $_POST["driver_name"] : "";
    $dnumber = !empty($_POST["driver_number"]) ? $_POST["driver_number"] : "";

    if (isset($_POST["edit_permission"]) && isset($_POST["edit_id"])) {
        $edit = !empty($_POST["edit_permission"]) ? $_POST["edit_permission"] : "";
        $edit_id = !empty($_POST["edit_id"]) ? $_POST["edit_id"] : "";
    }

    if ($edit == "true") {
        $query = "UPDATE `thirdparties` SET `name` = '$dname' , `mobile` = '$dnumber' WHERE `sno` = '$edit_id'";
    } else {
        $query = "INSERT INTO `thirdparties`(`name`,`mobile`,`tstamp`) VALUES ('$dname' , '$dnumber' , CURRENT_DATE())";
    }

    $run_query = mysqli_query($conn2, $query);

    if ($run_query) {
        if ($edit == "true") {
            echo "Driver Detail Updated Successfully";
        } else {
            echo "Driver Detail Added Successfully";
        }
    } else {
        echo "Somthing Went Wrong To Adding Driver Detail";
    }
}
?>