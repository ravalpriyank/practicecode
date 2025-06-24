<?php

require_once("connection.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["generalsetting"])) {

        $sno = 1;

        if (isset($_POST['unpaid'])) {
            $bakiprint = $_POST['unpaid'];
        } else {
            $bakiprint = 'off';
        }

        if (isset($_POST['paid'])) {
            $jamaprint = $_POST['paid'];
        } else {
            $jamaprint = 'off';
        }

        if (isset($_POST['account'])) {
            $accountprint = $_POST['account'];
        } else {
            $accountprint = 'off';
        }

        if (isset($_POST['booking_print'])) {
            $dates = $_POST['booking_print'];
        } else {
            $dates = 'off';
        }

        $sql = "UPDATE `settingprint` SET `jama` = '$jamaprint' ,`baki` = '$bakiprint' ,`account` = '$accountprint' ,`dates` = '$dates' WHERE `settingprint`.`sno` = '$sno'";
        $run_sql = mysqli_query($conn2, $sql);

        if ($run_sql) { ?>
            <script>
                alert("Print Setting Updated Successfully");
            </script>
            <?php
        } else { ?>
            <script>
                alert("Something Went Wrong For Updating Print Setting");
            </script>
            <?php
        }

    }
}
?>