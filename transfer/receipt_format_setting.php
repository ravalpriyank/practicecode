<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {

    $receipt_format = !empty($_POST["receipt_format"]) ? $_POST["receipt_format"] : "";
    $booking_office = isset($_POST["book_office"]) && !empty($_POST["book_office"]) ? "on" : "off";
    $place_send = isset($_POST["place_send"]) && !empty($_POST["place_send"]) ? "on" : "off";
    $gst_detail = isset($_POST["gst_detail"]) && !empty($_POST["gst_detail"]) ? "on" : "off";
    $remarks = isset($_POST["remarks"]) && !empty($_POST["remarks"]) ? "on" : "off";
    $booking_time = isset($_POST["booking_time"]) && !empty($_POST["booking_time"]) ? "on" : "off";
    $print_time = isset($_POST["print_office"]) && !empty($_POST["print_office"]) ? "on" : "off";
    $print_barcode = isset($_POST["print_barcode"]) && !empty($_POST["print_barcode"]) ? "on" : "off";
    $heading = !empty($_POST["heading_font"]) ? $_POST["heading_font"]."px" : "";
    $font = !empty($_POST["body_font"]) ? $_POST["body_font"]."px" : "";
    $lrnSize = !empty($_POST["lr_font"]) ? $_POST["lr_font"]."px" : "";

    $sql2 = "UPDATE `settingprint` SET `format_changed` = 'yes' , `receipt_format` = '$receipt_format' , `booking_office` = '$booking_office' , `place_to_send` = '$place_send' , `gst_detail` = '$gst_detail' , `remarks` = '$remarks' , `booking_time` = '$booking_time' , `print_time` = '$print_time' , `print_barcode` = '$print_barcode' , `heading_font` = '$heading' , `receipt_font` = '$font' , `lr_font` = '$lrnSize' WHERE `sno` = 1";
    $run_sql2 = mysqli_query($conn2, $sql2);

    if ($run_sql2) {
        echo "<script>alert('Receipt Setting Updated Successfully');</script>";
    } else {
        echo "<script>alert('Something Went Wrong');</script>";
    }
}
?>