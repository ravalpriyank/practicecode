<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

$khatamemberlist = getarraywithstring("transportz", "type", "Accounting Software", "nameone");
?>

<head>
    <title><?php echo $language['Account_holders']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/company_setting.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script scr="assets/js/custome.js"></script>

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
                <?php if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin")) { ?>
                    <!-- Bread Cump -->
                    <div class="row pt-1">
                        <h3 class="text-center text-primary pb-3"><?php echo $language['khatarepair']; ?></h3>
                        <hr>
                    </div>
                    <div class="row pt-3">
                        <div class="col-lg-3">
                            <form action="#" method="POST" class="branch_form">
                                <div>
                                    <h5 class="m-0 text-primary text-center pb-3 "><?php echo $language['repairing']; ?>
                                    </h5>
                                </div>
                                <div class="form-grup pt-1">
                                    <label for="" class="fw-bold"><?php echo $language['incorrectname']; ?></label>
                                    <select class="form-select border-primary" aria-label="Default select example"
                                        name="wrong_acc_name" id="wrong_acc_name">
                                        <?php foreach ($khatamemberlist as $khatamemberhere) { ?>
                                            <option value="<?php echo $khatamemberhere; ?>"><?php echo $khatamemberhere; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="d-flex align-item-center justify-content-center">
                                    <h3 class="mt-2 mb-2">નું</h3>
                                </div>
                                <div class="form-grup pb-3">
                                    <label for="" class="fw-bold"><?php echo $language['correctname']; ?></label>
                                    <select class="form-select border-primary" aria-label="Default select example"
                                        name="right_acc_name" id="right_acc_name">
                                        <?php foreach ($khatamemberlist as $khatamemberhere) { ?>
                                            <option value="<?php echo $khatamemberhere; ?>"><?php echo $khatamemberhere; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mt-2 d-flex align-item-center justify-content-center">
                                    <button type="submit" class="btn btn-success w-75" id="btn_edit_acc"
                                        name="btn_edit_acc"><?php echo $language['changename']; ?></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-9">
                            <div class="branch_form table-responsive">
                                <table class="table table-bordered w-100" id="tbl_acc_holders">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?php echo $language['accountno']; ?></th>
                                            <th scope="col"><?php echo $language['accountholder']; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">

                                    </tbody>
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

</html>