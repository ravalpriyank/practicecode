<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

if (isset($_GET) && isset($_GET["edit"]) == "true") {
    $sno = !empty($_GET["sno"]) ? $_GET["sno"] : "";

    $query = "SELECT * FROM `thirdparties` WHERE `sno` = '$sno'";
    $run_query = mysqli_query($conn2, $query);
    $data = mysqli_fetch_assoc($run_query);
}
?>

<head>
    <title><?php echo $language['Driver_Conductor']; ?> | GT Solution</title>
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
                <!-- Bread Cump -->
                <?php if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin")) { ?>
                    <div class="row pt-2 ">
                        <h2 class="text-primary text-center mb-3">
                            <?php echo isset($_GET["edit"]) == "true" ? $language['update'] . " " . $language['Driverentry'] : $language['Driverentry']; ?>
                        </h2>
                        <hr>
                    </div>
                    <form action="#" method="POST">
                        <div class="row driver_page">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="grup">
                                    <label for="" class="fw-bold"><?php echo $language['DriverName']; ?></label>
                                    <input type="text" name="driver_name" id="driver_name"
                                        class="form-control border-primary"
                                        value="<?php echo !empty($data["name"]) ? $data["name"] : ""; ?>"
                                        placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 margin_top_mobile">
                                <div class="grup">
                                    <label for="" class="fw-bold"><?php echo $language['mobilenum']; ?></label>
                                    <input type="text" name="driver_number" id="driver_number"
                                        class="form-control border-primary"
                                        value="<?php echo !empty($data["mobile"]) ? $data["mobile"] : ""; ?>"
                                        placeholder="Enter Number">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 mt-4">
                                <?php if (isset($_GET)) { ?>
                                    <input type="hidden" id="edit_driver" name="edit_driver"
                                        value="<?php echo isset($_GET["edit"]) ? $_GET["edit"] : ''; ?>">
                                    <input type="hidden" id="edit_id" name="edit_id"
                                        value="<?php echo isset($_GET["sno"]) ? $_GET["sno"] : ''; ?>">
                                <?php }
                                ; ?>
                                <button type="submit" name="add_driver" id="add_driver"
                                    class="add_driver btn btn-danger w-100"><?php echo isset($_GET["edit"]) == "true" ? $language['UpdateDriver'] : $language['AddDriver']; ?></button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-5 branch_form">
                        <table class="table table-bordered w-100" name="tbl_driver_info" id="tbl_driver_info">
                            <thead>
                                <tr>
                                    <th scope="col"><?php echo $language['Number']; ?></th>
                                    <th scope="col"><?php echo $language['DriverName']; ?></th>
                                    <th scope="col"><?php echo $language['mobilenum'] ?></th>
                                    <th scope="col"><?php echo $language['Uaction'] ?></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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