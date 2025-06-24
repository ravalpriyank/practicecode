<?php

require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("main_const.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";
$sno = !empty($_GET["sno"]) ? $_GET["sno"] : "";

$query = "SELECT * FROM `expenses` WHERE `sno` = '" . $sno . "'";
$run_query = mysqli_query($conn2, $query);
$raw = mysqli_fetch_assoc($run_query);

?>

<head>
    <title><?php echo $language["Expense"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
        <div class="page-content">
            <div class="container-fluid">
                <!-- Bread Cump -->
                <div class="row pt-4">
                    <h4 class=" text-primary fw-bold">
                        <?php echo isset($_GET["edit"]) == "true" ? $language['Edit_expense'] : $language['Add_expense']; ?>
                    </h4>
                    <div class="col-lg-3 col-md-12">

                        <div class="Income_Details_form mb-md-3 mb-xl-0">
                            <form action="#" method="POST">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['Expense_reason']; ?></label>
                                    <input type="text" class="form-control" name="exp_reason" id="exp_reason"
                                        value="<?php echo !empty($raw["expense"]) ? $raw["expense"] : ""; ?>">
                                </div>
                                <div class="form-grup pb-3">
                                    <label for=""><?php echo $language['Expense_detail']; ?></label>
                                    <input type="text" class="form-control" name="exp_detail" id="exp_detail"
                                        value="<?php echo !empty($raw["expensedetail"]) ? $raw["expensedetail"] : ""; ?>">
                                </div>
                                <div class="form-grup pb-3">
                                    <label for=""><?php echo $language['Date2']; ?></label>
                                    <input type="date" name="exp_date" id="exp_date" class="form-control"
                                        value="<?php echo !empty($raw["date"]) ? $raw["date"] : ""; ?>">
                                </div>
                                <div class="form-grup pb-3">
                                    <label for=""><?php echo $language['amount']; ?></label>
                                    <input type="number" name="exp_amount" id="exp_amount" class="form-control"
                                        value="<?php echo !empty($raw["amount"]) ? $raw["amount"] : ""; ?>">
                                </div>
                                <div class="form-grup ">
                                    <button type="submit" name="btn_exp" id="btn_exp"
                                        class="btn btn-primary btn-md "><?php echo isset($_GET["edit"]) ? $language['Update_expense'] : $language['Submit_expense']; ?></button>
                                    <?php if (isset($_GET)) { ?>
                                        <input type="hidden" id="edit_expense" name="edit_expense"
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
                        <div class="income_detail table-responsive">
                            <table class="table table-bordered tbl_income_detail" id="tbl_expense_detail">
                                <thead>
                                    <tr>
                                        <th scope="col"><?php echo $language["Number"]; ?></th>
                                        <th scope="col"><?php echo $language["Date2"]; ?></th>
                                        <th scope="col"><?php echo $language['Expense_reason']; ?></th>
                                        <th scope="col"><?php echo $language['Expense_detail']; ?></th>
                                        <th scope="col"><?php echo $language['amount']; ?></th>
                                        <th scope="col"><?php echo $language['Expenser']; ?></th>
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