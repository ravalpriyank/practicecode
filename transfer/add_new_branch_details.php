<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    
    if (isset($_POST["edit_branch"]) && $_POST["edit_branch"] == "true") {
        $branch_name = !empty($_POST["branch_name"]) ? $_POST["branch_name"] : "";
        $branch_sno = !empty($_POST["branch_id"]) ? $_POST["branch_id"] : "";
        $title_color = !empty($_POST["title_color"]) ? $_POST["title_color"] : "";
        $branch_code = !empty($_POST["branch_code"]) ? strtoupper($_POST["branch_code"]) : "";
        $gst_branch_code = !empty($_POST["gst_branch_code"]) ? $_POST["gst_branch_code"] : "";
        $branch_state = !empty($_POST["branch_state"]) ? $_POST["branch_state"] : "";
        $branch_city = !empty($_POST["branch_city"]) ? str_replace(' ', '', $_POST["branch_city"]) : "";
        $min_lr = !empty($_POST["minimum_lr"]) ? $_POST["minimum_lr"] : "";
        $max_lr = !empty($_POST["maximum_lr"]) ? $_POST["maximum_lr"] : "";
        $branch_mobile = !empty($_POST["branch_mobile"]) ? $_POST["branch_mobile"] : "";
        $is_branch_head = !empty($_POST["is_head"]) ? $_POST["is_head"] : "";
        $branch_heading = !empty($_POST["branch_heading"]) ? $_POST["branch_heading"] : "";
        $branch_address = !empty($_POST["branch_address"]) ? $_POST["branch_address"] : "";
        $top_margin = !empty($_POST["top_margin"]) ? $_POST["top_margin"] : "";
        $scale_ratio = !empty($_POST["scale_ratio"]) ? number_format(intval($_POST["scale_ratio"]) / 100, 2) : "";
        $codebuild = $branch_code;
        $codebuild .= "-";
        $codebuild .= $branch_name;

        $sql = "UPDATE `branchlog` SET `name` = '$branch_name' , `code` = '$branch_code' , `gst_code` = '$gst_branch_code' , `minnum` = '$min_lr' , `maxnum` = '$max_lr' , `state` = '$branch_state' , `city` = '$branch_city' , `phone` = '$branch_mobile' , `address` = '$branch_address' , `ishead` = '$is_branch_head' , `margintop` = '$top_margin' , `yscales` = '$scale_ratio' , `titlecolor` = '$title_color' , `branchwithcode` = '$codebuild' , `branchhead` = '$branch_heading' WHERE `sno` = '$branch_sno'";
        $run_sql = mysqli_query($conn2, $sql);

        if ($run_sql) {
            echo "Branch Details Updated Successfully";
        } else {
            echo "Something Went Wrong";
        }
    } else {
        $branch_name = !empty($_POST["branch_name"]) ? $_POST["branch_name"] : "";
        $title_color = !empty($_POST["title_color"]) ? $_POST["title_color"] : "";
        $branch_code = !empty($_POST["branch_code"]) ? strtoupper($_POST["branch_code"]) : "";
        $gst_branch_code = !empty($_POST["gst_branch_code"]) ? strtoupper($_POST["gst_branch_code"]) : "";
        $branch_state = !empty($_POST["branch_state"]) ? $_POST["branch_state"] : "";
        $branch_city = !empty($_POST["branch_city"]) ? str_replace(' ', '', $_POST["branch_city"]) : "";
        $min_lr = !empty($_POST["minimum_lr"]) ? $_POST["minimum_lr"] : "";
        $max_lr = !empty($_POST["maximum_lr"]) ? $_POST["maximum_lr"] : "";
        $branch_mobile = !empty($_POST["branch_mobile"]) ? $_POST["branch_mobile"] : "";
        $is_branch_head = !empty($_POST["is_head"]) ? $_POST["is_head"] : "";
        $branch_heading = !empty($_POST["branch_heading"]) ? $_POST["branch_heading"] : "";
        $branch_address = !empty($_POST["branch_address"]) ? $_POST["branch_address"] : "";
        $top_margin = !empty($_POST["top_margin"]) ? $_POST["top_margin"] : "";
        $scale_ratio = !empty($_POST["scale_ratio"]) ? number_format(intval($_POST["scale_ratio"]) / 100, 2) : "";
        $codebuild = $branch_code;
        $codebuild .= "-";
        $codebuild .= $branch_name;

        $find = "SELECT * FROM `branchlog` WHERE `name` = '$branch_name'";
        $run_find = mysqli_query($conn2, $find);

        if (mysqli_num_rows($run_find) == 1) {
            echo "Branch Is Already Exists ! Please Add Another Branch Name";
        } else {
            if ($branch_code != $gst_branch_code) {
                if (isset($_POST["first_branch"]) && $_POST["first_branch"] == "true") {
                    $insert_sql = "INSERT INTO `branchlog`(`name`, `code`, `gst_code` , `minnum`, `maxnum`, `state` , `city`, `phone`, `address`, `branchwithcode` ,`ishead`, `margintop` , `yscales` , `branchhead` ) VALUES ('$branch_name', '$branch_code', '$gst_branch_code' , '$min_lr','$max_lr','$branch_state','$branch_city', '$branch_mobile', '$branch_address', '$codebuild' , '$is_branch_head' , '$top_margin' , '$scale_ratio' , '$branch_heading')";

                    $update_sql = "UPDATE `users` SET `branch` = '$branch_name' WHERE `username` = '" . $_SESSION["username"] . "'";
                    $run_usql = mysqli_query($conn2, $update_sql);

                    $uquery = "UPDATE `parcel_companies` SET `isBranch` = 'yes' WHERE `username` = '" . $_SESSION["username"] . "'";
                    $run_uquery = mysqli_query($conn1, $uquery);
                } else {
                    $insert_sql = "INSERT INTO `branchlog`(`name`, `code`, `gst_code` , `minnum`, `maxnum`, `state` , `city`, `phone`, `address`, `branchwithcode` , `ishead`, `margintop` , `yscales` , `branchhead`) VALUES ('$branch_name', '$branch_code', '$gst_branch_code' , '$min_lr','$max_lr','$branch_state','$branch_city', '$branch_mobile', '$branch_address', '$codebuild', '$is_branch_head' , '$top_margin' , '$scale_ratio' , '$branch_heading')";
                }

                $run_insert_sql = mysqli_query($conn2, $insert_sql);

                if ($run_insert_sql) {
                    echo "Branch Created Successfully";
                } else {
                    echo "Something Went Wrong";
                }
            } else {
                echo "GST Branch Code Must Be Different From Branch Code";
            }
        }
    }
}
?>