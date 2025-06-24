<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

if ($userrollpost == "Admin" || $userrollpost == "SuperAdmin" || $userrollpost == "SuperDuperAdmin" || $userrollpost == "Office") {
    if (isset($_GET) && isset($_GET["lrn"])) {

        // if (is_numeric($_GET["lrn"])) {
        //     $lrn = !empty($_GET["lrn"]) ? $_GET["lrn"] : "";
            // $time = !empty($_GET["time2"]) ? date_create($_GET["time2"]) : "";
            // $date = !empty($time) ? date_format($time, "Y-m-d H:i:s") : "";
        //     $query = "SELECT * FROM `transportz` WHERE `lrn` = '$lrn' AND `timestamp` = '$date'";
        // } else {
        //     $lr_with_branch = explode("-", $_GET["lrn"]);
        //     $branch = getbranch($lr_with_branch[0]);
        //     $query = "SELECT * FROM `transportz` WHERE `branch` = '$branch' AND `lrwithcode` = '" . $lr_with_branch[1] . "'";
        // }

        if(isset($_GET["lrn"]) && !empty($_GET["lrn"]))
        {
            $lrn = !empty($_GET["lrn"]) ? $_GET["lrn"] : "";
            $time = !empty($_GET["time2"]) ? date_create($_GET["time2"]) : "";
            $date = !empty($time) ? date_format($time, "Y-m-d H:i:s") : "";
        }

        $query = "SELECT * FROM `transportz` WHERE `lrwithcode` = '$lrn' AND `timestamp` = '$date'";
        $run_query = mysqli_query($conn2, $query);
        $data = mysqli_fetch_assoc($run_query);

        $PrintStatusDetails = !empty($data["status"]) ? $data["status"] : "";
        $creator = !empty($data["createby"]) ? $data["createby"] : "";
        $place = !empty($data["place"]) ? $data["place"] : "";
        $payment_type = !empty($data["type"]) ? $data["type"] : "";
        $lr_branch = !empty($data["branch"]) ? $data["branch"] : "";
        $lr_total = !empty($data["total"]) ? $data["total"] : "";

        if ($PrintStatusDetails == "close") {
            $PrintRecNameis = !empty($data['receiver']) ? $data['receiver'] : "";
            $PrintRecNumberis = !empty($data['recivernumber']) ? $data['recivernumber'] : "";
            $PrintDeliveryDateOLD = !empty($data['exitdate']) ? $data['exitdate'] : "";
            $PrintDeliveryDate = !empty($PrintDeliveryDateOLD) ? date_create_from_format("Y-m-d", $PrintDeliveryDateOLD)->format("d-m-Y") : "";
            $PrintCollectonsDetails = !empty($data) ? $data['collection'] : "";
            $PrintDeliverydoneBy = !empty($data['deliverby']) ? $data['deliverby'] : "";
        }

        if (isset($place)) {
            $pquery = "SELECT * FROM `branchlog` WHERE `branchwithcode` = '$place' LIMIT 1";
            $run_pquery = mysqli_query($conn2, $pquery);
            $place_data = mysqli_fetch_assoc($run_pquery);

            $address = !empty($place_data["address"]) ? $place_data["address"] : "";
            $mobile = !empty($place_data["phone"]) ? $place_data["phone"] : "";
        }

        if (empty($data) || empty($place_data)) {
            $find_lr = "આવો કોઈ રસીદ નંબર હજુ બૂક કરવા માં નથી આવ્યો.";
        }
    }

    if (isset($_POST) && !empty($_POST["lr_number"])) {

        $final_lr = preg_replace('/\s*-\s*/', '-', $_POST["lr_number"]);
        $query = "SELECT * FROM `transportz` WHERE `lrwithcode` = '$final_lr'";
        $run_query = mysqli_query($conn2, $query);
        $data = mysqli_fetch_assoc($run_query);
        $PrintStatusDetails = !empty($data["status"]) ? $data["status"] : "";
        $payment_type = !empty($data["type"]) ? $data["type"] : "";
        $creator = !empty($data['createby']) ? $data['createby'] : "";
        $place = !empty($data["place"]) ? $data["place"] : "";
        $lr_branch = !empty($data["branch"]) ? $data["branch"] : "";
        $lr_total = !empty($data["total"]) ? $data["total"] : "";

        $sql1 = "SELECT * FROM `runtime_additional_fields` WHERE `field_id` = '".$data['lrwithcode']."'";
        $run_sql1 = mysqli_query($conn2,$sql1);
        $additional = array();

        if(mysqli_num_rows($run_sql1) > 0)
        {
            while($row=mysqli_fetch_assoc($run_sql1))
            {
                $additional[$row['field_name']] = $row['field_value'];
            }
        }

        $sql2 = "SELECT * FROM `parcel_status` WHERE `lrwithcode` = '".$data['lrwithcode']."'";
        $run_sql2 = mysqli_query($conn2,$sql2);
        $sql2_data = array();

        if(mysqli_num_rows($run_sql2) > 0)
        {
            while($row=mysqli_fetch_assoc($run_sql2)){
                $sql2_data[] = $row;
            }
        }

        $total_scan = !empty($sql2_data) ? count($sql2_data) : 0;
        $sbranch = !empty($sql2_data["branch"]) ? $sql2_data["branch"] : "";
        $sdate = !empty($sql2_data["created_at"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $sql2_data["created_at"])->format('d-m-Y h:i:s A') : "";

        $total = !empty($additional) ? count($additional) : 0;

        if ($PrintStatusDetails == "close") {
            $PrintRecNameis = !empty($data['receiver']) ? $data['receiver'] : "";
            $PrintRecNumberis = !empty($data['recivernumber']) ? $data['recivernumber'] : "";
            $PrintDeliveryDateOLD = !empty($data['exitdate']) ? $data['exitdate'] : "";
            $PrintDeliveryDate = !empty($PrintDeliveryDateOLD) ? date_create_from_format("Y-m-d", $PrintDeliveryDateOLD)->format("d-m-Y") : "";
            $PrintCollectonsDetails = !empty($data) ? $data['collection'] : "";
            $PrintDeliverydoneBy = !empty($data['deliverby']) ? $data['deliverby'] : "";
        }

        if (isset($place)) {
            $pquery = "SELECT * FROM `branchlog` WHERE `branchwithcode` = '$place' LIMIT 1";
            $run_pquery = mysqli_query($conn2, $pquery);
            $place_data = mysqli_fetch_assoc($run_pquery);
            $address = !empty($place_data["address"]) ? $place_data["address"] : "";
            $mobile = !empty($place_data["phone"]) ? $place_data["phone"] : "";
        }

        if (empty($data) || empty($place_data)) {
            $find_lr = "આવો કોઈ રસીદ નંબર હજુ બૂક કરવા માં નથી આવ્યો.";
        }

    }
} else {
    $permission = "તમને આ રસીદ જોવા ની પરમીશન નથી, હેડ ઓફીસ માં વાત કરો.";
}


?>