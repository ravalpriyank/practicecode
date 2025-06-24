<?php
require_once('layouts/mainheader.php');
require_once("connection.php");
require_once("dashboard_data.php");
if ($userrollpost == "CityAdmin") {
    $cityVar = $CityBranch;
} else {
    $cityVar = $allbranchlist;
}
?>


<head>
    <title><?php echo $language["Dashboard"]; ?> | GT Solution</title>

    <?php require_once('layouts/main/head.php'); ?>

    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/income.css">
    <?php require_once('layouts/stylescript/head-style.php'); ?>
</head>
<style>
    .card .card-header .active2 {
        background-color: #7a7fdc;
        color: #fff;
    }
</style>

<?php require_once('layouts/main/body.php'); ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18"><?php echo $language['Dashboard']; ?></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">GT Solution</a></li>
                                    <li class="breadcrumb-item active"><?php echo $language['Dashboard']; ?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <a href="display_recent_parcels.php?type=paid">
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="row align-items-center">

                                        <div class="col-12">
                                            <span
                                                class="text-muted mb-3 lh-1 d-block text-truncate"><?php echo $language['topaid']; ?></span>
                                            <h4 class="mb-3">
                                                ₹<span class="counter-value"
                                                    data-target="<?php echo !empty($data1["total"]) ? $data1["total"] : "0"; ?>">0</span>&nbsp;
                                            </h4>
                                        </div>


                                        <div class="col-6 d-none">
                                            <div id="mini-chart1" data-colors='["#5156be"]' class="apex-charts mb-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-nowrap">
                                        <span
                                            class="badge bg-soft-success text-success"><?php echo !empty($mdata1["total"]) ? "₹" . $mdata1["total"] : "₹0"; ?></span>
                                        <span
                                            class="ms-1 text-muted font-size-13"><?php echo $language['curr_month']; ?></span>
                                    </div>

                                </div><!-- end card body -->
                        </a>
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <a href="display_recent_parcels.php?type=topay">
                        <div class="card card-h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <span
                                            class="text-muted mb-3 lh-1 d-block text-truncate"><?php echo $language['topay']; ?></span>
                                        <h4 class="mb-3">
                                            ₹<span class="counter-value"
                                                data-target="<?php echo !empty($data2["total"]) ? $data2["total"] : "0"; ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="col-6 d-none">
                                        <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                    </div>
                                </div>
                                <div class="text-nowrap">
                                    <span
                                        class="badge bg-soft-success text-success"><?php echo !empty($mdata2["total"]) ? "₹" . $mdata2["total"] : "₹0"; ?></span>
                                    <span
                                        class="ms-1 text-muted font-size-13"><?php echo $language['curr_month']; ?></span>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </a>
                </div><!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <a href="display_recent_parcels.php?type=account">
                        <div class="card card-h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <span
                                            class="text-muted mb-3 lh-1 d-block text-truncate"><?php echo $language['account']; ?></span>
                                        <h4 class="mb-3">
                                            ₹<span class="counter-value"
                                                data-target="<?php echo !empty($data3["total"]) ? $data3["total"] : "0"; ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="col-6 d-none">
                                        <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                    </div>
                                </div>
                                <div class="text-nowrap">
                                    <span
                                        class="badge bg-soft-success text-success"><?php echo !empty($mdata3["total"]) ? "₹" . $mdata3["total"] : "₹0"; ?></span>
                                    <span
                                        class="ms-1 text-muted font-size-13"><?php echo $language['curr_month']; ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <a href="display_recent_parcels.php?type=all">
                        <div class="card card-h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <span
                                            class="text-muted mb-3 lh-1 d-block text-truncate"><?php echo $language['amount']; ?></span>
                                        <h4 class="mb-3">
                                            ₹<span class="counter-value"
                                                data-target="<?php echo !empty($data_total) ? $data_total["total"] : ""; ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="col-6 d-none">
                                        <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                    </div>
                                </div>
                                <div class="text-nowrap">
                                    <span
                                        class="badge bg-soft-success text-success"><?php echo !empty($data_ctotal["total"]) ? "₹" . $data_ctotal["total"] : "₹0"; ?></span>
                                    <span
                                        class="ms-1 text-muted font-size-13"><?php echo $language['curr_month']; ?></span>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </a>
                </div><!-- end col -->
            </div><!-- end row-->
            <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin") { ?>
                <div class="row">
                    <div class="col-xl-5 col-md-5">
                        <!-- card -->
                        <div class="card card-h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center mb-4">
                                    <h5 class="card-title me-2"><?php echo $language['Collection']; ?></h5>
                                    <div class="ms-auto">
                                        <div>
                                            <button type="button" class="btn btn-soft-primary btn-sm btn_all active2"
                                                value="All">
                                                <?php echo $language['All']; ?>
                                            </button>
                                            <button type="button" class="btn btn-soft-primary btn-sm btn_paid">
                                                <?php echo $language['topaid']; ?>
                                            </button>
                                            <button type="button" class="btn btn-soft-primary btn-sm btn_pay">
                                                <?php echo $language['topay']; ?>
                                            </button>
                                            <button type="button" class="btn btn-soft-primary btn-sm btn_account">
                                                <?php echo $language['account']; ?>
                                            </button>
                                            <input type="hidden" name="temp" id="temp"
                                                value="<?php echo json_encode($all_branch); ?>">

                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-sm">

                                        <div id="wallet-balance" data-colors='["#777aca", "#5156be", "#a8aada"]'
                                            class="apex-charts piechart">
                                        </div>
                                        <h4 class="err-msg d-none"><?php echo $language['no_data']; ?></h4>
                                        <script>

                                            var all_branch = <?php echo !empty($all_branch) ? json_encode($all_branch) : "[]"; ?>;
                                            var all_total = <?php echo !empty($all_data) ? json_encode($all_total) : "[]"; ?>;

                                            all_total = all_total.map(Number);

                                            var paid_branch = <?php echo !empty($paid_branch) ? json_encode($paid_branch) : "[]"; ?>;
                                            var paid_total = <?php echo !empty($paid_total) ? json_encode($paid_total) : "[]"; ?>;
                                            paid_total = paid_total.map(Number);

                                            var topay_branch = <?php echo !empty($topay_branch) ? json_encode($topay_branch) : "[]"; ?>;
                                            var topay_total = <?php echo !empty($topay_total) ? json_encode($topay_total) : "[]"; ?>;
                                            topay_total = topay_total.map(Number);

                                            var account_branch = <?php echo !empty($account_branch) ? json_encode($account_branch) : "[]"; ?>;
                                            var account_total = <?php echo !empty($account_total) ? json_encode($account_total) : "[]"; ?>;
                                            account_total = account_total.map(Number);
                                        </script>
                                    </div>
                                    <div class="col-sm align-self-center">
                                        <div class="mt-4 mt-sm-0 ">
                                            <div class="data_all set_data">
                                                <?php foreach ($all_data as $data) { ?>
                                                    <div class="d-block">
                                                        <p class="mt-4 pt-2 branch_lbl"><i
                                                                class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i>
                                                            <?php echo !empty($data["branch"]) ? $data["branch"] : ""; ?></p>
                                                        <h6><span
                                                                class="text-muted font-size-14 fw-bold ps-3"><?php echo !empty($data["total"]) ? $data["total"] : ""; ?></span>
                                                        </h6>
                                                    </div>
                                                <?php }
                                                ; ?>
                                            </div>

                                            <div class="data_paid">
                                                <?php foreach ($paid_data as $data) { ?>
                                                    <div class="d-none">
                                                        <p class="mt-4 pt-2 branch_lbl"><i
                                                                class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i>
                                                            <?php echo !empty($data["branch"]) ? $data["branch"] : ""; ?></p>
                                                        <h6 class="fw-bold"><span
                                                                class="text-muted font-size-14  fw-bold ps-3"><?php echo !empty($data["total"]) ? $data["total"] : ""; ?></span>
                                                        </h6>
                                                    </div>
                                                <?php }
                                                ; ?>
                                            </div>

                                            <div class="data_pay">
                                                <?php foreach ($topay_data as $data) { ?>
                                                    <div class="d-none">
                                                        <p class="mt-4 pt-2 branch_lbl"><i
                                                                class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i>
                                                            <?php echo !empty($data["branch"]) ? $data["branch"] : ""; ?></p>
                                                        <h6><span
                                                                class="text-muted font-size-14  fw-bold ps-3"><?php echo !empty($data["total"]) ? $data["total"] : ""; ?></span>
                                                        </h6>
                                                    </div>
                                                <?php }
                                                ; ?>
                                            </div>

                                            <div class="data_account data_accoun">
                                                <?php foreach ($account_data as $data) { ?>
                                                    <div class="d-none">
                                                        <p class="mt-4 pt-2 branch_lbl"><i
                                                                class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i>
                                                            <?php echo !empty($data["branch"]) ? $data["branch"] : ""; ?></p>
                                                        <h6><span
                                                                class="text-muted font-size-14  fw-bold ps-3"><?php echo !empty($data["total"]) ? $data["total"] : ""; ?></span>
                                                        </h6>
                                                    </div>
                                                <?php }
                                                ; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <div class="col-xl-7">
                        <div class="card-body card-body3">
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <h5 class="card-title me-2"><?php echo $language['Overview']; ?></h5>
                                <div class="ms-auto">
                                    <select class="form-select form-select-sm month-select">
                                        <option value="January" <?php echo ($month == "01") ? "selected" : ""; ?>>
                                            <?php echo $language['jan']; ?>
                                        </option>
                                        <option value="February" <?php echo ($month == "02") ? "selected" : ""; ?>>
                                            <?php echo $language['feb']; ?>
                                        </option>
                                        <option value="March" <?php echo ($month == "03") ? "selected" : ""; ?>>
                                            <?php echo $language['mar']; ?>
                                        </option>
                                        <option value="April" <?php echo ($month == "04") ? "selected" : ""; ?>>
                                            <?php echo $language['apr']; ?>
                                        </option>
                                        <option value="May" <?php echo ($month == "05") ? "selected" : ""; ?>>
                                            <?php echo $language['may']; ?>
                                        </option>
                                        <option value="June" <?php echo ($month == "06") ? "selected" : ""; ?>>
                                            <?php echo $language['jun']; ?>
                                        </option>
                                        <option value="July" <?php echo ($month == "07") ? "selected" : ""; ?>>
                                            <?php echo $language['jul']; ?>
                                        </option>
                                        <option value="August" <?php echo ($month == "08") ? "selected" : ""; ?>>
                                            <?php echo $language['aug']; ?>
                                        </option>
                                        <option value="September" <?php echo ($month == "09") ? "selected" : ""; ?>>
                                            <?php echo $language['sep']; ?>
                                        </option>
                                        <option value="October" <?php echo ($month == "10") ? "selected" : ""; ?>>
                                            <?php echo $language['oct']; ?>
                                        </option>
                                        <option value="November" <?php echo ($month == "11") ? "selected" : ""; ?>>
                                            <?php echo $language['nov']; ?>
                                        </option>
                                        <option value="December" <?php echo ($month == "12") ? "selected" : ""; ?>>
                                            <?php echo $language['dec']; ?>
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-sm">
                                    <div id="invested-overview" data-colors='["#5156be", "#34c38f"]' class="apex-charts">
                                    </div>
                                    <script>
                                        var income_per = <?php echo $income_per; ?>;
                                    </script>
                                </div>
                                <div class="col-sm align-self-center">
                                    <div class="mt-4 mt-sm-0 investment">
                                        <p class="mb-1"><?php echo $language['amount']; ?></p>
                                        <h4 class="invested_amount">
                                            <?php echo !empty($mdata1["total"]) || !empty($mdata2["total"]) || !empty($mdata3["total"]) ? "₹" . $mdata1["total"] + $mdata2["total"] + $mdata3["total"] : 0; ?>
                                        </h4>

                                        <p class="text-muted mb-4"></p>

                                        <div class="row g-0">
                                            <div class="col-6 income-main">
                                                <div>
                                                    <p class="mb-2 text-muted text-uppercase font-size-11">
                                                        <?php echo $language['Income2']; ?>
                                                    </p>
                                                    <h5 class="fw-medium income">
                                                        <?php echo !empty($idata["amount"]) ? "+ ₹" . $idata["amount"] : "0"; ?>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-6 expense-main">
                                                <div>
                                                    <p class="mb-2 text-muted text-uppercase font-size-11">
                                                        <?php echo $language['expense']; ?>
                                                    </p>
                                                    <h5 class="fw-medium expense">
                                                        <?php echo !empty($edata["amount"]) ? "- ₹" . $edata["amount"] : "0"; ?>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <a href="display_recent_parcels.php"
                                                class="btn btn-primary btn-sm"><?php echo $language['View_More']; ?><i
                                                    class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            ; ?>
            <!-- end col -->
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-4 col-sm-12">
                <div class="card simplebar-content2">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"><?php echo $language['report']; ?></h4>
                        <div class="flex-shrink-0">
                            <ul class="nav nav-tabs-custom card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#buy-tab"
                                        role="tab"><?php echo $language['In']; ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#sell-tab"
                                        role="tab"><?php echo $language['Out']; ?></a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body ">
                        <div class="tab-content">
                            <div class="tab-pane active" id="buy-tab" role="tabpanel">
                                <form action="print_gen.php" method="POST" class="reports_form" target="_blank">
                                    <div class="row pb-3">
                                        <div class="grup ">
                                            <label for=""><?php echo $language['Date']; ?></label>
                                            <input type="text" id="reportrange" name="FromJeneralDates"
                                                class="p-2 w-100  form-control border-primary">
                                        </div>
                                    </div>
                                    <div class="grup pb-2">
                                        <select class="form-select w-100 model_inputs" aria-label="Delivery"
                                            name="FromThisBranch" id="FromThisBranchgeneral">
                                            <?php if ($userbranchishead == "Yes") {
                                                if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") {
                                                    if (!empty($cityVar)) { ?>
                                                        <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                            <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?>
                                                                value="<?php echo $branchf; ?>">
                                                                <?php echo $branchf; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="NoBranch">No Branch Available</option>
                                                    <?php }
                                                } else { ?>
                                                    <option value="<?php echo $branchwithcode; ?>">
                                                        <?php echo $branchwithcode; ?></option>
                                                <?php }
                                                ?>
                                            <?php } else { ?>
                                                <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") { ?>
                                                    <?php if (!empty($cityVar)) { ?>
                                                        <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                            <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?>
                                                                value="<?php echo $branchf; ?>">
                                                                <?php echo $branchf; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else {
                                                        ; ?>
                                                        <option value="NoBranch">No Branch Available</option>
                                                    <?php }
                                                    ; ?>
                                                <?php } else { ?>
                                                    <option value="<?php echo $branchwithcode; ?>">
                                                        <?php echo $branchwithcode; ?></option>
                                                <?php } ?>
                                            <?php }
                                            ; ?>
                                        </select>
                                    </div>
                                    <div class="form-grup d-flex justify-content-center py-3">
                                        <input type="checkbox" class="p-2 check_boxs model_inputs" name="chrtbox"
                                            value="yes">
                                    </div>
                                    <div class="grup py-2">
                                        <h3 class="text-center"><?php echo $language['Charts2']; ?></h3>
                                    </div>
                                    <div class="form-grup d-flex justify-content-center mt-3">
                                        <button class="btn btn-success w-50 mb-2"
                                            type="submit"><?php echo $language['report2']; ?></button>
                                        <input type="hidden" name="ThisPrintMethod" id="ThisPrintMethod" value="in">
                                    </div>
                                </form>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane" id="sell-tab" role="tabpanel">
                                <form action="print_gen.php" method="POST" class="reports_form" target="_blank">
                                    <div class="row pb-3">
                                        <div class="grup ">
                                            <label for=""><?php echo $language['Date']; ?></label>
                                            <input type="text" id="reportrange1" name="FromJeneralDates"
                                                class="p-2 w-100  form-control ">
                                        </div>
                                    </div>
                                    <div class="grup pb-2">
                                        <select class="form-select w-100 model_inputs" aria-label="Delivery"
                                            name="FromThisBranch" id="FromThisBranchgeneral">
                                            <?php if ($userbranchishead == "Yes") {
                                                if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") {
                                                    if (!empty($cityVar)) { ?>
                                                        <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                            <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?>
                                                                value="<?php echo $branchf; ?>">
                                                                <?php echo $branchf; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="NoBranch">No Branch Available</option>
                                                    <?php }
                                                } else { ?>
                                                    <option value="<?php echo $branchwithcode; ?>">
                                                        <?php echo $branchwithcode; ?></option>
                                                <?php }
                                                ?>
                                            <?php } else { ?>
                                                <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") { ?>
                                                    <?php if (!empty($cityVar)) { ?>
                                                        <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                            <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?>
                                                                value="<?php echo $branchf; ?>">
                                                                <?php echo $branchf; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else {
                                                        ; ?>
                                                        <option value="NoBranch">No Branch Available</option>
                                                    <?php }
                                                    ; ?>
                                                <?php } else { ?>
                                                    <option value="<?php echo $branchwithcode; ?>">
                                                        <?php echo $branchwithcode; ?></option>
                                                <?php } ?>
                                            <?php }
                                            ; ?>
                                        </select>
                                        <input type="hidden" class="p-2 check_box model_inputs" name="pointer"
                                            value="yes">
                                    </div>
                                    <h3 class="py-1 text-center"><?php echo $language['To']; ?></h3>
                                    <div class="grup pb-2">
                                        <select class="form-select w-100 model_inputs " aria-label="Delivery"
                                            name="ToThisBranch[]" id="ToThisBranch">
                                            <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") { ?>
                                                <?php if (!empty($cityVar)) { ?>
                                                    <option selected>All Places Combined</option>
                                                    <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                        <option value="<?php echo $branchf; ?>">
                                                            <?php echo $branchf; ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } else {
                                                    ; ?>
                                                    <option value="NoBranch">No Branch Available</option>
                                                <?php }
                                                ; ?>
                                            <?php } else { ?>
                                                <option value="<?php echo $branchwithcode; ?>">
                                                    <?php echo $branchwithcode; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-grup d-flex justify-content-center mt-3">
                                        <button class="btn btn-success w-50"
                                            type="submit"><?php echo $language['report2']; ?></button>
                                        <input type="hidden" name="ThisPrintMethod" id="ThisPrintMethod" value="out">
                                    </div>
                                </form>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xl-5 col-md-5 col-sm-12">
                <div class="card">
                    <div class="card-header card-header2 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"><?php echo $language['Transactions']; ?></h4>
                        <div class="flex-shrink-0">
                            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#transactions-all-tab"
                                        role="tab">
                                        <?php echo $language['All']; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-paid-tab" role="tab">
                                        <?php echo $language['topaid']; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-topay-tab" role="tab">
                                        <?php echo $language['topay']; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-account-tab"
                                        role="tab">
                                        <?php echo $language['account']; ?>
                                    </a>
                                </li>
                            </ul>
                            <!-- end nav tabs -->
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body px-0 p-0">
                        <div class="tab-content simplebar-content1">
                            <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                                <div class="table-responsive px-3 simplebar-content1" data-simplebar
                                    style="max-height: 352px;">
                                    <table class="table align-middle  table-nowrap table-borderless">
                                        <tbody>
                                            <?php if (!empty($data_aquery)) { ?>
                                                <?php foreach ($data_aquery as $data) {
                                                    ; ?>
                                                    <tr>
                                                        <td style="width: 50px;">
                                                            <?php if ($data["type"] == "To Paid") {
                                                                ; ?>
                                                                <div class="font-size-22 text-success">
                                                                    <i class="bx bx-check-circle d-block"></i>
                                                                </div>
                                                            <?php } elseif ($data["type"] == "To Pay") {
                                                                ; ?>
                                                                <div class="font-size-22 text-danger">
                                                                    <i class="bx bx-x-circle d-block"></i>
                                                                </div>
                                                            <?php } else {
                                                                ; ?>
                                                                <div class="font-size-22 text-primary">
                                                                    <i class="bx bx-up-arrow-circle d-block"></i>
                                                                </div>
                                                            </td>
                                                        <?php }
                                                            ; ?>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['transaction_no']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['sender3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nameone"]) ? $data["nameone"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0">
                                                                    <?php echo $language['reciver3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nametwo"]) ? $data["nametwo"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0"><?php echo $language['total']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["total"]) ? $data["total"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else {
                                                echo $language['no_transactions'];
                                            }
                                            ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane" id="transactions-paid-tab" role="tabpanel">
                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                    <table class="table align-middle table-nowrap table-borderless">
                                        <tbody>
                                            <?php if (!empty($data_pquery)) { ?>
                                                <?php foreach ($data_pquery as $data) {
                                                    ; ?>
                                                    <tr>
                                                        <td style="width: 50px;">
                                                            <div class="font-size-22 text-success">
                                                                <i class="bx bx-check-circle d-block"></i>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['transaction_no']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['sender3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nameone"]) ? $data["nameone"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0">
                                                                    <?php echo $language['reciver3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nametwo"]) ? $data["nametwo"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0"><?php echo $language['total']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["total"]) ? $data["total"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else {
                                                echo $language['no_transactions'];
                                            }
                                            ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane" id="transactions-topay-tab" role="tabpanel">
                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                    <table class="table align-middle table-nowrap table-borderless">
                                        <tbody>
                                            <?php if (!empty($data_payquery)) { ?>
                                                <?php foreach ($data_payquery as $data) {
                                                    ; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="font-size-22 text-danger">
                                                                <i class="bx bx-x-circle d-block"></i>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['transaction_no']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['sender3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nameone"]) ? $data["nameone"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0">
                                                                    <?php echo $language['reciver3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nametwo"]) ? $data["nametwo"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0"><?php echo $language['total']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["total"]) ? $data["total"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else {
                                                echo $language['no_transactions'];
                                            }
                                            ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane" id="transactions-account-tab" role="tabpanel">
                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                    <table class="table align-middle table-nowrap table-borderless">
                                        <tbody>
                                            <?php if (!empty($data_acc_query)) { ?>
                                                <?php foreach ($data_acc_query as $data) {
                                                    ; ?>
                                                    <tr>
                                                        <td>
                                                            <div class="font-size-22 text-primary">
                                                                <i class="bx bx-up-arrow-circle d-block"></i>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['transaction_no']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["lrn"]) ? $data["lrn"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">
                                                                    <?php echo $language['sender3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nameone"]) ? $data["nameone"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0">
                                                                    <?php echo $language['reciver3']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["nametwo"]) ? $data["nametwo"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="text-end">
                                                                <h5 class="font-size-14 mb-0"><?php echo $language['total']; ?>
                                                                </h5>
                                                                <p class="text-muted mb-0 font-size-12">
                                                                    <?php echo !empty($data["total"]) ? $data["total"] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else {
                                                echo $language['no_transactions'];
                                            }
                                            ; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-xl-3 col-md-3 col-sm-12">
                <div class="card simplebar-content2">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"><?php echo $language['parcel_delivery']; ?></h4>
                    </div><!-- end card header -->

                    <div class="card-body px-0">
                        <div class="px-3 section-card-delivery " data-simplebar style="max-height: 352px;">
                            <ul class="list-unstyled activity-wid mb-0">
                                <?php if (!empty($delivery_data)) { ?>
                                    <?php foreach ($delivery_data as $data) { ?>
                                        <li class="activity-list activity-border">
                                            <div class="activity-icon avatar-md">
                                                <span class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                    <i class="bx bx-box font-size-24"></i>
                                                </span>
                                            </div>
                                            <div class="timeline-list-item">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 overflow-hidden me-4">
                                                        <h5 class="font-size-14 mb-1">
                                                            <?php echo !empty($data["receiver"]) ? $data["receiver"] : "" ?>
                                                        </h5>
                                                        <p class="text-truncate text-muted font-size-13">
                                                            <?php echo !empty($data["recivernumber"]) ? $data["recivernumber"] : "" ?>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 text-end me-3">
                                                        <h6 class="mb-1">
                                                            <?php echo !empty($data["collection"]) ? "₹" . $data["collection"] : "₹0" ?>
                                                        </h6>
                                                        <?php
                                                        $date = date_create($data["exitdate"]);
                                                        $final_date = date_format($date, "d-m-Y");
                                                        ?>
                                                        <div class="font-size-13">
                                                            <?php echo !empty($final_date) ? $final_date : "" ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }
                                } else {
                                    echo $language['no_delivery'];
                                }
                                ; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
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

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Plugins js-->
<script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>


<!-- dashboard init -->
<script src="assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
<script>
    $(document).ready(function () {
        $('button').on('click', function () {
            $('button').removeClass('active2');
            $(this).addClass('active2');
        });
    });
</script>

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
        $('#reportrange1 span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
    }

    $('#reportrange1').daterangepicker({
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
</body>

</html>