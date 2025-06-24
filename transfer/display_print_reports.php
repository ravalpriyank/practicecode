<?php
require_once ("layouts/mainheader.php");
require_once ("connection.php");
require_once ("main_const.php");
if($userrollpost == "CityAdmin")
{
    $cityVar = $CityBranch;
}
else
{
    $cityVar = $allbranchlist;
}
?>

<head>
    <title><?php echo $language["Reports"]; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/lr_detail.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="assets/js/custome.js"></script>

</head>

<?php require_once('layouts/main/body.php');
require_once('layouts/header/transporta.php');
require_once('layouts/logic/transportlogic.php');
?>

<div id="layout-wrapper">
    <?php require_once 'layouts/menu/menu.php'; ?>
    <div class="main-content">
        <div class="page-content ">
            <div class="container-fluid">
                <h2 class="text-center"><?php echo $language['report3']  ;?></h2><hr>
                <?php if (($userrollpost == "SuperAdmin") || ($userrollpost == "SuperDuperAdmin") || ($userrollpost == "Admin") || ($userrollpost == "CityAdmin") || ($userrollpost == "Office")) { ?>
                    <div class="row ">
                        <div class="col-lg-6">
                            <form action="print_gen.php" method="POST" class="reports_form h-100 mt-3" target="_blank">
                                <h3 class="text-primary text-center pb-2 pt-2"><?php echo $language["Reports"];?></h3>
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="grup">
                                            <label for=""><?php echo $language['Date'] ;?></label>
                                            <input type="text" name="FromJeneralDates" id="reportrange"
                                                class="p-2 w-100 model_inputs form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="grup">
                                            <label for=""> <?php echo $language['SelectOpt'] ;?> :</label>
                                            <select class="form-select w-100 model_inputs " aria-label="Delivery"
                                                name="ThisPrintMethod" id="ThisPrintMethodinGeneral">
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
                                <div class="row section_one section_out pt-4 pb-3">
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <div class="grup">
                                            <select class="form-select w-100 model_inputs" aria-label="Delivery"
                                                name="FromThisBranch" id="FromThisBranchgeneral">
                                                <?php if ($userbranchishead == "Yes") {
                                                    if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") {
                                                        if (!empty($cityVar)) { ?>
                                                            <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                    <?php echo $branchf; ?>
                                                                </option>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <option value="NoBranch">No Branch Available</option>
                                                        <?php }
                                                    } else { ?>
                                                        <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                    <?php }
                                                    ?>
                                                <?php } else { ?>
                                                    <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") { ?>
                                                        <?php if (!empty($cityVar)) { ?>
                                                            <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                    <?php echo $branchf; ?>
                                                                </option>
                                                            <?php } ?>
                                                        <?php } else {
                                                            ; ?>
                                                            <option value="NoBranch">No Branch Available</option>
                                                        <?php }
                                                        ; ?>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                    <?php } ?>
                                                <?php }
                                                ; ?>
                                            </select>
                                            <input type="hidden" class="p-2 check_box model_inputs" name="pointer"
                                                value="yes">
                                        </div>
                                    </div>
                                    <div
                                        class="col-lg-2 p-0 col-md-2 col-sm-12 d-flex align-items-center justify-content-center">
                                        <h4 class="pt-2"><?php echo $language['To'] ;?></h4>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <div class="grup">
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
                                                    <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4 section_two section_in">
                                    <div class="col-lg-5">
                                        <div class="grup">
                                            <select class="form-select w-100 model_inputs" aria-label="Delivery"
                                                name="FromThisBranch" id="FromThisBranchgeneral">
                                                <?php if ($userbranchishead == "Yes") {
                                                    if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") {
                                                        if (!empty($cityVar)) { ?>
                                                            <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                    <?php echo $branchf; ?>
                                                                </option>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <option value="NoBranch">No Branch Available</option>
                                                        <?php }
                                                    } else { ?>
                                                        <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                    <?php }
                                                    ?>
                                                <?php } else { ?>
                                                    <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") { ?>
                                                        <?php if (!empty($cityVar)) { ?>
                                                            <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                    <?php echo $branchf; ?>
                                                                </option>
                                                            <?php } ?>
                                                        <?php } else {
                                                            ; ?>
                                                            <option value="NoBranch">No Branch Available</option>
                                                        <?php }
                                                        ; ?>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                    <?php } ?>
                                                <?php }
                                                ; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <div class="check-box">
                                            <input type="checkbox" class="p-2 check_boxs model_inputs" name="chrtbox"
                                                value="yes">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h3>chart</h3>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center py-2">
                                    <input type="checkbox" name="gst" id="gst" class="gst check_box"><h4 for="" class="m-0 ms-3">GST</h4>
                                </div>
                                <div class="pt-4 pb-3 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success w-50"> <?php echo !empty($language["report2"]) ? $language["report2"] : "" ;?></button>
                                </div>
                            </form>
                        </div>
                        <?php if($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin"){?>
                        <div class="col-lg-6">
                            <form action="city_bulk_info.php" method="POST" class="reports_form h-100 mt-3" target="_blank">
                                <h3 class="text-primary text-center pb-1 pt-2"><?php echo $language["City_Reports"] ;?></h3>
                                <div class="row">
                                    <div class="grup">
                                        <label for=""><?php echo $language['Date'] ;?></label>
                                        <input type="text" id="printcityrange" name="FromJeneralDates"
                                            class="p-2 w-100 model_inputs">
                                    </div>
                                </div>
                                <div class="row pt-4 pb-4">
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <div class="grup">
                                            <select name="FromThisCity" id="FromThisCity"
                                                class="form-control FromThisCity border border-primary">
                                                <?php 
                                                    if($userrollpost != "CityAdmin"){
                                                    if(isset($cityList)){
                                                    foreach ($cityList as $city) { ?>
                                                    <option value="<?php echo $city; ?>">
                                                        <?php echo $city; ?>
                                                    </option>
                                                <?php }}else{ ?>
                                                    <option value="not">No City Available</option>
                                                <?php }}else{ ;?>
                                                    <option value="<?php echo $currentUserCity ;?>"><?php echo $currentUserCity ;?></option>
                                                <?php } ;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-center justify-content-center">
                                        <h4 class="pt-2 p-0"><?php echo $language['To'] ;?></h4>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <div class="grup ">
                                            <select name="ToThisCity" id="ToThisBranchgeneral"
                                                class="form-control ToThisCity align-middle border border-primary">
                                                <?php 
                                                    if(isset($cityList)){
                                                    foreach ($cityList as $city) { ?>
                                                    <option value="<?php echo $city; ?>">
                                                        <?php echo $city; ?>
                                                    </option>
                                                <?php }}else{ ?>
                                                    <option value="not">No City Available</option>
                                                <?php } ;?>
                                            </select>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center py-2 mt-3">
                                          <input type="checkbox" name="gst" id="gst" class="gst check_box"><h4 for="" class="ms-3 m-0">GST</h4>
                                    </div>
                                </div>
                               
                                  <div class="pt-2 pb-3 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success w-50"><?php echo !empty($language["print"]) ? $language["print"] : "" ;?></button>
                                    </div>
                            </form>
                        </div>
                        <?php };?>
                        <div class="col-lg-6 pe-0 <?php echo $userrollpost == "Office" ? "" : "d-none" ;?>">
                                <form action="print_bulk_info.php" method="POST" class="reports_form mt-3 h-100 " target="_blank">
                                    <h3 class="text-primary text-center pb-1 pt-2"><?php echo $language["print"]." LR ".$language["Reports"] ;?></h3>
                                    <div class="row">
                                        <div class="grup">
                                            <label for=""><?php echo $language['Date'] ;?></label>
                                            <input type="text" id="printrange2" name="FromJeneralDates"
                                                class="p-2 w-100 model_inputs">
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="grup">
                                                <select name="FromThisBranch" id="FromThisBranch"
                                                    class="form-control border border-primary">
                                                    <?php 
                                                        if(isset($allbranchlist)){
                                                        foreach (array_unique($allbranchlist) as $branchf) { ?>
                                                        <option value="<?php echo $branchf; ?>">
                                                            <?php echo $branchf; ?>
                                                        </option>
                                                    <?php }}else{ ?>
                                                        <option value="not">No Branch Available</option>
                                                    <?php } ;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-center justify-content-center">
                                            <h4 class="pt-2 p-0"><?php echo $language['To'] ;?></h4>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="grup">
                                                <select name="ToThisBranch" id="ToThisBranchgeneral"
                                                    class="form-control align-middle border border-primary">
                                                    <?php if ($userbranchishead == "Yes") {
                                                        if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") {
                                                            if (!empty($cityVar)) { ?>
                                                                <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                    <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                        <?php echo $branchf; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <option value="NoBranch">No Branch Available</option>
                                                            <?php }
                                                        } else { ?>
                                                            <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                        <?php }
                                                        ?>
                                                    <?php } else { ?>
                                                        <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") { ?>
                                                            <?php if (!empty($cityVar)) { ?>
                                                                <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                    <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                        <?php echo $branchf; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            <?php } else {
                                                                ; ?>
                                                                <option value="NoBranch">No Branch Available</option>
                                                            <?php }
                                                            ; ?>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                        <?php } ?>
                                                    <?php } ;?>
                                                </select>
    
                                            </div>
                                        </div>
                                        <div class="row align-middle d-none">
                                            <div class="col-sm-12 align-middle">
                                                <select name="ThisPrintMethod" id="ThisPrintMethod"
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

                                        <div class="d-flex align-items-center justify-content-center py-3">
                                            <input type="checkbox" name="gst" id="gst" class="gst  m-0 check_box" ><h4 for="" class="m-0 ps-2">GST</>
                                        </div>
                                        <div class="pt-2 pb-3 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-success w-50"> LR <?php echo !empty($language["print"]) ? $language["print"] : "" ;?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <div class="row mt-5">
                            <div class="col-lg-6 pe-0 <?php echo $userrollpost == "Office" ? "d-none" : "" ;?>">
                                <form action="print_bulk_info.php" method="POST" class="reports_form h-100 " target="_blank">
                                    <h3 class="text-primary text-center pb-1 pt-2"><?php echo $language["print"]." LR ".$language["Reports"] ;?></h3>
                                    <div class="row">
                                        <div class="grup">
                                            <label for=""><?php echo $language['Date'] ;?></label>
                                            <input type="text" id="printrange" name="FromJeneralDates"
                                                class="p-2 w-100 model_inputs">
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="grup">
                                                <select name="FromThisBranch" id="FromThisBranch"
                                                    class="form-control border border-primary">
                                                    <?php 
                                                        if(isset($cityVar)){
                                                        foreach (array_unique($cityVar) as $branchf) { ?>
                                                        <option value="<?php echo $branchf; ?>">
                                                            <?php echo $branchf; ?>
                                                        </option>
                                                    <?php }}else{ ?>
                                                        <option value="not">No Branch Available</option>
                                                    <?php } ;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-2 col-md-2 col-sm-12 d-flex align-items-center justify-content-center">
                                            <h4 class="pt-2 p-0"><?php echo $language['To'] ;?></h4>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="grup">
                                                <select name="ToThisBranch" id="ToThisBranchgeneral"
                                                    class="form-control align-middle border border-primary">
                                                    <?php if ($userbranchishead == "Yes") {
                                                        if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") {
                                                            if (!empty($cityVar)) { ?>
                                                                <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                    <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                        <?php echo $branchf; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <option value="NoBranch">No Branch Available</option>
                                                            <?php }
                                                        } else { ?>
                                                            <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                        <?php }
                                                        ?>
                                                    <?php } else { ?>
                                                        <?php if ($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin") { ?>
                                                            <?php if (!empty($cityVar)) { ?>
                                                                <?php foreach (array_unique($cityVar) as $branchf) { ?>
                                                                    <option <?php if ($branchf == $branchwithcode) { ?>selected<?php } ?> value="<?php echo $branchf; ?>">
                                                                        <?php echo $branchf; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            <?php } else {
                                                                ; ?>
                                                                <option value="NoBranch">No Branch Available</option>
                                                            <?php }
                                                            ; ?>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $branchwithcode; ?>"><?php echo $branchwithcode; ?></option>
                                                        <?php } ?>
                                                    <?php } ;?>
                                                </select>
    
                                            </div>
                                        </div>
                                        <div class="row align-middle d-none">
                                            <div class="col-sm-12 align-middle">
                                                <select name="ThisPrintMethod" id="ThisPrintMethod"
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
                                        <div class=" pt-3 d-flex gap-3 align-items-center justify-content-center">
                                            <!-- <div class="">
                                                <div class="check-box">
                                                    <input type="checkbox" name="gstbillonly" class="p-2 check_box" value="Yes"
                                                        id="gstbillonly">
                                                </div>
                                            </div>
                                            <div class="">
                                                <h5>માત્ર જીએસટી રસીદ</h5>
                                            </div> -->
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center py-3">
                                            <input type="checkbox" name="gst" id="gst" class="gst  m-0 check_box" ><h4 for="" class="m-0 ps-2">GST</>
                                        </div>
                                        <div class="pt-2 pb-3 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-success w-50"> LR <?php echo !empty($language["print"]) ? $language["print"] : "" ;?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
    
                   <h2 class="pt-5 text-center"><?php echo $language['delivery_report'] ;?></h2><hr>
                        <div class="row mb-3"   style="margin-top: 20px;">
                            <div class="col-lg-6 col-md-12 col-sm-12 ">
                                <form action="print_delivery.php" method="POST" class="reports_form w-100" target="_blank">
                                    <h3 class="text-primary text-center pb-1 pt-2"><?php echo $language["Delivery"]." ".$language["Reports"] ;?></h3>
                                    <div class="row">
                                        <div class="grup">
                                            <label for=""><?php echo $language['Date'] ;?></label>
                                            <input type="text" id="deliveryrange" name="FromJeneralDates"
                                                class="p-2 w-100 model_inputs">
                                        </div>
                                    </div>
                                    <div class="row pt-5">
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="grup d-flex align-items-center">
                                                <?php if(isset($cityVar)){?>
                                                    <select name="FromThisBranch" id="FromThisBranch" class="form-control border border-primary">
                                                        <?php if($userrollpost == "SuperDuperAdmin" || $userrollpost == "SuperAdmin" || $userrollpost == "Admin" || $userrollpost == "CityAdmin"){ ;?>
                                                        <?php foreach(array_unique($cityVar) as $branchf){?>
                                                    <option <?php if (CleanBranchCode($branchf) == $userbranch) { ?>selected<?php } ?>
                                                                value="<?php echo CleanBranchCode($branchf); ?>">
                                                                <?php echo CleanBranchCode($branchf); ?>
                                                            </option>
                                                    <?php } ?>
                                                    <?php }else{?>
                                                        <option
                                                                value="<?php echo $userbranch; ?>">
                                                                <?php echo $userbranch; ?>
                                                        </option>
                                                    <?php };?>
                                                    </select>
                                                <?php }else{?>
                                                <input type="text" class="form-control bg-white border border-primary"
                                                    value="<?php echo "No Branch Available" ;?>" name="FromThisBranch"
                                                    id="FromThisBranchdelivery" style="width:100%" readonly />
                                                <?php } ;?>
                                            </div>
                                        </div>
                                        <?php if($userrollpost != "SuperDuperAdmin"){?>
                                        <div
                                            class="col-lg-2 col-md-2 col-sm-12 d-flex">
                                            <h4 class="pt-2"><?php echo $language['Ma'] ;?></h4>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12 ">
                                            <div class="check-box overflow-auto p-1"style="height:111px">
                                                    <?php if (isset($branchcollegues)) {
                                                        foreach ($branchcollegues as $usersascurbranch) { ?>
                                                        <div class="d-flex align-items-center gap-2 pb-2">
                                                            <input type="checkbox" class="p-2 check_box"
                                                                value="<?php echo $usersascurbranch; ?>" name="usersofthisbranch[]"
                                                                id="user<?php echo $usersascurbranch; ?>" />
                                                            <label for="user<?php echo $usersascurbranch; ?>"
                                                                class="form-label  m-0"><?php echo " " . $usersascurbranch; ?></label><br>
                                                                </div>
                                                        <?php }
                                                    }else{?>
                                                        <input type="checkbox" class="p-2 check_box"
                                                                value="" name="usersofthisbranch[]">
                                                        <label for="user_branch"
                                                            class="form-label  m-0 mt-1">No user branch available</label><br>
                                                    <?php
                                                    } ?>
                                               
                                            </div>
                                        </div>
                                        <?php } ;?>
                                    </div>
                                    <div class="pt-2 pb-3 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success w-50 mt-4"><?php echo !empty($language['Delivery']) ? $language['Delivery'] : "" ;?>
                                        Report</button>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
                <?php } else
                    echo "તમને આ પેજ જોવા ની પરમીશન નથી, હેડ ઓફીસ માં વાત કરો.";
                ?>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <div class="mt-3">
                <?php require_once('layouts/main/footer.php'); ?>
            </div>
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
            $('#printcityrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#printcityrange').daterangepicker({
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
            $('#printrange2 span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#printrange2').daterangepicker({
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

<script type="text/javascript">
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#printcityrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('D MMMM, YYYY'));
        }

        $('#printcityrange').daterangepicker({
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

            // $("#ChartBox").hide();
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

        jQuery(document).ready(function(){
            var previous = null;
            var city1 = jQuery("#FromThisCity").val();
            var count = 1;
            jQuery(".ToThisCity option[value="+city1+"]").remove();

            jQuery("#FromThisCity").change(function(){
                var city2 =jQuery("#FromThisCity").val(); 
                jQuery(".ToThisCity option[value="+city2+"]").remove();

                if(count == 1)
                {
                    jQuery(".ToThisCity").append("<option value='" + city1 + "'>" + city1 + "</option>");
                    count++;
                }
                

                if(previous)
                {
                    jQuery(".ToThisCity").append("<option value='" + previous + "'>" + previous + "</option>");
                }

                previous = city2;
            });

        });
    </script>
    </body>

    </html>