<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    li i {
        font-size: 18px !important;
    }
</style>

<body>
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center bg-dark p-3">

                <h5 class="m-0 me-2 text-white"><?php echo $language['setting']; ?></h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="m-0" />

            <div class="p-3">
                <div class="setting_option">
                    <ul class="list-group border-0">
                        <a href="company_setting.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class="fa-solid fa-gears"></i>
                                <p class="m-0 fw-bold"><?php echo $language['Company_Settings']; ?></p>
                            </li>
                        </a>
                        <a href="bill_receipt_setting.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i data-feather="printer"></i>
                                <p class="m-0 fw-bold"><?php echo $language['Print_Settings']; ?></p>
                            </li>
                        </a>
                        <a href="driver_cunductor_setting.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class="fa-solid fa-user-group"></i>
                                <p class="m-0 fw-bold"><?php echo $language['Driver_Conductor']; ?></p>
                            </li>
                        </a>
                        <a href="branch_setting.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class="fa-solid fa-network-wired"></i>
                                <p class="m-0 fw-bold"><?php echo $language['Branch_Setting']; ?></p>
                            </li>
                        </a>
                        <a href="acc_holders_setting.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class="fa-solid fa-circle-user"></i>
                                <p class="m-0 fw-bold"><?php echo $language['Account_holders']; ?></p>
                            </li>
                        </a>
                        <a href="parcel_members_setting.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class="fa-solid fa-users"></i>
                                <p class="m-0 fw-bold"><?php echo $language['Staf_Members']; ?></p>
                            </li>
                        </a>
                        <a href="additional_field_setting.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class='bx bx-task'></i>
                                <p class="m-0 fw-bold"><?php echo $language['additional']; ?></p>
                            </li>
                        </a>
                        <a href="item_entry.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class='bx bxs-add-to-queue'></i>
                                <p class="m-0 fw-bold"><?php echo $language['item_setting']; ?></p>
                            </li>
                        </a>
                        <a href="add_new_member.php">
                            <li class="list-group-item border-0 d-flex align-items-center gap-3">
                                <i class='bx bx-user-plus' style="font-size:25px!important"></i>
                                <p class="m-0 fw-bold"><?php echo $language['add_member']; ?></p>
                            </li>
                        </a>
                    </ul>
                </div>
            </div>

        </div> <!-- end slimscroll-menu-->
    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

</body>

</html>