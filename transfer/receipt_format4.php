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
</head>

<?php require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');
?>

<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content border mt-2 pb-1">
            <form action="#" method="POST">
                <input type="hidden" name="receipt_format" value="format4">
                <div class="receipt">
                    <div class="row g-4 p-0">
                        <!-- Left Side: Form Inputs -->
                        <div class="col-xl-3 col-lg-3 mt-0 p-0 col-12">
                            <div class="side_bar p-2">
                                <div class="receipt_input_section">
                                    <div class="grup">
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between pt-1 mt-1">
                                            <h5 for="" class="m-0"><?php echo $language['booking_office']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" name="book_office"
                                                    id="book_office4" <?php echo !empty($sql1_data["booking_office"]) && $sql1_data["booking_office"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center  justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['Place_send2']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" name="place_send"
                                                    id="place_send4" <?php echo !empty($sql1_data["place_to_send"]) && $sql1_data["place_to_send"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center  justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['gst_detail']; ?></h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" id="gst_details4"
                                                    name="gst_detail" <?php echo !empty($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['remark']; ?> : </h5>
                                            <div class="button r" id="button-1">
                                                <input type="checkbox" class="checkbox" id="remark4" name="remarks"
                                                    <?php echo !empty($sql1_data["remarks"]) && $sql1_data["remarks"] == "on" ? "checked" : ""; ?> />
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
                                                    id="booking_time4" <?php echo !empty($sql1_data["booking_time"]) && $sql1_data["booking_time"] == "on" ? "checked" : ""; ?> />
                                                <div class="knobs"></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="toggle-button-cover d-flex align-items-center justify-content-between mt-4">
                                            <h5 for="" class="m-0"><?php echo $language['print_time']; ?></h5>
                                            <div class="button r <?php echo $sql1_data["dates"] == "off" ? "bookin_disable" : ""; ?>"
                                                id="button-1">
                                                <input type="checkbox" class="checkbox" id="print_tm4"
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
                                                <option value="medium" <?php echo $sql1_data["heading_font"] == "medium" ? "selected" : ""; ?>>Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["heading_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["heading_font"] == "x-large" ? "selected" : ""; ?>>Extra Large</option>
                                            </select> -->
                                            <input type="number" class="form-control" name="heading_font" id="heading_font" value="<?php echo $heading_font; ?>">
                                        </div>
                                        <div class="form_grups mt-4">
                                            <h5 for=""><?php echo $language['detail_font']; ?></h5>
                                            <!-- <select class="form-select fontSize" aria-label="Default select example"
                                                name="fontSize">
                                                <option value="small" <?php echo $sql1_data["receipt_font"] == "small" ? "selected" : ""; ?>>Small</option>
                                                <option value="medium" <?php echo $sql1_data["receipt_font"] == "medium" ? "selected" : ""; ?>>Medium (Default)</option>
                                                <option value="large" <?php echo $sql1_data["receipt_font"] == "large" ? "selected" : ""; ?>>Large</option>
                                                <option value="x-large" <?php echo $sql1_data["receipt_font"] == "x-large" ? "selected" : ""; ?>>Extra Large</option>
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

                        <!-- Right Side: Live Preview -->
                        <div class="col-md-9 col-lg-9 col-12 m-0">
                            <div class="table-responshive mt-3">
                                <table class="w-100  border-1 border-dark p-2">
                                    <tr>
                                        <td colspan="2"><strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">મોકલનાર
                                                : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">મુંબઇ</span><br>
                                            <strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">મો.નંબર
                                                : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">9988776655</span><br>
                                            <strong
                                                class="heading-style print_gst4 <?php echo isset($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">મોકલનાર
                                                GST
                                                : </strong><span
                                                class="receipt-body-style print_gst4  <?php echo isset($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">27AABCU9603R1ZV</span><br
                                                class="print_gst4  <?php echo isset($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>">
                                            <strong
                                                class="mb-1 heading-style book_place4 <?php echo $sql1_data["booking_office"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>"><mark
                                                    class="bg-dark text-white px-2 ">મુંબઇ</mark></strong>
                                        </td>
                                        <td>
                                            <strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">લેનાર
                                                : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">રવિકુમાર</span><br>
                                            <strong
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">લે.નંબર
                                                : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">9984523271</span><br>
                                            <strong
                                                class="heading-style print_gst4  <?php echo isset($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">લેનાર
                                                GST
                                                : </strong><span
                                                class="receipt-body-style print_gst4  <?php echo isset($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">29ABCDE1234F2Z5</span><br
                                                class="print_gst4  <?php echo isset($sql1_data["gst_detail"]) && $sql1_data["gst_detail"] == "off" ? "d-none" : ""; ?>">
                                            <strong
                                                class="mb-1 heading-style place_print4 <?php echo $sql1_data["place_to_send"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>"><mark
                                                    class="bg-dark text-white px-2 ">બેંગલુરુ</mark></strong>
                                        </td>
                                        <td class="p-0">
                                            <div class="border-bottom border-dark p-1 date_time4 <?php echo ($sql1_data["booking_time"] == "off" && $sql1_data["print_time"] == "off") ? "d-none" : "" ;?>"><strong class="heading-style book_print4 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">બુકિંગ
                                                    તારીખ : </strong><span class="receipt-body-style book_print4 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">
                                                    31-08-2024
                                                    <span
                                                        class="book_print4 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>">07:26:00
                                                        PM</span></span><br class="book_print4 <?php echo $sql1_data["booking_time"] == "off" ? "d-none" : ""; ?>">
                                                <strong class="heading-style print_time4 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">પ્રિન્ટ
                                                    તારીખ : </strong><span class="receipt-body-style print_time4 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>"
                                                    style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">
                                                    31-08-2024
                                                    <span
                                                        class="print_time4 <?php echo $sql1_data["print_time"] == "off" ? "d-none" : ""; ?>">19:41:17
                                                        PM
                                                    </span></span>
                                            </div>
                                            <div class=" p-1"><strong class="heading-style"
                                                    style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">LR
                                                    નંબર :</strong>
                                                <br><span class="lrn-size"
                                                    style="font-size:<?php echo !empty($sql1_data["lr_font"]) ? $sql1_data["lr_font"] : "medium"; ?>">B-24877</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">વિગત
                                                : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">WHITE
                                                PAKING</span>
                                        </td>
                                        <td colspan="3" class="p-0 border-0">
                                            <table class="border-0">
                                                <tr class="border-0 p-0 border-bottom-0 border-end-0 text-center">
                                                    <td class="p-1 border-top-0 border-start-0 ">
                                                        <strong class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">જમા/બાકી</strong></span>
                                                    </td>
                                                    <td class="p-1 border-top-0 border-start-0 ">
                                                        <strong class="heading-style"
                                                            style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">દાગીના</strong></span>
                                                    </td>
                                                    <td class="p-1 border-top-0 border-start-0 ">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">Hamali
                                                                chrge</strong></span>
                                                    </td>
                                                    <td class="p-1 border-top-0 border-start-0 ">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">રકમ</strong></span>
                                                    </td>
                                                    <td class="p-1 border-top-0 border-end-0 border-start-0">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">કુલ
                                                                રૂપિયા</strong></span>
                                                    </td>
                                                </tr>
                                                <tr
                                                    class=" p-1 border-bottom-0 border-start-0 border-end-0 text-center">
                                                    <td
                                                        class="p-1 w-25 border-bottom-0  border-start-0 border-end border-dark">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">બાકી</strong></span>
                                                    </td>
                                                    <td
                                                        class="p-1  border-bottom-0  border-start-0 border-end border-dark">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">1</strong></span>
                                                    </td>
                                                    <td
                                                        class="p-1 border-bottom-0  border-start-0 border-end border-dark">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">100</strong></span>
                                                    </td>
                                                    <td
                                                        class="p-1 border-bottom-0  border-start-0 border-end border-dark">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">100</strong></span>
                                                    </td>

                                                    <td
                                                        class="p-1 w-25 border-bottom-0  border-start-0 border-end-0 border-dark">
                                                        <span><strong class="heading-style"
                                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>">100</strong></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="p-0">
                                            <div class="row m-auto align-items-center">

                                                <div class="col p-1  border-dark border-1"><strong class="heading-style"
                                                        style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : ""; ?>"><?php echo "Invoice no : "; ?></strong><span
                                                        class="receipt-body-style"
                                                        style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : ""; ?>"><?php echo "1234512345"; ?></span>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">સરનામું
                                                : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">
                                                MG રોડ, ABC બિલ્ડિંગ, બેંગલુરુ</span><strong class="heading-style"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">
                                                // ફોન : </strong><span class="receipt-body-style"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">9033445566</span>
                                        </td>
                                        <td>
                                            <strong
                                                class="heading-style remark_print4 <?php echo $sql1_data["remarks"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["heading_font"]) ? $sql1_data["heading_font"] : "medium"; ?>">Remark
                                                :
                                            </strong><span
                                                class="receipt-body-style remark_print4 text-break<?php echo $sql1_data["remarks"] == "off" ? "d-none" : ""; ?>"
                                                style="font-size:<?php echo !empty($sql1_data["receipt_font"]) ? $sql1_data["receipt_font"] : "medium"; ?>">Hello</span>
                                        </td>
                                    </tr>
                                    </tr>
                                </table>
                            </div>
                            <div class="save_btn  ">
                                <button type="submit"
                                    class="btn btn-success btn-lg"><?php echo $language['save'] . " & " . $language['SelectOpt']; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
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