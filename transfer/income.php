<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
?>

<head>
    <title><?php echo $language["Income"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
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
    <?php
    $sno = !empty($_GET["sno"]) ? $_GET["sno"] : "";
    $query = "SELECT * FROM `incomes` WHERE `sno` = '" . $sno . "'";
    $run_query = mysqli_query($conn2, $query);
    $raw = mysqli_fetch_assoc($run_query);
    ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Bread Cump -->
                <div class="row pt-4">
                    <h4 class="text-strat text-primary fw-bold">
                        <?php echo isset($_GET["edit"]) == "true" ? $language['Edit_income'] : $language['Add_income']; ?>
                    </h4>
                    <div class="col-lg-3 col-md-12">
                        <div class="Income_Details_form mb-md-3 mb-xl-0">
                            <form action="#" method="POST">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['Income_reason']; ?></label>
                                    <input type="text" class="form-control" name="inc_reason" id="inc_reason"
                                        value="<?php echo !empty($raw["income"]) ? $raw["income"] : ""; ?>">
                                </div>
                                <div class="form-grup pb-3">
                                    <label for=""><?php echo $language['Income_detail']; ?></label>
                                    <input type="text" class="form-control" name="inc_detail" id="inc_detail"
                                        value="<?php echo !empty($raw["incomedetail"]) ? $raw["incomedetail"] : ""; ?>">
                                </div>
                                <div class="form-grup pb-3">
                                    <label for=""><?php echo $language['Date2']; ?></label>
                                    <input type="date" name="inc_date" id="inc_date" class="form-control"
                                        value="<?php echo !empty($raw["date"]) ? $raw["date"] : ""; ?>">
                                </div>
                                <div class="form-grup pb-3">
                                    <label for=""><?php echo $language['amount']; ?></label>
                                    <input type="number" name="inc_amount" id="inc_amount" class="form-control"
                                        value="<?php echo !empty($raw["amount"]) ? $raw["amount"] : ""; ?>">
                                </div>
                                <div class="form-grup">
                                    <button type="submit" name="btn_inc" id="btn_inc"
                                        class="btn btn-primary btn-md"><?php echo isset($_GET["edit"]) ? $language['Update_income'] : $language['Submit_income']; ?></button>
                                    <?php if (isset($_GET)) { ?>
                                        <input type="hidden" id="edit_income" name="edit_income"
                                            value="<?php echo isset($_GET["edit"]) ? $_GET["edit"] : ''; ?>">
                                        <input type="hidden" id="edit_id" name="edit_id"
                                            value="<?php echo isset($_GET["sno"]) ? $_GET["sno"] : ''; ?>">
                                    <?php }
                                    ; ?>
                                </div>
                            </form>
                            <input type="hidden" name="user" id="user"
                                value="<?php echo !empty($username) ? $username : ""; ?>">
                            <input type="hidden" name="user_role" id="user_role"
                                value="<?php echo !empty($userrollpost) ? $userrollpost : ""; ?>">
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12 mb-md-5 mb-xl-0">
                        <div class="income_detail table-responsive ">
                            <table class="table table-bordered tbl_income_detail h-100 " id="tbl_income_detail">
                                <thead>
                                    <tr>
                                        <th scope="col"><?php echo $language['Number']; ?></th>
                                        <th scope="col"><?php echo $language['Date2']; ?></th>
                                        <th scope="col"><?php echo $language['Income_reason']; ?></th>
                                        <th scope="col"><?php echo $language['Income_detail']; ?></th>
                                        <th scope="col"><?php echo $language['amount']; ?></th>
                                        <th scope="col"><?php echo $language['Incomer']; ?></th>
                                        <th scope="col"><?php echo $language['Uaction']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

</html>