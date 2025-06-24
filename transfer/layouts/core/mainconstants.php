<?php

date_default_timezone_set('Asia/Kolkata');
require_once("connection.php");

// Company Details 
$snoid = 1;
$companytable = "SELECT * FROM `settingz` WHERE sno = '$snoid' LIMIT 1";
$companytableresult = mysqli_query($conn2, $companytable);
$companydetails = mysqli_fetch_assoc($companytableresult);
$companynamef = !empty($companydetails['company']) ? $companydetails['company'] : "";
$companyheadf = !empty($companydetails['head']) ? $companydetails['head'] : "";
$companyheadcityf = !empty($companydetails['city']) ? $companydetails['city'] : "";
$companylogof = !empty($companydetails['logo']) ? $companydetails['logo'] : "assets/images/favicon.ico";
$companylanguage = !empty($companydetails['language']) ? $companydetails['language'] : "";
$currentuser = $_SESSION['username'];

$printsettingtable = "SELECT * FROM `settingprint` WHERE sno = '$snoid' LIMIT 1";
$printsettingtableresult = mysqli_query($conn2, $printsettingtable);
$printsettingdetails = mysqli_fetch_assoc($printsettingtableresult);
$printsettingbaki = !empty($printsettingdetails['baki']) ? $printsettingdetails['baki'] : "";
$printsettingjama = !empty($printsettingdetails['jama']) ? $printsettingdetails['jama'] : "";
$printsettingaccount = !empty($printsettingdetails['account']) ? $printsettingdetails['account'] : "";
$printtimeonrasid = !empty($printsettingdetails['dates']) ? $printsettingdetails['dates'] : "";
$printreceiptformat = !empty($printsettingdetails['receipt_format']) ? $printsettingdetails['receipt_format'] : "";

// User Details 
$branchfind = mysqli_query($conn2, "SELECT * FROM `users`");
$userbranch = "";
while ($row = mysqli_fetch_assoc($branchfind)) {
    if ($_SESSION['username'] == $row['username']) {
        $userbranch = $row['branch'];
        $userrollpost = $row['roll'];
        $currentloggedinuser = $row['username'];
    }

}

//total additional feild
$total_add_sql = "SELECT * FROM `additional_fields` WHERE `display` = 'on'";
$run_total_sql = mysqli_query($conn2, $total_add_sql);
$final_count = mysqli_num_rows($run_total_sql);
$code_sql = "SELECT * FROM `branchlog` WHERE `name` = '$userbranch'";
$run_code_sql = mysqli_query($conn2, $code_sql);
$branch_code_data = mysqli_fetch_assoc($run_code_sql);

$b_sql = "SELECT * FROM `branchlog`";
$run_bsql = mysqli_query($conn2, $b_sql);
$unique_branch = array();
$CityBranch = array();

if (mysqli_num_rows($run_bsql) > 0) {
    while ($row = mysqli_fetch_assoc($run_bsql)) {
        if ($row["name"] == $userbranch) {
            $currentUserCity = $row["city"];
        }

        if ($userrollpost == "CityAdmin" && $row["city"] == $currentUserCity) {
            $CityBranch[] = $row["branchwithcode"];
        } else {
            $unique_branch[] = $row["name"];
        }
    }
}


$additional_sql = "SELECT * FROM `additional_fields` WHERE `branch` = '$userbranch'";
$run_additional_sql = mysqli_query($conn2, $additional_sql);
$additional_data = mysqli_fetch_assoc($run_additional_sql);
$total_fields = isset($additional_data["field_name"]) ? count(explode(",", $additional_data["field_name"])) : 0;
$extra = 0;
$on_off = !empty($additional_data["display"]) ? explode(" , ", $additional_data["display"]) : [];
$field_values = !empty($additional_data["field_value"]) ? explode(" , ", $additional_data["field_value"]) : [];
$field_relations = !empty($additional_data["relation"]) ? explode(" , ", $additional_data["relation"]) : [];

for ($i = 0; $i < $total_fields; $i++) {
    if ($on_off[$i] == "on" && $field_relations[$i] == "total") {
        $value = !empty($field_values[$i]) ? $field_values[$i] : 0;
        $extra = $extra + $value;
    }
}

// User Branch Setting, Position and City Find
$usercityfind = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE `name` = '$userbranch'");
$usercity = "";
while ($row = mysqli_fetch_array($usercityfind)) {
    $usercity = !empty($row['city']) ? $row['city'] : "";
    $SystemTopMargin = !empty($row['margintop']) ? $row['margintop'] : "";
    $SystemYScale = !empty($row['yscales']) ? $row['yscales'] : "";
    $SRLanguage = !empty($row['srlanguage']) ? $row['srlanguage'] : "";
    $softwarePrintStyle = !empty($row['printstyle']) ? $row['printstyle'] : "";
    $softwarePrintMethod = !empty($row['printmethod']) ? $row['printmethod'] : "";
    $userbranchishead = !empty($row['ishead']) ? $row['ishead'] : "";
    $userbranchcolor = !empty($row['titlecolor']) ? $row['titlecolor'] : "";
    $printbranchheading = !empty($row['branchhead']) ? $row['branchhead'] : "";
    $currentbranchnumber = !empty($row['phone']) ? $row['phone'] : "";
}

$branchsql = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE city NOT IN ('$usercity')");
while ($row = mysqli_fetch_array($branchsql)) {

    $branchnamesf[] = !empty($row["branchwithcode"]) ? $row["branchwithcode"] : "";
    $unique_city[] = !empty($row["city"]) ? $row["city"] : "";
}

$branchnamesf = !empty($branchnamesf) ? array_unique($branchnamesf) : [];
$unique_city = !empty($unique_city) ? array_unique($unique_city) : [];

$allbranchsql = mysqli_query($conn2, "SELECT * FROM `branchlog`");
while ($row = mysqli_fetch_array($allbranchsql)) {
    if ($row["name"] == $userbranch) {
        $branchwithcode = !empty($row["branchwithcode"]) ? $row["branchwithcode"] : "";
    }
    $allbranchlist[] = !empty($row["branchwithcode"]) ? $row["branchwithcode"] : "";
    $cityList[] = !empty($row["city"]) ? $row["city"] : "";
}

$cityList = !empty($cityList) ? array_unique($cityList) : [];
$allbranchlist = !empty($allbranchlist) ? array_unique($allbranchlist) : [];

$branchcolleguessql = mysqli_query($conn2, "SELECT * FROM `users` WHERE branch = '$userbranch' AND roll NOT IN ('SuperDuperAdmin')");
while ($row = mysqli_fetch_array($branchcolleguessql)) {
    $branchcollegues[] = !empty($row["username"]) ? $row["username"] : [];
}
// Find Min and Max Number 
$minmaxnum = "SELECT * FROM `branchlog` WHERE name = '$userbranch' ORDER BY name DESC LIMIT 1";
$minmaxnumresult = mysqli_query($conn2, $minmaxnum);
$minmaxnumrow = mysqli_fetch_assoc($minmaxnumresult);
$minnumberhere = !empty($minmaxnumrow['minnum']) ? $minmaxnumrow['minnum'] : "";
$maxnumberhere = !empty($minmaxnumrow['maxnum']) ? $minmaxnumrow['maxnum'] : "";
$deadlinenumber = !empty($minnumberhere && $maxnumberhere) ? intval(($maxnumberhere - $minnumberhere + 1) * 3.5) : "";


//Delete Records on Deadline
$deadlinehelper = "SELECT * FROM `transportz` WHERE branch = '$userbranch' ORDER BY lrn";
$deadlinehelperresult = mysqli_query($conn2, $deadlinehelper);
$totaldeadrow = mysqli_num_rows($deadlinehelperresult);
if ($totaldeadrow > $deadlinenumber) {
    $cleaningzombies = "DELETE FROM `transportz` WHERE branch = '$userbranch' ORDER BY sno LIMIT 2";
    $bulldozer = mysqli_query($conn2, $cleaningzombies);
}

$formatActions = [
    "format1" => "format1_print.php",
    "format2" => "format2_print.php",
    "format3" => "format3_print.php",
    "format4" => "format4_print.php",
    "format5" => "format5_print.php",
];

$final_format = isset($formatActions[$printreceiptformat]) ? $formatActions[$printreceiptformat] : "format6_print.php";
?>