<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
?>

<head>
    <title><?php echo $language["setting"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
                <div class="row pt-2">
                    <h2 class="text-center text-primary fw-bold pb-3">
                        <?php echo $language['setting']; ?>
                    </h2>
                    <hr>
                </div>
                <div class="setings_detail">
                    <form action="#" method="POST" class=" p-4 rounded" style="width:70%;">
                        <?PHP if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin")) { ?>
                            <div class="form-grup pb-3">
                                <label for=""><?php echo $language['Companyname']; ?></label>
                                <input type="text" class="form-control w-100 border-primary company_name"
                                    placeholder="Enter Company Name" name="company_name"
                                    value="<?php echo !empty($companynamef) ? $companynamef : ""; ?>">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-grup">
                                        <label for=""><?php echo $language['mainhead']; ?></label>
                                        <select class="form-select border-primary main-head" name="main-head"
                                            aria-label="Default select example">
                                            <?php if (!empty($branchnamesf)) { ?>
                                                <?php if (empty($companyheadf)) { ?>
                                                    <option value="select" selected hidden disabled>Select Head Office</option>
                                                <?php }
                                                ; ?>
                                                <?php foreach ($branchnamesf as $branchf) { ?>
                                                    <option <?php if ($branchf == $companyheadf) { ?>selected<?php } ?>
                                                        value="<?php echo $branchf; ?>"><?php echo $branchf; ?></option>
                                                <?php }
                                            } else { ?>
                                                <option value="none">No branch available</option>
                                            <?php }
                                            ; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-grup pb-3">
                                        <label for=""><?php echo $language['maincity']; ?></label>
                                        <select class="form-select border-primary main-city" name="main-head"
                                            aria-label="Default select example">
                                            <?php if (!empty($unique_city)) { ?>
                                                <?php if (empty($companyheadcityf)) { ?>
                                                    <option value="select" selected hidden disabled>Select Head City</option>
                                                <?php }
                                                ; ?>
                                                <?php foreach ($unique_city as $city) { ?>
                                                    <option <?php if ($city == $companyheadcityf) { ?>selected<?php } ?>
                                                        value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                                <?php }
                                            } else { ?>
                                                <option value="none">No city available</option>
                                            <?php }
                                            ; ?>
                                        </select>
                                        <!-- <select class="form-select border-primary main-city" name="main-city"
                                            aria-label="Default select example">
                                            <option <?php if ($companyheadcityf == "Surat") { ?>selected<?php } ?>
                                                value="<?php echo "Surat"; ?>"><?php echo "Surat"; ?></option>
                                            <option <?php if ($companyheadcityf == "Rajkot") { ?>selected<?php } ?>
                                                value="<?php echo "Rajkot"; ?>"><?php echo "Rajkot"; ?></option>
                                            <option <?php if ($companyheadcityf == "Ahmedabad") { ?>selected<?php } ?>
                                                value="<?php echo "Ahmedabad"; ?>"><?php echo "Ahmedabad"; ?></option>
                                        </select> -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-grup pb-3">
                                <label for=""><?php echo $language['logourl']; ?></label>
                                <input type="text" class="form-control w-100 border-primary logo_url" name="logo_url"
                                    placeholder="Enter URL"
                                    value="<?php echo !empty($companylogof) ? $companylogof : ""; ?>">
                            </div>
                        <?php }
                        ; ?>
                        <div class="d-flex align-items-center justify-content-start pt-4">
                            <input type="hidden" value="<?php echo "generalsetting"; ?>" name="generalsetting"
                                id="generalsetting" readonly>
                            <button type="submit" class="btn btn-success btn_save_setting w-25"
                                name="btn_save"><?php echo $language['save']; ?></button>
                        </div>
                </div>
                </form>
            </div>
            <!-- end row -->
        </div>
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