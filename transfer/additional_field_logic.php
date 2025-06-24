<?php
$select = "SELECT * FROM `branchlog` WHERE `name` = '$userbranch'";
$run_select = mysqli_query($conn2, $select);
$sdata = mysqli_fetch_assoc($run_select);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $total_add_field = !empty($_POST["field_name"]) ? count($_POST["field_name"]) : 0;

    if (isset($_POST["allow_action"]) && is_array($_POST["allow_action"])) {
        $count = !empty($_POST["allow_action"]) ? count($_POST["allow_action"]) : "";

        for ($i = 0; $i < $count; $i++) {
            if ($_POST["allow_action"][$i] == "off" && (isset($_POST["allow_action"][$i + 1]) && $_POST["allow_action"][$i + 1] == "on")) {
                $display[] = "on";
                $i++;
            } else {
                $display[] = "off";
            }
        }

        $final = !empty($display) ? $display : "";
    } else {
        $final = isset($_POST["allow_action"]) && !empty($_POST["allow_action"]) ? $_POST["allow_action"] : "off";
    }

    $fields = !empty($_POST["field_name"]) ? $_POST["field_name"] : "";
    $displays = !empty($_POST["display"]) ? $_POST["display"] : "";
    $types = !empty($_POST["type"]) ? $_POST["type"] : "";
    $values = !empty($_POST["field_value"]) ? $_POST["field_value"] : "";
    $relations = !empty($_POST["relation"]) ? $_POST["relation"] : "";

    if (isset($_POST["allow_total"]) && is_array($_POST["allow_total"])) {
        $count = !empty($_POST["allow_total"]) ? count($_POST["allow_total"]) : "";

        for ($i = 0; $i < $count; $i++) {
            if ($_POST["allow_total"][$i] == "off" && (isset($_POST["allow_total"][$i + 1]) && $_POST["allow_total"][$i + 1] == "on")) {
                $disp[] = "on";
                $i++;
            } else {
                $disp[] = "off";
            }
        }

        $total_final = !empty($disp) ? $disp : "";
    } else {
        $total_final = isset($_POST["allow_total"]) && !empty($_POST["allow_total"]) ? $_POST["allow_total"] : "off";
    }

    if ($total_fields == 0) {
        for ($i = 0; $i < $total_add_field; $i++) {
            if ($types[$i] == "text") {
                $total_final[$i] == "off";
            }

            $insert_sql = "INSERT INTO additional_fields(`display`,`field_name`,`display_field`,`field_type`,`field_value`,`relation`,`total`,`branch`)VALUES('" . $final[$i] . "' , '" . $fields[$i] . "' , '" . $displays[$i] . "' , '" . $types[$i] . "' , '" . $values[$i] . "' , '" . $relations[$i] . "' , '" . $total_final[$i] . "' , '$userbranch')";
            $run_insert = mysqli_query($conn2, $insert_sql);
        }

        if ($run_insert) {
            echo "<script>alert('Additional Fields Set Successfully');</script>";
        } else {
            echo "<script>alert('Something Went Wrong');</script>";
        }
    } else {
        $tableName = 'additional_fields';
        $truncateQuery = "TRUNCATE TABLE $tableName";
        $run_truncate = mysqli_query($conn2, $truncateQuery);

        for ($i = 0; $i < $total_add_field; $i++) {
            if ($types[$i] == "text") {
                $total_final[$i] = "off";
            }

            $update_sql = "INSERT INTO additional_fields(`display`,`field_name`,`display_field`,`field_type`,`field_value`,`relation`,`total`,`branch`)VALUES('" . $final[$i] . "' , '" . $fields[$i] . "' , '" . $displays[$i] . "' , '" . $types[$i] . "' , '" . $values[$i] . "' , '" . $relations[$i] . "' , '" . $total_final[$i] . "' , '$userbranch')";


            $run_update = mysqli_query($conn2, $update_sql);
        }

        if ($run_update) {
            echo "<script>alert('Additional Fields Updated Successfully');</script>";
        } else {
            echo "<script>alert('Something Went Wrong');</script>";
        }
    }

}
?>