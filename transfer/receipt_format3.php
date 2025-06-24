<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("receipt_format_setting.php");

$sql1 = "SELECT * FROM `settingprint` WHERE `sno` = 1";
$run_sql1 = mysqli_query($conn2, $sql1);
$sql1_data = mysqli_fetch_assoc($run_sql1);

$sql2 = "SELECT * FROM `additional_fields` WHERE `branch` = '$userbranch'";
$run_sql2 = mysqli_query($conn2, $sql2);
$data = mysqli_fetch_assoc($run_sql2);
$total_fields = isset($data["field_name"]) ? count(explode(",", $data["field_name"])) : 0;

if (preg_match('/\d+/', $sql1_data["heading_font"], $matches)) {
    $heading_font = $matches[0];
}
if (preg_match('/\d+/', $sql1_data["receipt_font"], $matches)) {
    $receipt_font = $matches[0];
}
if (preg_match('/\d+/', $sql1_data["lr_font"], $matches)) {
    $lr_font = $matches[0];
}
?>

<head>
    <title><?php echo $language["print"] . $language["setting"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="./assets/css/all_receipt.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <script scr="assets/js/custome.js"></script>
    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>

<?php require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php'); ?>

<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content border mt-2 pb-1">
            <div class="receipt">
                <form action="#" method="POST">
                    <input type="hidden" name="receipt_format" value="format3">
                    <div class="row g-4 p-0">
                        <div class="col-xl-3 col-lg-3 mt-0 p-0 col-12">
                            <div class="side_bar p-2">
                                <div class="receipt_input_section">
                                    <div class="grup">
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between pt-1 mt-1">
                                            <h5 for="" class="m-0"><?php echo $language['booking_office']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" name="book_office"
                                                    id="book_office3" <?php echo !empty($sql1_data["booking_office"]) && $sql1_data["booking_office"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center  justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['Place_send2']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" name="place_send"
                                                    id="place_send3" <?php echo !empty($sql1_data["place_to_send"]) && $sql1_data["place_to_send"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center  justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['gst_detail']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" id="gst_details_print3"
                                                    name="gst_detail" <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['remark']; ?> : </h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" id="remark_print3"
                                                    name="remarks" <?php echo !empty($sql1_data["remarks"]) && $sql1_data["remarks"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['booking_time']; ?></h5>
                                            <div class="button r <?php echo $sql1_data["dates"] == "off" ? "bookin_disable" : ""; ?>"
                                                id="button-1">
                                                <input type="checkbox" class="checkbox" name="booking_time"
                                                    id="booking_time3" <?php echo !empty($sql1_data["booking_time"]) && $sql1_data["booking_time"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['print_time']; ?></h5>
                                            <div class="button r <?php echo $sql1_data["dates"] == "off" ? "bookin_disable" : ""; ?>"
                                                id="button-1">
                                                <input type="checkbox" class="checkbox" id="print_tm3"
                                                    name="print_office" <?php echo !empty($sql1_data["print_time"]) && $sql1_data["print_time"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div class="form_grups mt-4">
                                            <h5 for=""><?php echo $language['heading_font']; ?></h5>
                                            <!-- <select class="form-select headingSize" aria-label="Default select example"
                                                name="headingSize">
                                                <option value="small" <?php echo $sql1_data["heading_font"] == "small" ? "selected" : ""; ?>>Small</option>
                                                <option value="medium" <?php echo $sql1_data["heading_font"] == "medium" ? "selected" : ""; ?>>
                                                    Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["heading_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["heading_font"] == "x-large" ? "selected" : ""; ?>>
                                                    Extra Large</option>
                                            </select> -->
                                            <input type="number" class="form-control" name="heading_font" id="heading_font" value="<?php echo $heading_font; ?>">
                                        </div>
                                        <div class="form_grups mt-4">
                                            <h5 for=""><?php echo $language['detail_font']; ?></h5>
                                            <!-- <select class="form-select fontSize" aria-label="Default select example"
                                                name="fontSize">
                                                <option value="small" <?php echo $sql1_data["receipt_font"] == "small" ? "selected" : ""; ?>>Small</option>
                                                <option value="medium" <?php echo $sql1_data["receipt_font"] == "medium" ? "selected" : ""; ?>>
                                                    Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["receipt_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["receipt_font"] == "x-large" ? "selected" : ""; ?>>
                                                    Extra Large</option>
                                            </select> -->
                                            <input type="number" class="form-control" name="body_font" id="body_font" value="<?php echo $receipt_font; ?>">
                                        </div>
                                        <div class="form_grups mt-4 mb-3">
                                            <h5 for=""><?php echo $language['lr_font']; ?></h5>
                                            <!-- <select class="form-select lrnSize" aria-label="Default select example"
                                                name="lrnSize">
                                                <option value="small" <?php echo $sql1_data["lr_font"] == "small" ? "selected" : ""; ?>>Small</option>
                                                <option value="medium" <?php echo $sql1_data["lr_font"] == "medium" ? "selected" : ""; ?>>Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["lr_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["lr_font"] == "x-large" ? "selected" : ""; ?>>Extra Large</option>
                                            </select> -->
                                            <input type="number" class="form-control" name="lr_font" id="lr_font" value="<?php echo $lr_font; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-9 col-12 m-0">
                            <div class="two_receipt d-flex gap-2 mt-3">
                                <div class="left_receipt w-50">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="p-1" colspan="3"><strong
                                                    class="heading-style book_print3 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">બુકિંગ
                                                    ઓફિસ : </strong><span
                                                    class="receipt-body-style book_print3 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">મુંબઇ
                                                    / </span><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">ફોન
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9988776655</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-1"><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મોકલનાર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">રવિકુમાર
                                                </span><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                    / મો.ફોન : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9984523271</span><br>
                                                <strong
                                                    class="heading-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મોકલનાર
                                                    GST : </strong><span
                                                    class="receipt-body-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">27AABCU9603R1ZV</span><br
                                                    class="gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>">
                                                <strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">લેનાર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">શ્રી
                                                    જય ઈલેક્ટ્રોનિક્સ</span><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                    / લે.ફોન : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9033445566</span><br>
                                                <strong
                                                    class="heading-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">લેનાર
                                                    GST : </strong><span
                                                    class="receipt-body-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">29ABCDE1234F2Z5</span>
                                        </tr>
                                        </>
                                        </tr>
                                        <tr>
                                            <td colspan="<?php echo ($sql1_data["booking_time"] == "off" && $sql1_data["print_time"] == "off") ? "3" : "2" ;?>"
                                                class="border-bottom border-dark text-center p-1 print_plc3 <?php echo $sql1_data["place_to_send"] == "off" ? "d-none" : ""; ?>">
                                                <div>
                                                    <h4 class="p-0 m-0"><strong class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">નિકોલ</strong>
                                                    </h4>
                                                </div>
                                            </td>
                                            <td class="border-bottom border-dark print_book3 p-0 m-0 <?php echo ($sql1_data["booking_time"] == "off" && $sql1_data["print_time"] == "off") ? "d-none" : "" ;?>"
                                                colspan="<?php echo $sql1_data["place_to_send"] == "off" ? "3" : ""; ?>">
                                                <strong class="heading-style book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">બુકિંગ
                                                    તારીખ : </strong><span class="receipt-body-style book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
                                                    31-08-2024
                                                    <span
                                                        class="book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>">07:26
                                                        PM</span></span><br class="book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>">
                                                <strong class="heading-style print_date3 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                    પ્રિન્ટ તારીખ : </strong><span
                                                    class="receipt-body-style print_date3 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">31-08-2024
                                                    <span
                                                        class="print_date3 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>">
                                                        07:26:00 PM</span></span>
                                            </td>
                                        </tr>
                                        <tr class=" border-top border-dark ">
                                            <td><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">દાગીના
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">34</span>
                                            </td>
                                            <td class="border-top border border-dark"><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">બાકી</span>
                                            </td>
                                            <td rowspan="1" class="text-center"><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">રસીદ
                                                    નંબર : </strong><br>
                                                <span class="lrn-size"
                                                    style="font-size:<?php echo !empty($sql1_data["lr_font"]) ? $sql1_data["lr_font"] : ""; ?>">10008</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0">
                                                <div class="row m-auto">
                                                    <div class="col p-1 border-end-1 border-dark border-1"
                                                        style="border-right:1px solid #000"><strong
                                                            class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>"><?php echo "Hamali charge : "; ?></strong><span
                                                            class="receipt-body-style"
                                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo "10"; ?></span>
                                                    </div>
                                                    <div class="col p-1 border-end-0 border-dark border-1 "><strong
                                                            class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>"><?php echo "Invoice no : "; ?></strong><span
                                                            class="receipt-body-style"
                                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo "1234512345"; ?></span>
                                                    </div>
                                            </td>
                                        </tr>

                                </div>


                                <tr>
                                    <td colspan="2" class="py-1">
                                        <span class="receipt-body-style"
                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">33-પીવીસી</span><br><span
                                            class="receipt-body-style"
                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">1-
                                            બોક્ષ</span>
                                    </td>
                                    <td
                                        class="print_remark3 <?php echo $sql1_data["remarks"] == "off" ? "d-none" : ""; ?>">
                                        <strong class="heading-style"
                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>;">Remark
                                            : </strong>
                                        <span class="receipt-body-style text-break"
                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>;">બેંગલુરુ
                                            મોકલવાનું</span>
                                    </td>
                                </tr>
                                </table>
                            </div>
                            <div class="right_receipt w-50">
                            <table class="table table-bordered">
                                        <tr>
                                            <td class="p-1" colspan="3"><strong
                                                    class="heading-style book_print3 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">બુકિંગ
                                                    ઓફિસ : </strong><span
                                                    class="receipt-body-style book_print3 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">મુંબઇ
                                                    / </span><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">ફોન
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9988776655</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-1"><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મોકલનાર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">રવિકુમાર
                                                </span><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                    / મો.ફોન : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9984523271</span><br>
                                                <strong
                                                    class="heading-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મોકલનાર
                                                    GST : </strong><span
                                                    class="receipt-body-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">27AABCU9603R1ZV</span><br
                                                    class="gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>">
                                                <strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">લેનાર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">શ્રી
                                                    જય ઈલેક્ટ્રોનિક્સ</span><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                    / લે.ફોન : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9033445566</span><br>
                                                <strong
                                                    class="heading-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">લેનાર
                                                    GST : </strong><span
                                                    class="receipt-body-style gst_print3 <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">29ABCDE1234F2Z5</span>
                                        </tr>
                                        </>
                                        </tr>
                                        <tr>
                                            <td colspan="<?php echo ($sql1_data["booking_time"] == "off" && $sql1_data["print_time"] == "off") ? "3" : "2" ;?>"
                                                class="border-bottom border-dark text-center p-1 print_plc3 <?php echo $sql1_data["place_to_send"] == "off" ? "d-none" : ""; ?>">
                                                <div>
                                                    <h4 class="p-0 m-0"><strong class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">નિકોલ</strong>
                                                    </h4>
                                                </div>
                                            </td>
                                            <td class="border-bottom border-dark print_book3 p-0 m-0 <?php echo ($sql1_data["booking_time"] == "off" && $sql1_data["print_time"] == "off") ? "d-none" : "" ;?>"
                                                colspan="<?php echo $sql1_data["place_to_send"] == "off" ? "3" : ""; ?>">
                                                <strong class="heading-style book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">બુકિંગ
                                                    તારીખ : </strong><span class="receipt-body-style book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
                                                    31-08-2024
                                                    <span
                                                        class="book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>">07:26
                                                        PM</span></span><br class="book_date3 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>">
                                                <strong class="heading-style print_date3 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                    પ્રિન્ટ તારીખ : </strong><span
                                                    class="receipt-body-style print_date3 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">31-08-2024
                                                    <span
                                                        class="print_date3 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>">
                                                        07:26:00 PM</span></span>
                                            </td>
                                        </tr>
                                        <tr class=" border-top border-dark ">
                                            <td><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">દાગીના
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">34</span>
                                            </td>
                                            <td class="border-top border border-dark"><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">બાકી</span>
                                            </td>
                                            <td rowspan="1" class="text-center"><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">રસીદ
                                                    નંબર : </strong><br>
                                                <span class="lrn-size"
                                                    style="font-size:<?php echo !empty($sql1_data["lr_font"]) ? $sql1_data["lr_font"] : ""; ?>">10008</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="p-0">
                                                <div class="row m-auto">
                                                    <div class="col p-1 border-end-1 border-dark border-1"
                                                        style="border-right:1px solid #000"><strong
                                                            class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>"><?php echo "Hamali charge : "; ?></strong><span
                                                            class="receipt-body-style"
                                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo "10"; ?></span>
                                                    </div>
                                                    <div class="col p-1 border-end-0 border-dark border-1 "><strong
                                                            class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>"><?php echo "Invoice no : "; ?></strong><span
                                                            class="receipt-body-style"
                                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo "1234512345"; ?></span>
                                                    </div>
                                            </td>
                                        </tr>

                                </div>


                                <tr>
                                    <td colspan="2" class="py-1">
                                        <span class="receipt-body-style"
                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">33-પીવીસી</span><br><span
                                            class="receipt-body-style"
                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">1-
                                            બોક્ષ</span>
                                    </td>
                                    <td
                                        class="print_remark3 <?php echo $sql1_data["remarks"] == "off" ? "d-none" : ""; ?>">
                                        <strong class="heading-style"
                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>;">Remark
                                            : </strong>
                                        <span class="receipt-body-style text-break"
                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>;">બેંગલુરુ
                                            મોકલવાનું</span>
                                    </td>
                                </tr>
                                </table>
                        </div>
                    </div>
                    <div class="save_btn">
                        <button type="submit"
                            class="btn btn-success btn-lg"><?php echo $language['save'] . " & " . $language['SelectOpt']; ?></button>
                    </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>
</>
<?php require_once('layouts/main/footer.php'); ?>
</div>
</div>

<?php require_once('layouts/menu/right-sidebar.php'); ?>
<?php require_once('layouts/stylescript/vendor-scripts.php'); ?>
<script src="assets/js/app.js"></script>
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<?php require_once('layouts/footer/transportb.php'); ?>
<script type="text/javascript" charset="utf8"
    src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
</body>

</html>