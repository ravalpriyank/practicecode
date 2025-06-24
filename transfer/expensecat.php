<?php require_once('layouts/mainheader.php'); ?>

<head>
    <title><?php echo $language['Expense']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>

    <link href="assets/libs/@fullcalendar/core/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/@fullcalendar/daygrid/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/@fullcalendar/bootstrap/main.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/@fullcalendar/timegrid/main.min.css" rel="stylesheet" type="text/css" />

    <?php require_once('layouts/stylescript/head-style.php'); ?>
</head>

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
                            <h4 class="mb-sm-0 font-size-18"><?php echo $language['Expense']; ?></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                                    <li class="breadcrumb-item active"><a
                                            href="expense.php"><?php echo $language['Expense']; ?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $language['ExpenseCat']; ?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-xl-3 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid">
                                            <button class="btn font-16 btn-primary"
                                                id="btn-new-event"><?php echo $language['AddExpense']; ?></button>
                                        </div>
                                        <div class="p-4">
                                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Expense Category</label>
                                                            <input class="form-control"
                                                                placeholder="Insert Category Name" type="text"
                                                                name="title" id="event-title" required value="" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Category Color</label>
                                                            <select class="form-control form-select" name="category"
                                                                id="event-category">
                                                                <option selected> --Select-- </option>
                                                                <option class="bg-danger" value="bg-danger"></option>
                                                                <option class="bg-success" value="bg-success"></option>
                                                                <option class="bg-primary" value="bg-primary"></option>
                                                                <option class="bg-info" value="bg-info"></option>
                                                                <option class="bg-dark" value="bg-dark"></option>
                                                                <option class="bg-warning" value="bg-warning"></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <button type="submit" class="btn btn-success"
                                                            id="btn-save-event">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-xl-9 col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="catag-table"></div>
                                    </div>
                                </div>
                            </div> <!-- end col -->

                        </div>

                        <div style='clear:both'></div>

                    </div>
                </div>

            </div> <!-- container-fluid -->
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

<script src="assets/libs/@fullcalendar/core/main.min.js"></script>
<script src="assets/libs/@fullcalendar/bootstrap/main.min.js"></script>
<script src="assets/libs/@fullcalendar/daygrid/main.min.js"></script>
<script src="assets/libs/@fullcalendar/timegrid/main.min.js"></script>
<script src="assets/libs/@fullcalendar/interaction/main.min.js"></script>

<!-- Calendar init -->
<script src="assets/js/pages/calendar.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>