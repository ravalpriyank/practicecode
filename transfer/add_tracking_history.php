<?php 
    require_once("connection.php");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST))
    {
        $serial_no = !empty($_POST["serial_number"]) ? $_POST["serial_number"] : "";
        $branch = !empty($_POST["branch"]) ? $_POST["branch"] : "";

        $sql1 = "SELECT * FROM `transportz` WHERE `sno` = '".$serial_no."'";
        $run_sql1 = mysqli_query($conn2,$sql1);
        $data = mysqli_fetch_assoc($run_sql1);

        $lrn = !empty($data["lrn"]) ? $data["lrn"] : "";
        $lrwithcode = !empty($data["lrwithcode"]) ? $data["lrwithcode"] : "";
        $sno = !empty($data["sno"]) ? $data["sno"] : "";

        if(!empty($data))
        {
            $sql2 = "INSERT INTO parcel_status(`branch`,`lrn`,`lrwithcode`,`serial_no`)VALUES('$branch','$lrn','$lrwithcode','$sno')";
            $run_sql2 = mysqli_query($conn2,$sql2);
        }
    }
?>