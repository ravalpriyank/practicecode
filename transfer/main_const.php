<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("connection.php");
$snoid = 1;
$printsettingtable = "SELECT * FROM `settingprint` WHERE sno = '$snoid' LIMIT 1";
$printsettingtableresult = mysqli_query($conn2, $printsettingtable);
$printsettingdetails = mysqli_fetch_assoc($printsettingtableresult);
$printsettingbaki = !empty($printsettingdetails['baki']) ? $printsettingdetails['baki'] : "";
$printsettingjama = !empty($printsettingdetails['jama']) ? $printsettingdetails['jama'] : "";
$printsettingaccount = !empty($printsettingdetails['account']) ? $printsettingdetails['account'] : "";
$printtimeonrasid = !empty($printsettingdetails['dates']) ? $printsettingdetails['dates'] : "";

//=========================

$query = "SELECT * FROM `users`";
$run_query = mysqli_query($conn2, $query);
$user_branch = "";
$current_user = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";

if (mysqli_num_rows($run_query) > 0) {
    while ($raw = mysqli_fetch_assoc($run_query)) {
        if ($current_user == $raw["username"]) {
            $user_branch = !empty($raw["branch"]) ? $raw["branch"] : "";
            $userrollpost = !empty($raw['roll']) ? $raw['roll'] : "";
            $currentloggedinuser = !empty($raw['username']) ? $raw['username'] : "";
        }
    }
}
$code_sql = "SELECT * FROM `branchlog` WHERE `name` = '$user_branch'";
$run_code_sql = mysqli_query($conn2, $code_sql);
$branch_code_data = mysqli_fetch_assoc($run_code_sql);
//===================================

// User Branch Setting, Position and City Find
$usercityfind = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE name = '$user_branch'");
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

//===============================

//get all branches
$allbranchsql = mysqli_query($conn2, "SELECT * FROM `branchlog`");
while ($row = mysqli_fetch_array($allbranchsql)) {

    $allbranchlist[] = $row["branchwithcode"];
    if ($row["name"] == $user_branch) {
        $branchwithcode = !empty($row["branchwithcode"]) ? $row["branchwithcode"] : "";
    }
    $defaultcitylist[] = !empty($row["city"]) ? $row["city"] : "";
    $allcitylist = !empty($defaultcitylist) ? array_unique(array_map('strtolower', $defaultcitylist)) : "";
}

//===============================

// Company Details 
$companytable = "SELECT * FROM `settingz` WHERE sno = '$snoid' LIMIT 1";
$companytableresult = mysqli_query($conn2, $companytable);
$companydetails = mysqli_fetch_assoc($companytableresult);
$companynamef = !empty($companydetails['company']) ? $companydetails['company'] : "";
$companyheadf = !empty($companydetails['head']) ? $companydetails['head'] : "";
$companyheadcityf = !empty($companydetails['city']) ? $companydetails['city'] : "";
$companylogof = !empty($companydetails['logo']) ? $companydetails['logo'] : "assets/images/favicon.ico";
$companylanguage = !empty($companydetails['language']) ? $companydetails['language'] : "";
$currentuser = isset($_SESSION['username']) ? $_SESSION['username'] : "";

//====================================

$branchsql = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE city NOT IN ('$usercity')");
while ($row = mysqli_fetch_array($branchsql)) {
    $branchnamesf[] = !empty($row["branchwithcode"]) ? $row["branchwithcode"] : "";
}
//==================================

$usercityfind = mysqli_query($conn2, "SELECT * FROM `branchlog` WHERE name = '$user_branch'");
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

?>