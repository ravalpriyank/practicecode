<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

?>

<head>
    <title><?php echo $language['item_setting']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <script src="assets/js/custome.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

</head>
<style>
    .delete_icon {
        padding: 6px 15px !important;
        border-radius: 6px !important;
        cursor: pointer !important;
    }
</style>

<?php
require_once("layouts/header/transporta.php");
?>
<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Bread Cump -->
                <?php if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin")) { ?>
                    <div class="row m-auto">
                        <div class="col-xs-4 col-sm-12 col-md-6 col-lg-4 ">
                            <form action="#" method="POST" class="Income_Details_form">
                                <h3 class="text-center mb-4  mb-1"><?php echo $language['add_item']; ?></h3>
                                <div class="form-grup ">
                                    <label for=""><?php echo $language['item_name']; ?></label>
                                    <input type="text" name="itemen" id="itemen" class="form-control border-primary">
                                </div>
                                <div class="form-grup my-4">
                                    <label for=""><?php echo $language['item_gujarati']; ?></label>
                                    <input type="text" name="itemgu" id="itemgu" class="form-control border-primary">
                                </div>
                                <div class="form-grup my-3 d-flex justify-content-center">
                                    <button type="submit" id="btn_add_item"
                                        class="btn btn-success w-50 btn_add_item"><?php echo $language['add_item']; ?></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-8 col-sm-12 col-md-12 col-lg-8 ">
                            <div class="income_detail  table-responshive">
                                <table class="table  table-bordered  border border-1 w-100" id="tbl_item_details">
                                    <thead>
                                        <th><?php echo $language['serailno']; ?></th>
                                        <th><?php echo $language['english_name']; ?></th>
                                        <th><?php echo $language['gujarati_name']; ?></th>
                                        <th><?php echo $language['Uaction']; ?></th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><?php echo $language['serailno']; ?></th>
                                            <th><?php echo $language['english_name']; ?></th>
                                            <th><?php echo $language['gujarati_name']; ?></th>
                                            <th><?php echo $language['Uaction']; ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } else {
                    echo "તમને આ પેજ જોવા ની પરમીશન નથી, હેડ ઓફીસ માં વાત કરો.";
                }
                ?>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php require_once('layouts/main/footer.php'); ?>
    </div>
    <!-- end main content-->

</div>


<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?php require_once('layouts/menu/right-sidebar.php'); ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

<?php require_once('layouts/stylescript/vendor-scripts.php'); ?>

<!-- init js -->
<script src="assets/js/app.js"></script>

<!-- choices js -->
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<?php require_once('layouts/footer/transportb.php'); ?>

<!-- datatable js -->
<script type="text/javascript" charset="utf8"
    src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

</body>
<?php if ($lang == "gu") { ?>
    <script type="text/javascript" src="assets/translate.js"></script>
<?php } ?>
<script>
    jQuery(document).ready(function () {
        jQuery('#itemen').on('keydown', function () {
            if (event.key == "Tab") {
                const text = $(this).val();
                if (text.trim() !== "") {
                    const apiUrl = 'https://www.google.com/inputtools/request';
                    const params = {
                        text: text,
                        ime: 'transliteration_en_gu',
                        num: 5,
                        cp: 0,
                        cs: 0,
                        ie: 'utf-8',
                        oe: 'utf-8',
                        app: 'js'
                    };

                    $.ajax({
                        url: apiUrl,
                        type: 'GET',
                        data: params,
                        success: function (response) {
                            if (response && response[0] === 'SUCCESS') {
                                $('#itemgu').val(response[1][0][1][0]);
                            } else {
                                console.error('Translation failed', response);
                            }
                        },
                        error: function () {
                            alert("Error in translation");
                        }
                    });
                }
            }

        });
    });
</script>

</html>