<?php 
    require_once("connection.php");

    $sql = "UPDATE `branchlog` SET `gst_reset` = 0";
    $run_sql = mysqli_query($conn2,$sql);
?>