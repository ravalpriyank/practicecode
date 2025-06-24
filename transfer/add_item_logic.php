<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $item_eng = !empty($_POST["itemen"]) ? $_POST["itemen"] : "";
    $item_guj = !empty($_POST["itemgu"]) ? $_POST["itemgu"] : "";

    $add_item_sql = "INSERT INTO itemdetail(`itemen`,`itemgu`)VALUES('$item_eng','$item_guj')";
    $run_add_item_sql = mysqli_query($conn2, $add_item_sql);

    if ($run_add_item_sql) {
        echo "Item Record Added Successfully";
    } else {
        echo "Something Went Wrong";
    }
}
?>