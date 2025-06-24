<?php
require_once("layouts/mainheader.php");
require_once("connection.php");
require_once("additional_field_logic.php");

$add_sql = "SELECT * FROM `additional_fields`";
$run_add_sql = mysqli_query($conn2, $add_sql);
$add_data = array();

if (mysqli_num_rows($run_add_sql) > 0) {
    while ($row = mysqli_fetch_assoc($run_add_sql)) {
        $add_data[] = $row;
    }
}

$total_fields = mysqli_num_rows($run_add_sql);

$query = "SELECT * FROM `branchlog` WHERE `name` = '$userbranch'";
$run_query = mysqli_query($conn2, $query);
$qdata = mysqli_fetch_assoc($run_query);

?>

<head>
    <title><?php echo $language['additional']; ?> | GT Solution</title>
    <?php require_once('layouts/main/head.php'); ?>
    <?php require_once('layouts/stylescript/head-style.php'); ?>
    <link rel="stylesheet" href="assets/css/income.css">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <script scr="assets/js/custome.js"></script>

    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</head>

<div id="layout-wrapper">

    <?php require_once('layouts/menu/menu.php'); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Bread Cump -->
                <div class="ml-2 d-flex align-items-center justify-content-between">
                    <div>
                        <h4><?php echo $language['additional'] . " " . $language['setting'] ?> :-</h4>
                    </div>
                    <div>
                        <button class="btn btn-danger deleteFields" id="removeFields" type="button">-</button>
                        <button class="btn btn-success" id="addFields" type="button">+</button>
                        <input type="hidden" id="current_receipt_format" name="current_receipt_format"
                            value="<?php echo $printreceiptformat; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
                        <form action="#" method="POST">
                            <table class="table table-bordered" id="AdditionalItem">
                                <tr>
                                    <td class="border border-dark border-round text-center" width="12%">
                                        <?php echo ""; ?>
                                    </td>
                                    <td class="border border-dark border-round text-center" width="20%">
                                        <?php echo $language['field_name']; ?>
                                    </td>
                                    <td class="border border-dark border-round text-center" width="15%">
                                        <?php echo $language['display']; ?>
                                    </td>
                                    <td class="border border-dark border-round text-center" width="15%">
                                        <?php echo $language['field_type']; ?>
                                    </td>
                                    <td class="border border-dark border-round text-center" width="15%">
                                        <?php echo $language['field_value']; ?>
                                    </td>
                                    <td class="border border-dark border-round text-center" width="15%">
                                        <?php echo $language['relation']; ?>
                                    </td>
                                    <td class="border border-dark border-round text-center" width="15%">
                                        <?php echo $language['total2']; ?>
                                    </td>
                                </tr>
                                <?php if ($total_fields == 0) { ?>
                                    <tr id="field_0">
                                        <input type="hidden" name="allow_action[]" id="allow_action_0" value="off">
                                        <td class="p-0"><input type="checkbox" name="allow_action[]" id="allow_action_0"
                                                class="check_boxs"></td>
                                        <td class="p-1"><input type="text" name="field_name[]" id="field_name_0"
                                                class="form-control" autocomplete="off"></td>
                                        <td class="p-1">
                                            <select name="display[]" id="display_0" class="form-control">
                                                <option value="select_option" selected hidden disabled><?php echo $language['set_display'] ;?>
                                                </option>
                                                <option value="gst"><?php echo $language['gst'] ;?></option>
                                                <option value="none_gst"><?php echo $language['none_gst'] ;?></option>
                                                <option value="both"><?php echo $language['both'] ?></option>
                                            </select>
                                        </td>
                                        <td class="p-1">
                                            <select name="type[]" id="type_0" class="form-control field_type">
                                                <option value="select_type" selected hidden disabled><?php echo $language['select_type'] ;?></option>
                                                <option value="Integer" class="tint"><?php echo $language['integer'] ;?></option>
                                                <option value="Float" class="tfloat"><?php echo $language['float'] ;?></option>
                                                <option value="String" class="tstring"><?php echo $language['string'] ;?></option>
                                            </select>
                                        </td>
                                        <td class="p-1"><input type="text" name="field_value[]" id="field_value_0"
                                                class="form-control additional_val" autocomplete="off"></td>
                                        <td class="p-1">
                                            <select name="relation[]" id="relation_0" class="form-control">
                                                <option value="select_relation" selected hidden disabled><?php echo $language['relation_type'] ;?>
                                                </option>
                                                <option value="editable"><?php echo $language['editable'] ;?></option>
                                                <option value="read_only"><?php echo $language['read_only'] ;?></option>
                                            </select>
                                        </td>
                                        <input type="hidden" name="allow_total[]" id="allow_total_0" value="off">
                                        <td class="p-0"><input type="checkbox" name="allow_total[]" id="allow_total_0"
                                                class="check_boxs total_check_0"></td>
                                    </tr>
                                <?php } else {

                                    for ($i = 0; $i < $total_fields; $i++) { ?>
                                        <tr id="field_<?php echo $i; ?>">
                                            <input type="hidden" name="allow_action[]" id="allow_action_<?php echo $i; ?>"
                                                value="off">
                                            <td class="p-0"><input type="checkbox" name="allow_action[]"
                                                    id="allow_action_<?php echo $i; ?>" class="check_boxs" <?php echo isset($add_data[$i]["display"]) && $add_data[$i]["display"] == "on" ? "checked" : ""; ?>></td>
                                            <td class="p-1"><input type="text" name="field_name[]"
                                                    value="<?php echo !empty($add_data[$i]["field_name"]) ? $add_data[$i]["field_name"] : ""; ?>"
                                                    id="field_name_<?php echo $i; ?>" class="form-control" autocomplete="off">
                                            </td>
                                            <td class="p-1">
                                                <select name="display[]" id="display_<?php echo $i; ?>" class="form-control">
                                                    <option value="select_option" selected hidden disabled><?php echo $language['set_display'] ;?>
                                                    </option>
                                                    <option value="gst" <?php echo $add_data[$i]["display_field"] == "gst" ? "selected" : ""; ?>><?php echo $language['gst'] ;?></option>
                                                    <option value="none_gst" <?php echo $add_data[$i]["display_field"] == "none_gst" ? "selected" : ""; ?>><?php echo $language['none_gst'] ;?></option>
                                                    <option value="both" <?php echo $add_data[$i]["display_field"] == "both" ? "selected" : ""; ?>><?php echo $language['both'] ;?></option>
                                                </select>
                                            </td>
                                            <td class="p-1"><select name="type[]" id="type_<?php echo $i; ?>"
                                                    class="form-control field_type">
                                                    <option value="select_type" selected hidden disabled><?php echo $language['select_type'] ;?></option>
                                                    <option value="Integer" class="tint" <?php echo $add_data[$i]["field_type"] == "Integer" ? "selected" : ""; ?>><?php echo $language['integer'] ;?>
                                                    </option>
                                                    <option value="Float" class="tfloat" <?php echo $add_data[$i]["field_type"] == "Float" ? "selected" : ""; ?>><?php echo $language['float'] ;?>
                                                    </option>
                                                    <option value="String" class="tstring" <?php echo $add_data[$i]["field_type"] == "String" ? "selected" : ""; ?>><?php echo $language['string'] ;?>
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="p-1"><input type="text" name="field_value[]"
                                                    id="field_value_<?php echo $i; ?>" class="form-control additional_val"
                                                    value="<?php echo !empty($add_data[$i]["field_value"]) ? $add_data[$i]["field_value"] : ""; ?>"
                                                    autocomplete="off"></td>
                                            <td class="p-1">
                                                <select name="relation[]" id="relation_<?php echo $i; ?>" class="form-control">
                                                    <option value="select_relation" selected hidden disabled><?php echo $language['relation_type'] ;?>
                                                    </option>
                                                    <option value="editable" <?php echo $add_data[$i]["relation"] == "editable" ? "selected" : ""; ?>><?php echo $language['editable'] ;?></option>
                                                    <option value="read_only" <?php echo $add_data[$i]["relation"] == "read_only" ? "selected" : ""; ?>><?php echo $language['read_only'] ;?></option>
                                                </select>
                                            </td>
                                            <input type="hidden" name="allow_total[]" id="allow_total_<?php echo $i; ?>"
                                                value="off">
                                            <td class="p-0"><input type="checkbox" name="allow_total[]" style="<?php echo isset($add_data[$i]["field_type"]) && $add_data[$i]["field_type"] == "String" ? "opacity:0.5" : "opacity:1"; ?>"
                                                    id="allow_total_<?php echo $i; ?>" class="check_boxs total_check_<?php echo $i ;?>" <?php echo isset($add_data[$i]["total"]) && $add_data[$i]["total"] == "on" ? "checked" : ""; ?> <?php echo isset($add_data[$i]["field_type"]) && $add_data[$i]["field_type"] == "String" ? "disabled" : ""; ?>></td>
                                        </tr>
                                    <?php }
                                }
                                ; ?>
                            </table>
                            <input type="submit" value="<?php echo $language['add'] ;?>" id="submit" class="submit btn btn-success btn-xl my-4">
                        </form>
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

</body>

</html>