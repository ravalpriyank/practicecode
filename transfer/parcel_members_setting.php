<?php
require_once ("layouts/mainheader.php");
require_once ("connection.php");
?>

<head>
    <title><?php echo $language['Staf_Members']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/company_setting.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="assets/js/custome.js"></script>

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
            <div class="row pt-2">
                <div class="table-responsive member_page_table_responshive p-0">
                    <table id="tbl_branch_users" class="table table-bordered table-hover table-xl mb-0 w-100">
                        <thead class="border-end-2 member_page_table ">
                            <tr class="">
                                <th width="6%" class="border-top-0" scope="col"><?php echo $language['serailno'] ;?></th>
                                <th width="15%" class="border-top-0 select-filter" scope="col"><?php echo $language['membername'] ;?></th>
                                <th width="15%" class="border-top-0" scope="col"><?php echo $language['branchname2'] ;?></th>
                                <th width="18%" class="border-top-0 select-filter" scope="col"><?php echo $language['position'] ;?></th>
                                <th width="10%" class="border-top-0 select-filter" scope="col"><?php echo $language['dateofaccount'] ;?></th>
                                <th width="10%" class="border-top-0 select-filter" scope="col"><?php echo $language['reset_password'] ;?></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <input type="hidden" name="current_user" id="current_user" value="<?php echo $currentloggedinuser ;?>">
                    </table>
                </div>
            </div>
            <?php }else
                echo "તમને આ પેજ જોવા ની પરમીશન નથી, હેડ ઓફીસ માં વાત કરો.";
            ?>
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