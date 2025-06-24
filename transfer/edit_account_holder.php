<?php

require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $correct_name = !empty($_POST["correct_name"]) ? $_POST["correct_name"] : "";
    $incorrect_name = !empty($_POST["incorrect_name"]) ? $_POST["incorrect_name"] : "";

    $query = "UPDATE `transportz` SET `nameone` = '$correct_name' WHERE `transportz`.`nameone` = '$incorrect_name' AND `transportz`.`type` = 'Accounting Software'";
    $run_query = mysqli_query($conn2, $query);

    if ($run_query) {
        echo "Account Holder Name Updated Successfully";
    } else {
        echo "Something Went Wrong";
    }
}
?>