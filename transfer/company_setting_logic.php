<?php
require_once("connection.php");
require_once("layouts/core/mainconstants.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["setting_update"])) {
        $sno = 1;
        $branchtobeupdate = $userbranch;
        $company = !empty($_POST["company"]) ? $_POST["company"] : "";
        $head_office = !empty($_POST["head_office"]) ? $_POST["head_office"] : "";
        $head_city = !empty($_POST["main_city"]) ? $_POST["main_city"] : "";
        $company_logo = !empty($_POST["logo"]) ? $_POST["logo"] : "";

        $query = "UPDATE `settingz` SET `company` = '$company' ,`head` = '$head_office' ,`city` = '$head_city'  , `logo` = '$company_logo' WHERE `settingz`.`sno` = '$sno'";
        $run_query = mysqli_query($conn2, $query);
        if ($run_query) {
            echo "Company Setting Updated Successfully";
        } else {
            echo "We could not update setting successfully";
        }

    }
}
?>