<?php
require_once("layouts/mainheader.php");
require_once("connection.php"); 

$lrno = !empty($_GET["lr_no"]) ? $_GET["lr_no"] : "";
$time = !empty($_GET["time"]) ? date_create($_GET["time"]) : "";
$date = !empty($time) ? date_format($time, "Y-m-d H:i:s") : "";

$query = "SELECT * FROM `transportz` WHERE `lrn` = '$lrno' AND `timestamp` ='$date' AND `branch` = '$userbranch'";
$run_query = mysqli_query($conn2, $query);
$data = mysqli_fetch_assoc($run_query);

$total_item = isset($data["item"]) ? count(explode(",", $data["item"])) : "";

$bquery = "SELECT * FROM `parcel_companies`";
$run_bquery = mysqli_query($conn1, $bquery);
$bdata = mysqli_fetch_assoc($run_bquery);

?>

<head>
    <title><?php echo $language["Transport"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/custome.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .title-bar {
            position: relative;
            width: 100%;
            height: 2in;
            overflow: hidden;
        }

        .grass {
            position: absolute;
            bottom: 50px;
            width: 400%;
            height: 50px;
            background: #228B22;
            animation: moveBackground 20s linear infinite;
            z-index: 1;
        }

        .road {
            position: absolute;
            bottom: 50px;
            width: 400%;
            height: 50px;
            background: #333;
            animation: moveBackground 20s linear infinite;
            z-index: 2;
        }

        .lane-markings {
            position: absolute;
            bottom: 70px;
            width: 400%;
            height: 5px;
            background: repeating-linear-gradient(to right,
                    #fff 0px,
                    #fff 40px,
                    #333 30px,
                    #333 60px);
            animation: moveBackground 20s linear infinite;
            z-index: 3;
        }

        .trees {
            position: absolute;
            bottom: 87px;
            width: 400%;
            height: 100px;
            display: flex;
            gap: 100px;
            animation: moveBackground 20s linear infinite;
            z-index: 4;
        }

        .tree {
            width: 80px;
            height: auto;
        }

        @keyframes moveBackground {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* Truck */
        .truck-container {
            position: absolute;
            bottom: 5px;
            left: 50px;
            width: 300px;
            z-index: 5;
        }

        .truck {
            width: 100%;
            height: auto;
        }


        .logobar {
            position: absolute;
            top: 63px;
            left: 60px;
            width: auto;
            height: 40px;
        }
        .error {
            color: red;
        }
    </style>

</head>

<?php
require_once("layouts/main/body.php");
require_once("layouts/header/transporta.php");
require_once("layouts/logic/transportlogic.php");
?>

<div id="layout-wrapper">
    <?php require_once('layouts/menu/menu.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <?php
            if ($bdata["isBranch"] == "no") {
                echo "<h5>No Branch Available</h5>"; ?>
                <div>
                    <a href="branch_setting.php?first=true" class="btn btn-primary mt-3 ">Create Branch</a>
                </div>
                <?php
            } else {
                ?>
                <div class="container-fluid">
                    <div class="title pt-2 text-center ">
                        <div class="title-bar">
                            <!-- Trees -->
                            <div class="trees">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                                <img src="banner/Forest.svg" alt="Tree" class="tree">
                                <img src="banner/Tree.svg" alt="Tree" class="tree">
                                <img src="banner/Tree2.svg" alt="Tree" class="tree">
                            </div>
                            <div class="grass"></div>
                            <div class="road"></div>
                            <div class="lane-markings"></div>
                            <div class="truck-container">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" enable-background="new 0 0 512 512"
                                    height="200" viewBox="0 0 512 512" width="300">
                                    <path
                                        d="m373.665 333.938h126.796c2.169 0 3.928-1.758 3.928-3.928v-97.242c0-.895-.306-1.763-.866-2.461l-36.916-45.923c-.746-.927-1.871-1.467-3.061-1.467h-85.952c-2.169 0-3.928 1.758-3.928 3.928v147.093z"
                                        fill="#61a2f9" />
                                    <path
                                        d="m463.545 182.917h-21.792l38.962 48.468v102.553h19.747c2.169 0 3.928-1.759 3.928-3.928v-97.242c0-.895-.306-1.763-.866-2.461l-36.916-45.923c-.748-.928-1.873-1.467-3.063-1.467z"
                                        fill="#5490f9" />
                                    <path
                                        d="m7.258 333.938h366.407v-27.458h-366.407c-4.009 0-7.258 3.25-7.258 7.258v12.942c0 4.009 3.249 7.258 7.258 7.258z"
                                        fill="#eaeaea" />
                                    <path d="m352.172 306.48h21.493v27.458h-21.493z" fill="#dfdfdf" />
                                    <path
                                        d="m504.388 232.768v1.238h-71.211c-3.673 0-6.65-2.977-6.65-6.65v-18.609c0-3.673 2.977-6.65 6.65-6.65h47.667l22.677 28.211c.562.697.867 1.565.867 2.46z"
                                        fill="#b1e4f9" />
                                    <path
                                        d="m480.845 202.097h-23.675l23.544 29.288v2.621h23.674v-1.238c0-.895-.306-1.763-.866-2.461z"
                                        fill="#90d8f9" />
                                    <path
                                        d="m504.388 306.766h-12.748c-4.204 0-7.612-3.407-7.612-7.611s3.407-7.612 7.612-7.612h12.748c4.204 0 7.611 3.407 7.611 7.612s-3.407 7.611-7.611 7.611z"
                                        fill="#f9ef63" />
                                    <circle cx="439.327" cy="336.068" fill="#595959" r="29.588" />
                                    <path
                                        d="m439.328 344.45c-4.204 0-7.612-3.407-7.612-7.611v-1.54c0-4.204 3.407-7.612 7.612-7.612s7.611 3.407 7.611 7.612v1.54c0 4.204-3.407 7.611-7.611 7.611z"
                                        fill="#eaeaea" />
                                    <circle cx="155.1" cy="336.068" fill="#595959" r="29.588" />
                                    <path
                                        d="m155.1 344.45c-4.204 0-7.611-3.407-7.611-7.611v-1.54c0-4.204 3.407-7.612 7.611-7.612s7.611 3.407 7.611 7.612v1.54c0 4.204-3.407 7.611-7.611 7.611z"
                                        fill="#eaeaea" />
                                    <circle cx="313.536" cy="336.068" fill="#595959" r="29.588" />
                                    <path
                                        d="m313.536 344.45c-4.204 0-7.612-3.407-7.612-7.611v-1.54c0-4.204 3.407-7.612 7.612-7.612s7.611 3.407 7.611 7.612v1.54c0 4.204-3.407 7.611-7.611 7.611z"
                                        fill="#eaeaea" />
                                    <circle cx="69.791" cy="336.068" fill="#595959" r="29.588" />
                                    <path
                                        d="m69.792 344.45c-4.204 0-7.611-3.407-7.611-7.611v-1.54c0-4.204 3.407-7.612 7.611-7.612s7.611 3.407 7.611 7.612v1.54c0 4.204-3.407 7.611-7.611 7.611z"
                                        fill="#eaeaea" />
                                    <path
                                        d="m319.516 280.755h-311.622c-4.36 0-7.894-3.534-7.894-7.894v-118.624c0-4.36 3.534-7.894 7.894-7.894h311.622c4.36 0 7.894 3.534 7.894 7.894v118.624c.001 4.359-3.534 7.894-7.894 7.894z"
                                        fill="#b1b1b1" />
                                </svg>
                                <img src="<?php echo !empty($companylogof) ? $companylogof : "assets/images/logo-sm.svg"; ?>"
                                    alt="Logo" class="logobar" height="24">
                            </div>
                        </div>
                        <h3 class=" mb-4">
                            <?php echo !empty($companynamef) ? $companynamef : "Parcel Transport Service"; ?>
                        </h3>
                    </div>
                    <!-- Bread Cump -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card" style="width: 98%;">
                                <div class="card-header align-items-center d-flex">
                                    <div class="lr_wrap flex-grow-1 d-flex align-items-center  gap-2">
                                        <h1 class="mb-0 "> <span
                                                class="bg-success border border-success rounded ps-4 pe-4 text-white">
                                                <?php echo isset($_GET["lr_no"]) ? $_GET["lr_no"] : $lastnumber; ?>
                                            </span></h1>
                                        <form action="#" method="POST" class="get_customer">
                                            <div class="relation_id">
                                                <input type="text" class="form-control p-3" name="relation_no"
                                                    id="relation_no" placeholder="Enter Relation Id">
                                                <input type="submit" id="submit" class="submit d-none">
                                            </div>
                                        </form>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <ul class="nav nav-tabs-custom card-header-tabs pr-4" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="jamabakibutton"
                                                    href="transport.php?page=transport">
                                                    <?php echo $language['topay'] . "/" . $language['topaid']; ?>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" href="gst-module.php?page=gst" id="gstbutton">
                                                    <?php echo $language['gst']; ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="ml-2" style="margin-left: 25px;">
                                        <button class="btn btn-danger delete" id="removeRows" type="button">-</button>
                                        <button class="btn btn-success" id="addRows" type="button">+</button>
                                        <button class="btn btn-dark" id="manual" type="button">M</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <?php require_once('layouts/form/transportentry.php'); ?>
                                    </div>
                                    <!-- end tab content -->
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
                <div>
                    <?php require_once("bill_receipt_modals.php"); ?>
                </div>
            <?php }
            ; ?>
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

<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<?php require_once('layouts/footer/transportb.php'); ?>

<script>
    window.addEventListener("load", function () {
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    });
</script>

</body>

</html>