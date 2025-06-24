<?php
require_once("connection.php");
require_once("layouts/core/mainconstants.php");

if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin") || ($userrollpost == "Office")) {

    if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $vehicle_no = !empty($_POST["vehicle_number"]) ? $_POST["vehicle_number"] : "";
        $entry_date = !empty($_POST["entry_date"]) ? $_POST["entry_date"] : "";
        $date = DateTime::createFromFormat('d/m/Y', $entry_date);
        if ($date === false) {
            $new_edate = date('Y/m/d');
        } else {
            $new_edate = $date->format('Y/m/d');
        }

        $dispatch_date = !empty($_POST["dispatch_date"]) ? $_POST["dispatch_date"] : "";

        // if (!empty($dispatch_date)) {
        //     $date_parts = explode('-', $dispatch_date);
        //     if (count($date_parts) == 3) {
        //         $final_dispatch = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
        //     }
        // }

        $urecords = !empty($_POST["records"]) ? $_POST["records"] : "";
        foreach ($urecords as $lrn) {
            $query = "UPDATE `transportz` SET `vnumber` = '$vehicle_no' , `ddate` = '$dispatch_date' ,`dstatus` = 'Dispatched' WHERE branch = '$userbranch' AND  DATE(entrydate) = '$new_edate' AND `lrn` = '$lrn.'";
            $run_query = mysqli_query($conn2, $query);
        }

        if ($run_query) {
            echo "Dispatched Done Successfully";
        } else {
            echo "We Could Not Update The LR Successfully";
            die();
        }


    }
}
?>