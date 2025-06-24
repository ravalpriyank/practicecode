<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
?>

<head>
    <title><?php echo $language['add_member']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <script scr="assets/js/custome.js"></script>

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #fff !important;
        }
    </style>
</head>

<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>

    <div class="main-content">
        <div class="page-content">
            <?php if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin")) { ?>
                <div class="container-fluid">
                    <!-- Bread Cump -->
                    <h3 class="text-center mt-3"><?php echo $language['add_member']; ?></h3>

                    <div class="add_form ">
                        <form action="#" method="POST" class='m-auto p-4 rounded' id="add_new_member" style="width:60% ">
                            <div class="form-group py-2">
                                <label for=""><?php echo $language['Username']; ?></label>
                                <input type="text" name="user_name" id="user_name" class="form-control border-primary"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group py-2">
                                        <label for=""><?php echo $language['Password']; ?></label>
                                        <input type="text" name="user_password" id="user_password"
                                            class="form-control border-primary" placeholder="" aria-describedby="helpId">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group py-2">
                                        <label for=""><?php echo $language['Confirm_Password']; ?></label>
                                        <input type="text" name="confirm_password" id="confirm_password"
                                            class="form-control border-primary" placeholder="" aria-describedby="helpId">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group py-2">
                                <label for=""><?php echo $language['branchname']; ?></label>
                                <select name="user_branch" id="user_branch" class="form-control border-primary">
                                    <?php if ($userrollpost == "SuperAdmin" || $userrollpost == "SuperDuperAdmin") { ?>
                                        <?php foreach ($allbranchlist as $branch) { ?>
                                            <option value="<?php echo CleanBranchCode($branch) ?>">
                                                <?php echo CleanBranchCode($branch); ?></option>
                                        <?php }
                                    } else {
                                        ; ?>
                                        <option value="<?php echo $userbranch; ?>"><?php echo $userbranch; ?></option>
                                    <?php }
                                    ; ?>
                                </select>
                            </div>
                            <div class="form-group py-2">
                                <label for=""><?php echo $language['designation']; ?></label>
                                <select name="user_designation" id="user_designation" class="form-control border-primary">
                                    <option value="select" hidden selected>Select Designation</option>
                                    <option value="Admin">Admin</option>
                                    <option value="CityAdmin">City Admin</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <button type="botton" class="btn btn-success"
                                    id="btn_add_member"><?php echo $language['add_new_mem']; ?></button>
                            </div>
                        </form>
                    </div>
                    <!-- end row -->
                </div>
            <?php } else {
                echo "<h5>તમને આ રસીદ જોવા ની પરમીશન નથી, હેડ ઓફીસ માં વાત કરો.</h5>";
            } ?>
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