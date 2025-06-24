<?php 
    require_once("connection.php");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST))
    {
        $serial = !empty($_POST["id"]) ? $_POST["id"] : "";
    }

    $sql = "UPDATE `users` SET `password` = '12345' WHERE `sno` = '$serial'";
    $run_sql = mysqli_query($conn2,$sql);

    if($run_sql)
    {
        echo "User Password Reset Successfully";
    }
    else
    {
        echo "Somethig went wrong";
    }
?>