<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

if (isset($_GET) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $filter_date = !empty($_GET["FromJeneralDates"]) ? $_GET["FromJeneralDates"] : "";
    $accountbranch = !empty($_GET["accountbranch"]) ? $_GET["accountbranch"] : "";
    $extra_charge = !empty($_GET["extracharge"]) ? $_GET["extracharge"] : "";
}

?>

<head>
    <title><?php echo $language["account"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="assets/css/user_account.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <script scr="assets/js/custome.js"></script>

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

</head>

<?php
require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');
?>

<div id="layout-wrapper">
    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content ">
            <?php if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin") || ($userrollpost == "Office") || ($userrollpost == "Customer")) { ?>
                <div class="container-fluid">
                    <!-- Bread Cump -->
                    <div class="row pt-2 mb-4">
                        <div class="col-lg-4 col-md-4 col-sm-12 ">
                            <form action="user_account.php" method="GET" class="user_form mb-3" id="user_form">
                                <h4 class="text-center text-primary">
                                    <?php echo !empty($language['Date_filter']) ? $language['Date_filter'] : ""; ?>
                                </h4>
                                <div class="form-grup">
                                    <label for=""
                                        class="pt-1 pb-1 m-0"><?php echo !empty($language['Date']) ? $language['Date'] : ""; ?></label>
                                    <input type="text" name="FromJeneralDates" id="finalacrange"
                                        class="form-control p-2 user_input">
                                </div>
                                <div class="form-grup pt-3">
                                    <label for=""
                                        class="pt-1 pb-1 m-0"><?php echo !empty($language['branch']) ? $language['branch'] : ""; ?></label>
                                    <select class="form-select user_input" name="accountbranch" id="accountbranch"
                                        aria-label="Default select example">
                                        <?php if (isset($userbranchishead) && $userbranchishead == "Yes") { ?>
                                            <?php foreach (array_unique($allbranchlist) as $branchf) { ?>
                                                <option <?php if (CleanBranchCode($branchf) == $userbranch) { ?>selected<?php } ?>
                                                    value="<?php echo CleanBranchCode($branchf); ?>"><?php echo $branchf; ?>
                                                </option>
                                            <?php } ?>
                                        <?php } else {
                                            if (isset($allbranchlist)) { ?>
                                                <?php foreach (array_unique($allbranchlist) as $branchf) {
                                                    if (CleanBranchCode($branchf) == $userbranch) {
                                                        $currentbranchwithcode = $branchf;
                                                    }
                                                } ?>
                                                <option value="<?php echo CleanBranchCode($branchf); ?>">
                                                    <?php echo CleanBranchCode($branchf); ?>
                                                </option>
                                            <?php } else { ?>
                                                <option value="no_branch">No Branch Available</option>
                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-grup pt-3">
                                    <label for=""
                                        class="pt-1 pb-1 m-0"><?php echo !empty($language['Extra_charge']) ? $language['Extra_charge'] : ""; ?></label>
                                    <input type="text" name="extracharge" id="extracharge"
                                        class="form-control p-2 user_input">
                                </div>
                                <div class="form-grup pt-3 d-sm-flex justify-content-center ">
                                    <?php if (isset($_GET)) { ?>
                                        <input type="hidden" id="filter_date"
                                            value="<?php echo !empty($_GET["FromJeneralDates"]) ? $_GET["FromJeneralDates"] : "" ?>">
                                        <input type="hidden" id="account_branch"
                                            value="<?php echo !empty($_GET["accountbranch"]) ? $_GET["accountbranch"] : ""; ?>">
                                        <input type="hidden" id="extra_charge"
                                            value="<?php echo !empty($_GET["extracharge"]) ? $_GET["extracharge"] : ""; ?>">
                                    <?php }
                                    ; ?>
                                    <button type="submit"
                                        class="btn btn-primary btn-md w-50 btn_find_account">Submit</button>
                                </div>
                            </form>

                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="user_data">
                                <?php if (!empty($filter_date)) {
                                    require_once("user_accounts_table.php");
                                } else {
                                    echo !empty($language["Select_filter"]) ? "<h3>" . $language["Select_filter"] . "</h3>" : "";
                                }
                                ; ?>
                            </div>
                        </div>
                    </div>
                <?php } else {
                echo "<h5>તમને આ પેજ જોવા ની પરમીશન નથી, હેડ ઓફીસ માં વાત કરો.</h5>";
            } ?>
                <!-- container-fluid -->
            </div>
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



<!-- daterange js -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    var startfinal = moment().subtract(1, 'month').startOf('month');
    var endfinal = moment().subtract(1, 'month').endOf('month');

    function cb(startfinal, endfinal) {
        $('#finalacrange span').html(startfinal.format('D MMMM, YYYY') + '-' + endfinal.format('D MMMM, YYYY'));
    }

    $('#finalacrange').daterangepicker({
        startDate: startfinal,
        endDate: endfinal,
        ranges: {
            'ગયા મહિના નું': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'ચાલુ મહિના નું': [moment().startOf('month'), moment().endOf('month')],
            'છેલ્લા ૭ દિવસ નું': [moment().subtract(6, 'days'), moment()],
            'છેલ્લા ૩૦ દિવસ નું': [moment().subtract(29, 'days'), moment()]
        }
    }, cb);

    cb(startfinal, endfinal);

</script>
</body>

</html>