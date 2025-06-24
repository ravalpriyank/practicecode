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
    <link rel="stylesheet" href="assets/css/all_receipt.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <script scr="assets/js/custome.js"></script>
    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <style>
        .end_tr {
            border-bottom: 0 !important;
        }
    </style>
</head>

<?php require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');
?>

<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content border mt-2 pb-1">
            <div class="receipt">
                <form action="#" method="POST">
                    <input type="hidden" name="receipt_format" value="format5">
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
                                                    id="book_office5" <?php echo !empty($sql1_data["booking_office"]) && $sql1_data["booking_office"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center  justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['Place_send2']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" name="place_send"
                                                    id="place_send5" <?php echo !empty($sql1_data["place_to_send"]) && $sql1_data["place_to_send"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center  justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['gst_detail']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" id="gst_details5"
                                                    name="gst_detail" <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['remark']; ?> : </h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" id="remark_print5"
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
                                                    id="booking_time5" <?php echo !empty($sql1_data["booking_time"]) && $sql1_data["booking_time"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['print_time']; ?></h5>
                                            <div class="button r <?php echo $sql1_data["dates"] == "off" ? "bookin_disable" : ""; ?>"
                                                id="button-1">
                                                <input type="checkbox" class="checkbox" name="print_office"
                                                    id="print_office5" <?php echo !empty($sql1_data["print_time"]) && $sql1_data["print_time"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div class="form_grups mt-4">
                                            <h5 for=""><?php echo $language['heading_font']; ?></h5>
                                            <!-- <select class="form-select headingSize" aria-label="Default select example" name="headingSize">
                                                <option value="small" <?php echo $sql1_data["heading_font"] == "small" ? "selected" : ""; ?>>Small</option>
                                                <option value="medium" <?php echo $sql1_data["heading_font"] == "medium" ? "selected" : ""; ?>>Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["heading_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["heading_font"] == "x-large" ? "selected" : ""; ?>>Extra Large</option>
                                            </select> -->
                                            <input type="number" class="form-control" name="heading_font"
                                                id="heading_font" value="<?php echo $heading_font; ?>">
                                        </div>
                                        <div class="form_grups mt-4">
                                            <h5 for=""><?php echo $language['detail_font']; ?></h5>
                                            <!-- <select class="form-select fontSize" aria-label="Default select example" name="fontSize">
                                                <option value="small" <?php echo $sql1_data["receipt_font"] == "small" ? "selected" : ""; ?>>Small</option>
                                                <option value="medium" <?php echo $sql1_data["receipt_font"] == "medium" ? "selected" : ""; ?>>Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["receipt_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["receipt_font"] == "x-large" ? "selected" : ""; ?>>Extra Large</option>
                                            </select> -->
                                            <input type="number" class="form-control" name="body_font" id="body_font"
                                                value="<?php echo $receipt_font; ?>">
                                        </div>
                                        <div class="form_grups mt-4 mb-3">
                                            <h5 for=""><?php echo $language['lr_font']; ?></h5>
                                            <!-- <select class="form-select lrnSize" aria-label="Default select example" name="lrnSize">
                                                <option value="small" <?php echo $sql1_data["lr_font"] == "small" ? "selected" : ""; ?>>Small</option>
                                                <option value="medium" <?php echo $sql1_data["lr_font"] == "medium" ? "selected" : ""; ?>>Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["lr_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["lr_font"] == "x-large" ? "selected" : ""; ?>>Extra Large</option>
                                            </select> -->
                                            <input type="number" class="form-control" name="lr_font" id="lr_font"
                                                value="<?php echo $lr_font; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Live Preview -->
                        <div class="col-md-9 col-lg-9 col-12 m-0">
                            <div class="table-responshive mt-3">
                                <table class="w-100  border-1 border-dark p-1">
                                    <tr>
                                        <td colspan="2"><strong
                                                class="heading-style book_print5 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">બુકિંગ
                                                ઓફિસ : </strong><span
                                                class="receipt-body-style book_print5 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">મુંબઇ</span><br
                                                class="book_print5 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"><strong
                                                class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">ફોન
                                                નંબર : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9988776655</span>
                                        </td>
                                        <td><strong
                                                class="heading-style send_place5 <?php echo $sql1_data["place_to_send"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મોકલવા
                                                ની જગ્યા : </strong><span
                                                class="receipt-body-style send_place5 <?php echo $sql1_data["place_to_send"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">બેંગલુરુ</span><br
                                                class="send_place5 <?php echo $sql1_data["place_to_send"] == "off" ? "d-none" : ""; ?>"><strong
                                                class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">
                                                ફોન નંબર : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9876543210</span>
                                        </td>
                                        <td class="text-center"><strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">LR
                                                No</strong><br><span class="lrn-size"
                                                style="font-size:<?php echo !empty($sql1_data["lr_font"]) ? $sql1_data["lr_font"] : ""; ?>">2997</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="m-0"><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મોકલનાર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">રવિકુમાર</span><br>
                                                <strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મો.નંબર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9984523271</span><br>
                                                <strong
                                                    class="heading-style print_gst5 <?php echo $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">મોકલનાર
                                                    GST : </strong><span
                                                    class="receipt-body-style print_gst5 <?php echo $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">27AABCU9603R1ZV</span>
                                            </p>
                                        </td>
                                        <td colspan="1">
                                            <p class="m-0"><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">લેનાર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">શ્રી
                                                    જય ઈલેક્ટ્રોનિક્સ</span><br>
                                                <strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">લે.નંબર
                                                    : </strong><span class="receipt-body-style"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">9033445566</span><br>
                                                <strong
                                                    class="heading-style print_gst5 <?php echo $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">લેનાર
                                                    GST : </strong><span
                                                    class="print_gst5 receipt-body-style <?php echo $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">29ABCDE1234F2Z5</span>
                                            </p>
                                        <td><strong class="heading-style "
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">પેમેન્ટ
                                                : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">બાકી</span><br>
                                        </td>

                                        </td>
                                    </tr>
                                    <tr class="p-0 border-0">
                                        <td colspan="" class="w-25"
                                            style="word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                            <strong class="heading-style"
                                                style="font-size: <?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>;">
                                                વસ્તુ ની વિગત :
                                            </strong>
                                            <span class="receipt-body-style"
                                                style="font-size: <?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>;">
                                                5-કુરશી, 1-કબાટ
                                            </span>
                                        </td>

                                        <td class="border-start-0 border-top-0 border-bottom-0"><strong
                                                class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>"><?php echo "Hamali charge : "; ?></strong><span
                                                class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo "10"; ?></span><br><strong
                                                class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>"><?php echo "Invoice no : "; ?></strong><span
                                                class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo "1234512345"; ?></span>
                                        </td>



                                        </td>
                                        <td colspan="2" class="px-1 p-0"><strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">દાગીના
                                                ની સંખ્યા : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">1</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="p-0">
                                            <table class="border-0">
                                                <tr class="border-bottom-1 border-top-0 border-start-0 border-end-0">
                                                    <td class="p-1 w-50 border-top-0 border-start-0"
                                                        style="word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                                        <strong class="heading-style"
                                                            style="font-size: <?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>;">
                                                            માલ મેળવવા નું સ્થાન :
                                                        </strong>
                                                        <span class="receipt-body-style"
                                                            style="font-size: <?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>;">
                                                            MG રોડ, ABC બિલ્ડિંગ, બેંગલુરુ
                                                        </span>
                                                    </td>

                                                    <td class="border-top-0  w-50 border-start-0 border-end-0"
                                                        style="border-bottom:1px solid #000 !important"><strong
                                                            class="heading-style remark_5 <?php echo $sql1_data["remarks"] == "off" ? "d-none" : ""; ?>"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">Remark
                                                            : </strong><span
                                                            class="receipt-body-style remark_5 <?php echo $sql1_data["remarks"] == "off" ? "d-none" : ""; ?>"
                                                            style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>;  ">Hello</span>
                                                    </td>
                                                </tr>
                                                <tr class="end_tr border-end-0 border-start-0" style="border-bottom:1px solid #c0baba !important">
                                                    <td class="border-bottom-0 border-start-0 print_book5 <?php echo $sql1_data["print_time"] == "off" ? "border-end-0" : ""; ?> <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>">
                                                        <p class="m-0 p-1"><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">બુકિંગ
                                                                સમય : </strong><span class="receipt-body-style"
                                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">
                                                                31-08-2024 <span
                                                                    class="">07:26:00
                                                                    PM</span></span></p>
                                                    </td>
                                                    <td class="border-0 print_time5 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>">
                                                        <p class="m-0"><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">પ્રિન્ટ
                                                                સમય : </strong><span class="receipt-body-style"
                                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">31-08-2024
                                                                <span
                                                                    class="">31-08-2024
                                                                    19:41:17 PM</span></span></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        </td>
                                        <td class="text-center ">
                                            <strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">કુલ
                                                : </strong>
                                            <span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>">500</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="save_btn ">
                                <button type="submit"
                                    class="btn btn-success btn-lg"><?php echo $language['save'] . " & " . $language['SelectOpt']; ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once('layouts/main/footer.php'); ?>


    <?php require_once('layouts/menu/right-sidebar.php'); ?>
    <?php require_once('layouts/stylescript/vendor-scripts.php'); ?>
    <script src="assets/js/app.js"></script>
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <?php require_once('layouts/footer/transportb.php'); ?>
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    </body>

    </html>