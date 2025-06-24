<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="pull-up navbar-brand" href="index.php"><img src="<?php echo $companylogof; ?>" height="28px" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse font-weight-bolder" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if ($_SESSION['loggedin'] == false) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><?php echo $Str_Login; ?></a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['loggedin'] == true) { ?>
                <span style="margin-left:10px;"></span>
                <li class="nav-item border-white">
                    <a class="nav-link" href="transport.php"><i class="la la-gift"></i> <?php echo $Str_Transport; ?> </a>

                </li>
                <li class="nav-item  border-white border-left-0">
                    <a class="nav-link" href="dispatch.php"><i class="la la-truck"></i> <?php echo $Str_dispatch; ?> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="accountinfo.php" target="_blank" rel="noopener noreferrer"><i
                            class="la la-male"></i>Accounts</a>
                </li>
                <span style="margin-left:10px;"></span>
                <li class="dropdown nav-item form-inline my-2 my-lg-0" data-menu="dropdown"><a
                        class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i
                            class="la la-credit-card"></i><span data-i18n="Profiles">
                            <?php echo "Income-Expense"; ?></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="pull-up dropdown-item" href="expense.php"><?php echo "Expense"; ?> </a>
                        </li>
                        <li>
                            <a class="pull-up dropdown-item" href="income.php"><?php echo "Income"; ?> </a>
                        </li>
                        <li><a class="pull-up dropdown-item" href="maintenance.php"><i class="la la-check-circle-o"></i>
                                <?php echo $Str_Maintenance; ?> </a></li>
                        <li><a class="pull-up dropdown-item" href="salary.php"><i class="la la-dollar"></i>
                                <?php echo $Str_Salary; ?> </a></li>
                    </ul>
                </li>
                <?PHP if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin")) { ?>
                    <span style="margin-left:10px;"></span>
                    <li class="nav-link">
                        |
                    </li>
                    <span style="margin-left:10px;"></span>
                    <li class="dropdown nav-item form-inline my-2 my-lg-0" data-menu="dropdown"><a
                            class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-cog"></i><span
                                data-i18n="Accounts"> <?php echo $Str_Settings; ?></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="pull-up dropdown-item" href="setting.php"><i class="la la-cogs"></i>
                                    <?php echo $Str_Company_Settings; ?></a></li>

                            <li data-menu=""><a class="pull-up dropdown-item" href="settingprint.php"><i
                                        class="la la-print"></i> <?php echo "Print Settings"; ?></a></li>

                            <li data-menu=""><a class="pull-up dropdown-item" href="thirdparty.php"><i class="la la-users"></i>
                                    <?php echo $Str_Driver_Conductor; ?></a></li>
                            <li data-menu=""><a class="pull-up dropdown-item" href="item.php"><i class="la la-gift"></i>
                                    <?php echo $Str_Items_Setting; ?></a></li>
                            <li data-menu=""><a class="pull-up dropdown-item" href="branch.php"><i class="la la-ship"></i>
                                    <?php echo $Str_Branch_Setting; ?> </a></li>
                            <li data-menu=""><a class="pull-up dropdown-item" href="khatarepair.php"><i class="la la-tasks"></i>
                                    <?php echo "Account Holders"; ?> </a></li>
                            <li data-menu=""><a class="pull-up dropdown-item" href="staff.php"><i class="la la-bank"></i><span
                                        data-i18n="NewCompany"> <?php echo $Str_Staf_Members; ?></span></a></li>
                        </ul>
                    </li>
                <?PHP } ?>
                <span style="margin-left:10px;"></span>
                <span style="margin-left:10px;"></span>
                <li class="dropdown nav-item form-inline my-2 my-lg-0" data-menu="dropdown"><a
                        class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-user"></i><span
                            data-i18n="Profiles"> <?php echo $Str_Profile; ?></span></a>
                    <ul class="dropdown-menu">
                        <li data-menu=""><a class="pull-up dropdown-item" href="changepw.php"><i class="la la-key"></i><span
                                    data-i18n="ChangePw"> <?php echo $Str_Change_Password; ?></span></a></li>
                        <li data-menu=""><a class="pull-up dropdown-item" href="logout.php"><i class="ft-power"></i><span
                                    data-i18n="Logout"> <?php echo $Str_Logout; ?></span></a></li>
                    </ul>
                </li>
            </ul>
            <form action="transport.php" method="POST" class="btn-group text-center float-right mt-50 align-middle">
                <input placeholder="LR Number" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                    name="AddDeliveryNow" id="AddDeliveryNowTitle">
                <button type="submit" class='btn btn-success btn-group btn-lg' value="deliveryAddDetail"
                    name="deliveryAddDetail"><?php echo " " . $Str_DeliveryFind; ?></button>
            </form>
        <?php } ?>
    </div>
</nav>