<?php
require_once("connection.php");
require_once("layouts/core/mainconstants.php");
$username = !empty($_SESSION["username"]) ? $_SESSION["username"] : "";
$query = "SELECT * FROM `users` WHERE `username` = '$username'";
$run_query = mysqli_query($conn2, $query);
$user_data = mysqli_fetch_assoc($run_query);

if (isset($_GET["page"]) && !empty($_GET["page"])) {
    if ($_GET["page"] == "transport") {
        $page = "transport";
    } else {
        $page = "gst";
    }
} else {
    $page = null;
}

?>

<head>
    <link rel="stylesheet" href="assets/css/app.min.css">
</head>
<style>
    .open {
        padding: 0 !important;
        width: 15px !important;
        height: 15px !important;
        font-size: 17px !important;
    }

    .ruppy {
        font-size: 22px !important;
    }

    .set_active {
        color: #5156be !important
    }
</style>
<header id="page-topbar">
    <div class="navbar-header p-0">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo !empty($companylogof) ? $companylogof : "assets/images/logo-sm.svg"; ?>"
                            alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo !empty($companylogof) ? $companylogof : "assets/images/logo-sm.svg"; ?>"
                            alt="" height="24"> <span class="logo-txt d">GT
                            Solution</span>
                    </span>
                </a>

                <a href="index.php" class="logo logo-light ">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt d-none">GT
                            Solution</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form action="display_lr_details.php" method="POST" id="search_by_lr" class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control lr_number" name="lr_number" id="lr_number"
                        placeholder="<?php echo $language["Search"]; ?>">
                    <button class="btn btn-primary search_lr" type="submit"><i
                            class="bx bx-search-alt align-middle"></i></button>
                    <label style="color:red;display:none;" id="lr_error">* Invalid LR Format *</label>

                </div>
            </form>
        </div>

        <h3><?php echo !empty($userbranch) ? $userbranch : ""; ?></h3>
        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php echo $language["Search"]; ?>"
                                    aria-label="Search Result">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="div">
                <a href="track_parcel.php">
                    <i class="fa-solid fa-magnifying-glass-location p-3 mt-2" style='font-size:26px'></i>
                </a>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php if ($lang == 'en') { ?>
                        <img class="me-2" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                    <?php } ?>
                    <?php if ($lang == 'gu') { ?>
                        <img class="me-2" src="assets/images/flags/gu.png" alt="Header Language" height="16">
                    <?php } ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="?lang=en&page=<?php echo $page; ?>" class="dropdown-item notify-item language">
                        <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle"> English </span>
                    </a>

                    <!-- item-->
                    <a href="?lang=gu&page=<?php echo $page; ?>" class="dropdown-item notify-item language">
                        <img src="assets/images/flags/gu.png" alt="user-image" class="me-1" height="12"> <span
                            class="align-middle"> Gujarati </span>
                    </a>
                </div>
            </div>

            <?php if ($userrollpost == "Admin" || $userrollpost == "SuperAdmin" || $userrollpost == "SuperDuperAdmin") { ?>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item right-bar-toggle me-2">
                        <i data-feather="settings" class="icon-lg"></i>
                    </button>
                </div>
            <?php }
            ; ?>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?php echo $user_data["user_profile"]; ?>"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?php echo ucfirst($currentuser); ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="userprofile.php"><i
                            class="mdi mdi-face-profile font-size-16 align-middle me-1"></i>
                        <?php echo $language["Profile"]; ?></a>
                    <a class="dropdown-item" href="userlockscreen.php"><i
                            class="mdi mdi-lock font-size-16 align-middle me-1"></i>
                        <?php echo $language["Lock_screen"]; ?> </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i
                            class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                        <?php echo $language["Logout"]; ?></a>
                </div>
            </div>

        </div>
    </div>
</header>

<div class="vertical-menu position-fixed">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?php echo $language["Menu"]; ?></li>
                <li>
                    <a href="index.php">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard"><?php echo $language["Dashboard"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="transport.php"
                        class="parcels <?php echo isset($_GET) && isset($_GET["page"]) == 'gst' ? 'set_active' : '' ?>">
                        <i data-feather="package"
                            class="<?php echo isset($_GET) && isset($_GET["page"]) == 'gst' ? 'set_active' : '' ?>"></i>
                        <span data-key="t-dashboard"><?php echo $language["Transport"]; ?></span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-rupee ruppy"></i>
                        <span data-key="t-apps"><?php echo $language['incomeexpense']; ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="expense.php">
                                <span data-key="t-calendar"><?php echo $language['Expense']; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="income.php">
                                <span data-key="t-calendar"><?php echo $language['Income']; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="dispatch.php">
                        <i data-feather="truck"></i>
                        <span data-key="t-dashboard"><?php echo $language["Dispatch"]; ?></span>
                    </a>
                </li>
                <li>
                    <a href="user_account.php">
                        <i data-feather="user"></i>
                        <span data-key="t-user-account"><?php echo $language["account"]; ?></span>
                    </a>
                </li>
                <li>
                    <a href="display_recent_parcels.php">
                        <i class="fa fa-box-open open"></i>
                        <span data-key="t-user-account"><?php echo $language["Parcels"]; ?></span>
                    </a>
                </li>
                <li>
                    <a href="display_print_reports.php">
                        <i class="fa-solid fa-book"></i>
                        <span data-key="t-user-account"><?php echo $language["Reports"]; ?></span>
                    </a>
                </li>
                <li>
                    <a href="relation_management.php">
                        <i class="fa-solid fa-users"></i>
                        <span data-key="t-user-account"><?php echo $language['relation_management']; ?></span>
                    </a>
                </li>
                <li>
                    <a href="track_parcel.php">
                        <i class="fa-solid fa-magnifying-glass-location"></i>
                        <span data-key="t-user-account"><?php echo $language['track_parcel']; ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>