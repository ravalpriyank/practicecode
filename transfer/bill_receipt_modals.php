<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
// require_once("main_const.php");
require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $language["Income"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/lr_detail.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script scr="assets/js/custome.js"></script>

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <title>Document</title>
</head>

<body>

    <div id="layout-wrapper">
        <div class="main-content m-0 p-0">
            <div class="page-content p-0">
                <div class="container-fluid">
                    <div class="main_content">
                        <div class="row gap-2  justify-content-between">
                            <div class="col-lg-6">
                                <div class="row pt-3">
                                    <div class="col-lg-4 col-md-4 col-sm-12 pb-3">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary  w-100" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            <?php echo !empty($language["report2"]) ? $language["report2"] : ""; ?>
                                        </button>

                                        <!-- Modal -->
                                        <form action="print_gen.php" method="POST" target="_blank">
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog  modal-dialog-centered ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Report</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="heading text-center">
                                                                <h4 class="text-primary">Print Report</h4>
                                                            </div>
                                                            <div class="row ">
                                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                                    <div class="grup">
                                                                        <label for="">Date :</label>
                                                                        <input type="text" name="FromJeneralDates"
                                                                            id="reportrange"
                                                                            class="p-1 w-100 model_inputs">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                                    <div class="grup">
                                                                        <label for=""> Select :</label>
                                                                        <select class="form-select w-100 model_inputs "
                                                                            aria-label="Delivery" name="ThisPrintMethod"
                                                                            id="ThisPrintMethodinGeneral">
                                                                            <option value="in">
                                                                                <?php echo "Delivery Report (In)"; ?>
                                                                            </option>
                                                                            <option value="out" selected>
                                                                                <?php echo "સામાન્ય જનરલ (Out)"; ?>
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row section_one section_out pt-3">
                                                                <div class="col-lg-5 col-md-5 col-sm-12">
                                                                    <div class="grup">
                                                                        <select class="form-select w-100 model_inputs"
                                                                            aria-label="Delivery" name="FromThisBranch"
                                                                            id="FromThisBranchgeneral">
                                                                            <?php if ($userbranchishead == "Yes") { ?>
                                                                                <?php $uniqebranchlist = array_unique($allbranchlist);
                                                                                foreach ($uniqebranchlist as $branchf) {
                                                                                    ; ?>
                                                                                    <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?>
                                                                                        value="<?php echo $branchf ?>">
                                                                                        <?php echo $branchf ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                            <?php } else { ?>
                                                                                <?php foreach ($allbranchlist as $branchf) {
                                                                                    echo $branchf;

                                                                                    if ($branchf == $branchwithcode) {
                                                                                        $currentbranchwithcode = $branchf;
                                                                                    }
                                                                                } ?>
                                                                                <option
                                                                                    value="<?php echo $currentbranchwithcode; ?>">
                                                                                    <?php echo !empty($currentbranchwithcode) ? $currentbranchwithcode : "No Branch Available"; ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <input type="hidden"
                                                                            class="p-2 check_box model_inputs"
                                                                            name="pointer" value="yes">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-center justify-content-center">
                                                                    <h4 class="pt-2">To</h4>
                                                                </div>
                                                                <div class="col-lg-5 col-md-5 col-sm-12">
                                                                    <div class="grup">
                                                                        <select class="form-select w-100 model_inputs "
                                                                            aria-label="Delivery" name="ToThisBranch[]"
                                                                            id="ToThisBranch">
                                                                            <option selected>All Places Combined
                                                                            </option>
                                                                            <?php
                                                                            $uniqebranchlistforeach = array_unique($allbranchlist);
                                                                            foreach ($uniqebranchlistforeach as $branchf) { ?>
                                                                                <option value="<?php echo $branchf; ?>">
                                                                                    <?php echo $branchf; ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3 section_two section_in">
                                                                <div class="col-5">
                                                                    <div class="grup">
                                                                        <select class="form-select w-100 model_inputs"
                                                                            aria-label="Delivery" name="FromThisBranch"
                                                                            id="FromThisBranchgeneral">
                                                                            <?php if ($userbranchishead == "Yes") { ?>
                                                                                <?php
                                                                                if (isset($allbranchlist)) {
                                                                                    foreach (array_unique($allbranchlist) as $branchf) { ?>

                                                                                        <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?>
                                                                                            value="<?php echo $branchf; ?>">
                                                                                            <?php echo $branchf; ?>
                                                                                        </option>
                                                                                    <?php }
                                                                                } else { ?>
                                                                                    <option value="not">No Branch Available
                                                                                    </option>
                                                                                <?php }
                                                                            } else { ?>
                                                                                <?php
                                                                                if (isset($allbranchlist)) {
                                                                                    foreach (array_unique($allbranchlist) as $branchf) {
                                                                                        echo $branchf;

                                                                                        if ($branchf == $branchwithcode) {
                                                                                            $currentbranchwithcode = $branchf;
                                                                                        }
                                                                                    } ?>
                                                                                    <option
                                                                                        value="<?php echo $currentbranchwithcode; ?>">
                                                                                        <?php echo !empty($currentbranchwithcode) ? $currentbranchwithcode : "No Branch Available"; ?>
                                                                                    </option>
                                                                                <?php } else {
                                                                                    ; ?>
                                                                                    <option value="not">No Branch Available
                                                                                    </option>
                                                                                <?php }
                                                                            }
                                                                            ; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-2 d-flex align-items-center justify-content-center">
                                                                    <div class="check-box">
                                                                        <input type="checkbox"
                                                                            class="p-2 check_box model_inputs"
                                                                            name="chrtbox" value="yes">
                                                                    </div>
                                                                </div>
                                                                <div class="col-5">
                                                                    <h3>chart</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Print
                                                                Report</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 pb-3">
                                        <button type="button" class="btn btn-primary  w-100" data-bs-toggle="modal"
                                            data-bs-target="#lrdetail_2">
                                            GST LR <?php echo !empty($language["print"]) ? $language["print"] : ""; ?>
                                        </button>

                                        <!-- Modal -->
                                        <form action="print_bulk_info.php" method="POST" target="_blank">
                                            <div class="modal fade" id="lrdetail_2" tabindex="-1"
                                                aria-labelledby="lrdetail_2" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content  p-3">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="lrdetail_2">રસીદ ની પ્રિન્ટ કાઢો
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="">
                                                            <div class="heading text-center">
                                                                <h4 class="text-primary pt-3">Print LR Report</h4>
                                                            </div>
                                                            <div class="row">
                                                                <div class="grup">
                                                                    <label for="">Date :</label>
                                                                    <input type="text" id="printrange"
                                                                        name="FromJeneralDates"
                                                                        class="p-2 w-100 model_inputs">
                                                                </div>
                                                            </div>
                                                            <div class="row pt-4">
                                                                <div class="col-lg-5 col-md-5 col-sm-12">
                                                                    <div class="grup">
                                                                        <select name="FromThisBranch"
                                                                            id="FromThisBranch"
                                                                            class="form-control border border-primary">
                                                                            <?php
                                                                            if (isset($allbranchlist)) {
                                                                                foreach (array_unique($allbranchlist) as $branchf) { ?>
                                                                                    <option value="<?php echo $branchf; ?>">
                                                                                        <?php echo $branchf; ?>
                                                                                    </option>
                                                                                <?php }
                                                                            } else { ?>
                                                                                <option value="not">No Branch Available
                                                                                </option>
                                                                            <?php }
                                                                            ; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-center justify-content-center">
                                                                    <h4 class="pt-2">To</h4>
                                                                </div>
                                                                <div class="col-lg-5 col-md-5 col-sm-12">
                                                                    <div class="grup">
                                                                        <select name="ToThisBranch"
                                                                            id="ToThisBranchgeneral"
                                                                            class="form-control align-middle border border-primary">
                                                                            <?php if ($userbranchishead == "Yes") { ?>
                                                                                <?php if (isset($allbranchlist)) {
                                                                                    foreach (array_unique($allbranchlist) as $branchf) { ?>
                                                                                        <option <?php if (CleanBranchCode($branchf) == $userbranch) { ?>selected<?php } ?>
                                                                                            value="<?php echo $branchf; ?>">
                                                                                            <?php echo $branchf; ?>
                                                                                        </option>
                                                                                    <?php }
                                                                                } else { ?>
                                                                                    <option value="not">No Branch Available
                                                                                    </option>
                                                                                <?php }
                                                                                ; ?>
                                                                            <?php } else { ?>
                                                                                <?php
                                                                                if (isset($allbranchlist)) {
                                                                                    foreach (array_unique($allbranchlist) as $branchf) {
                                                                                        if (CleanBranchCode($branchf) == $userbranch) {
                                                                                            $currentbranchwithcode = $branchf;
                                                                                        }
                                                                                    } ?>
                                                                                    <option
                                                                                        value="<?php echo $currentbranchwithcode; ?>">
                                                                                        <?php echo $currentbranchwithcode; ?>
                                                                                    </option>
                                                                                <?php } else { ?>
                                                                                    <option value="not">No Branch Available
                                                                                    </option>
                                                                                    <?php
                                                                                }
                                                                            } ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="row align-middle d-none">
                                                                    <div class="col-sm-12 align-middle">
                                                                        <select name="ThisPrintMethod"
                                                                            id="ThisPrintMethod"
                                                                            class="form-control align-middle ">
                                                                            <option value="AllPrint">
                                                                                <?php echo "બધી રસીદ ની પ્રિન્ટ એક સાથે"; ?>
                                                                            </option>
                                                                            <option value="SelectedPrint" selected>
                                                                                <?php echo "રસીદ નંબર મુજબ પ્રિન્ટ"; ?>
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Print LR
                                                                Report</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 pb-3">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary  w-100" data-bs-toggle="modal"
                                            data-bs-target="#Delivery">
                                            <?php echo !empty($language['Delivery']) ? $language['Delivery'] : ""; ?>
                                        </button>

                                        <!-- Modal -->
                                        <form action="print_delivery.php" method="POST" target="_blank">
                                            <div class="modal fade" id="Delivery" tabindex="-1"
                                                aria-labelledby="lrdetail_2" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content  p-3">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="Delivery">Delivery Report </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="">
                                                            <div class="heading text-center">
                                                                <h4 class="text-primary  pt-3">Delivery Report</h4>
                                                            </div>
                                                            <div class="row">
                                                                <div class="grup">
                                                                    <label for="">Date :</label>
                                                                    <input type="text" id="deliveryrange"
                                                                        name="FromJeneralDates"
                                                                        class="p-2 w-100 model_inputs">
                                                                </div>
                                                            </div>
                                                            <div class="row pt-4 m-auto">
                                                                <div class="grup gap-3 col-5 col-lg-5">
                                                                    <input type="text"
                                                                        class="form-control bg-white border border-primary"
                                                                        value="<?php echo !empty($userbranch) ? $userbranch : "No User Branch Available"; ?>"
                                                                        name="FromThisBranch"
                                                                        id="FromThisBranchdelivery" style="width:100%"
                                                                        readonly />
                                                                </div>

                                                                <?php
                                                                $user_role = geturlrole($_SESSION["username"]);
                                                                if ($user_role != "SuperDuperAdmin") {
                                                                    ?>
                                                                    <div class="col-2 col-lg-2 col-md-2 ">
                                                                        <h4 class="pt-2 m-auto">Ma</h4>
                                                                    </div>
                                                                    <div class="col-5 ">
                                                                        <div class="grup">
                                                                            <div
                                                                                class="check-box flex-column d-flex align-items-center gap-3 h-25 overflow-auto">
                                                                                <?php
                                                                                if (isset($branchcollegues)) {
                                                                                    foreach ($branchcollegues as $usersascurbranch) { ?>
                                                                                        <div
                                                                                            class="wrapper w-100 d-flex gap-3 align-items-center ">
                                                                                            <div class="check_wrap">
                                                                                                <input type="checkbox"
                                                                                                    class="p-2 check_box"
                                                                                                    value="<?php echo $usersascurbranch; ?>"
                                                                                                    name="usersofthisbranch[]"
                                                                                                    id="user<?php echo $usersascurbranch; ?>" />
                                                                                            </div>
                                                                                            <div class="lable_wrap">
                                                                                                <label
                                                                                                    for="user<?php echo $usersascurbranch; ?>"
                                                                                                    class="form-label  m-0 "><?php echo " " . $usersascurbranch; ?></label>
                                                                                            </div>


                                                                                        </div>
                                                                                    <?php }
                                                                                } else { ?>
                                                                                    <input type="checkbox" class="p-2 check_box"
                                                                                        value="" name="usersofthisbranch[]"
                                                                                        id="user" />
                                                                                    <label for="user"
                                                                                        class="form-label  m-0 mt-1">No User
                                                                                        Branch Available</label><br>
                                                                                <?php }
                                                                                ; ?>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                ; ?>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Print Delivery
                                                                Report</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-5">
                                <form action="display_recent_parcels.php" method="GET" id="search_parcel"
                                    target="_blank">
                                    <div class="row justify-content-end pt-3  flex-wrap">
                                        <div class="col-lg-4 col-sm-12 pb-3">
                                            <input type="text" name="sendername" id="sendername" class="form-control"
                                                placeholder="<?php echo $language['sender2']; ?>">
                                        </div>
                                        <div class="col-lg-4 pb-3">
                                            <input type="text" name="receivername" id="receivername"
                                                class="form-control" placeholder="<?php echo $language['reciver2']; ?>">
                                        </div>
                                        <div class="col-lg-4 ">
                                            <button type="submit" id="customer_filter"
                                                class="btn btn-primary btn-md w-100"><?php echo !empty($language["CustomerFil"]) ? $language["CustomerFil"] : ""; ?></button>
                                        </div>
                                    </div>



                                </form>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php require_once('layouts/main/footer.php'); ?>
    </div>
    <!-- end main content-->

    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <?php require_once('layouts/menu/right-sidebar.php'); ?>
    <!-- /Right-bar -->

    <!-- choices js -->
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- datatable js -->
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>


    </div>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript">
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'આજ નું': [moment(), moment()],
                'ગઈ કાલ નું': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'છેલ્લા ૭ દિવસ નું': [moment().subtract(6, 'days'), moment()],
                'છેલ્લા ૩૦ દિવસ નું': [moment().subtract(29, 'days'), moment()],
                'ચાલુ મહિના નું': [moment().startOf('month'), moment().endOf('month')],
                'ગયા મહિના નું': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    </script>
    <script type="text/javascript">
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#printrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#printrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'આજ નું': [moment(), moment()],
                'ગઈ કાલ નું': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'છેલ્લા ૭ દિવસ નું': [moment().subtract(6, 'days'), moment()],
                'છેલ્લા ૩૦ દિવસ નું': [moment().subtract(29, 'days'), moment()],
                'ચાલુ મહિના નું': [moment().startOf('month'), moment().endOf('month')],
                'ગયા મહિના નું': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    </script>
    <script type="text/javascript">
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#deliveryrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#deliveryrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'આજ નું': [moment(), moment()],
                'ગઈ કાલ નું': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'છેલ્લા ૭ દિવસ નું': [moment().subtract(6, 'days'), moment()],
                'છેલ્લા ૩૦ દિવસ નું': [moment().subtract(29, 'days'), moment()],
                'ચાલુ મહિના નું': [moment().startOf('month'), moment().endOf('month')],
                'ગયા મહિના નું': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    </script>

    <script>
        $(document).ready(function () {
            jQuery('#ThisPrintMethodinGeneral').on('change', function () {
                if (this.value == "in") {
                    jQuery(".section_two").addClass("show_section").removeClass("hide_section");
                    jQuery(".section_one").addClass("hide_section").removeClass("show_section");
                }
                else {
                    jQuery(".section_two").addClass("hide_section").removeClass("show_section");
                    jQuery(".section_one").addClass("show_section").removeClass("hide_section");
                }
            });
        });
    </script>
</body>

</html>