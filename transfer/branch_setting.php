<?php
require_once("layouts/mainheader.php");
require_once("connection.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET) && isset($_GET["noplace"]) == "true") {
    $plc_error = "* Please Add Another Branches To Send The Parcel *";
}

if (isset($_GET) && isset($_GET["edit"])) {
    $branch_no = !empty($_GET["sno"]) ? $_GET["sno"] : "";

    $query = "SELECT * FROM `branchlog` WHERE `sno` = '$branch_no'";
    $run_query = mysqli_query($conn2, $query);
    $branch_data = mysqli_fetch_assoc($run_query);

}

?>

<head>
    <title><?php echo $language['Branch_Setting']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/company_setting.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/cities.js"></script>
</head>

<?php require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php'); ?>

<div id="layout-wrapper">
    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <label for="" class="text-danger"><?php echo isset($plc_error) ? $plc_error : ""; ?></label>
                <!-- Bread Cump -->
                <?php if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin")) {
                    ; ?>
                    <div class="row pt-2">
                        <h2 class="text-center text-primary pb-3">
                            <?php echo isset($_GET["edit"]) ? $language['updatebranchmanagement'] : $language['branchmanagement']; ?>
                        </h2>
                        <hr>
                    </div>

                    <form action="#" method="POST" class="branch_form" id="create_new_branch">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['branchname']; ?></label>
                                    <input type="text" class="form-control border-primary" name="branch_name"
                                        id="branch_name"
                                        value="<?php echo !empty($branch_data["name"]) ? $branch_data["name"] : ""; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['mobilenum']; ?></label>
                                    <input type="text" class="form-control border-primary" name="branch_mobile"
                                        id="branch_mobile"
                                        value="<?php echo !empty($branch_data["phone"]) ? $branch_data["phone"] : ""; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['state']; ?></label>
                                    <?php if (isset($_GET) && isset($_GET["edit"])) {
                                        ; ?>
                                        <input type="hidden" name="selected_state" id="selected_state"
                                            value="<?php echo !empty($branch_data["state"]) ? $branch_data["state"] : ""; ?>" required>
                                    <?php }
                                    ; ?>
                                    <select class="form-select border-primary"
                                        onchange="print_city('branch_city', this.selectedIndex);"
                                        aria-label="Default select example" name="branch_state" id="branch_state"
                                        required></select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['city']; ?></label>
                                    <?php if (isset($_GET) && isset($_GET["edit"])) {
                                        ; ?>
                                        <input type="hidden" name="selected_city" id="selected_city"
                                            value="<?php echo !empty($branch_data["city"]) ? $branch_data["city"] : ""; ?>">
                                    <?php }
                                    ; ?>
                                    <select class="form-select border-primary" aria-label="Default select example"
                                        name="branch_city" id="branch_city" required></select>
                                </div>
                            </div>

                        </div>
                        <div class="row pb-2">
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['branchcode']; ?></label>
                                    <input type="text" maxlength="8" minlength="1" class="form-control border-primary"
                                        name="branch_code" id="branch_code"
                                        value="<?php echo !empty($branch_data["code"]) ? $branch_data["code"] : ""; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['gst_branchcode']; ?></label>
                                    <input type="text" maxlength="8" minlength="2" class="form-control border-primary"
                                        name="gst_branch_code" id="gst_branch_code"
                                        value="<?php echo !empty($branch_data["gst_code"]) ? $branch_data["gst_code"] : ""; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['minlr']; ?></label>
                                    <input type="number" class="form-control border-primary" name="minimum_lr"
                                        id="minimum_lr"
                                        value="<?php echo !empty($branch_data["minnum"]) ? $branch_data["minnum"] : ""; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['maxlr']; ?></label>
                                    <input type="number" class="form-control border-primary" name="maximum_lr"
                                        id="maximum_lr"
                                        value="<?php echo !empty($branch_data["maxnum"]) ? $branch_data["maxnum"] : ""; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-grup pb-2 ">
                                    <label for=""><?php echo $language['isheadoffice']; ?></label>
                                    <br>
                                    <div class="main_office d-flex align-items-center gap-4 border rounded">
                                        <div class="Head_Office d-flex align-items-center  gap-2 p-2">
                                            <input type="radio" class="main_radio" name="Head_Office" id="Head_Office_yes"
                                                value="Yes" <?php echo isset($branch_data) && $branch_data["ishead"] == "Yes" ? "checked" : "checked"; ?>>
                                            <h5 class="m-0">Yes</h5>
                                        </div>
                                        <div class="Head_Office d-flex align-items-center gap-2">
                                            <input type="radio" class="main_radio" name="Head_Office" id="Head_Office_no"
                                                value="No" <?php echo isset($branch_data) && $branch_data["ishead"] == "No" ? "checked" : ""; ?>>
                                            <h5 class="m-0">No</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['printtile']; ?></label>
                                    <input type="text" class="form-control border-primary" name="print_heading"
                                        id="print_heading" list="headingtype"
                                        value="<?php echo isset($branch_data["branchhead"]) ? $branch_data["branchhead"] : ""; ?>" required>
                                    <datalist id="headingtype">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-grup pb-2">
                                    <label for=""><?php echo $language['address2']; ?></label>
                                    <textarea rows="1" class="form-control border-primary" name="address"
                                        id="address" required><?php echo !empty($branch_data["address"]) ? htmlspecialchars($branch_data["address"]) : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                    <label for=""><?php echo $language['topmargin']; ?></label>
                                    <input type="text" onkeypress='return event.charCode >= 45 && event.charCode <= 57'
                                        minlength="2" maxlength="9" class="form-control w-100 border-primary top_margin"
                                        name="top_margin" id="top_margin" placeholder="Enter top margin"
                                        value="<?php echo !empty($branch_data["margintop"]) ? $branch_data["margintop"] : ""; ?>" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for=""><?php echo $language['scaleratio']; ?></label>
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        minlength="1" maxlength="3" class="form-control w-100 border-primary scale_ratio"
                                        name="scale_ratio" id="scale_ratio" placeholder="Enter Ratio"
                                        value="<?php echo !empty($branch_data["yscales"]) ? floatval($branch_data["yscales"]) * 100 : ""; ?>" required>
                                </div>
                            <?php if (isset($_GET["edit"])) { ?>
                                <div class="col-lg-3">
                                    <div class="form-grup pb-2">
                                        <label for=""><?php echo $language['titlecolor']; ?></label>
                                        <input type="color" class="form-control border-primary p-1 " style="height:40px"
                                            name="branch_title_color" id="branch_title_color"
                                            value="<?php echo !empty($branch_data["titlecolor"]) ? $branch_data["titlecolor"] : ""; ?>">
                                    </div>
                                </div>
                            <?php }
                            ; ?>
                            <div class="col-lg-3 mt-4">
                                <?php if (isset($_GET["edit"])) { ?>
                                    <input type="hidden" id="edit_branch" name="edit_branch"
                                        value="<?php echo isset($_GET["edit"]) ? $_GET["edit"] : ''; ?>">
                                    <input type="hidden" id="edit_id" name="edit_id"
                                        value="<?php echo isset($_GET["sno"]) ? $_GET["sno"] : ''; ?>">
                                <?php } ?>
                                <button type="submit" class="btn btn-primary w-100" id="btn_add_branch"
                                    name="btn_add_branch"><?php echo isset($_GET["edit"]) ? $language['updatebranch'] : $language['addbranch']; ?></button>
                                <?php if (isset($_GET) && isset($_GET["first"]) == "true") { ?>
                                    <input type="hidden" name="first_branch" id="first_branch"
                                        value="<?php echo $_GET["first"] ?>">
                                <?php }
                                ; ?>
                            </div>
                        </div>
                    </form>
                    <div class="branch_data branch_form mt-3 table-responsive-xl mb-4">
                        <table class="table table-bordered text-center m-1 w-100 p-0 table-xl " id="tbl_branch_info">
                            <thead>
                                <tr>
                                    <th scope="col" width="10%"><?php echo $language['Number']; ?></th>
                                    <th scope="col" width="5%"><?php echo $language['branchname2']; ?></th>
                                    <th scope="col" width="5%"><?php echo $language['branchcode2']; ?></th>
                                    <th scope="col" width="5%"><?php echo $language['gstCode']; ?></th>
                                    <th scope="col" width="5%"><?php echo $language['city2']; ?></th>
                                    <th scope="col" width="10%"><?php echo $language['mobilenum2']; ?></th>
                                    <th scope="col" width="10%"><?php echo $language['minlr2']; ?></th>
                                    <th scope="col" width="10%"><?php echo $language['maxlr2']; ?></th>
                                    <th scope="col" width="40%"><?php echo $language['Uaction']; ?></th>
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

<script language="javascript">print_state("branch_state");</script>

</body>

</html>