<?php
    $page = !empty($_GET["page"]) ? $_GET["page"] : "";

    $add_sql = "SELECT * FROM `additional_fields`";
    $run_add_sql = mysqli_query($conn2,$add_sql);
    $add_data = array();
   
    if(mysqli_num_rows($run_add_sql) > 0)
    {
        while($row=mysqli_fetch_assoc($run_add_sql))
        {
            $add_data[] = $row;
        }
    }
    if($run_add_sql)
    {
        $total_fields = mysqli_num_rows($run_add_sql);
    }
    else
    {
        $total_fields = 0;
    }
    
    $charges = 0;
?>
<style>
    .border_round
    {
        border-top-right-radius: 4px !important;
        border-bottom-right-radius:4px !important;
    }

    .additional_tr:disabled 
    {
        background-color: #fff !important;
    }
</style>

<script src="https://cdn.datatables.net/autofill/2.7.0/js/dataTables.autoFill.min.js"></script>
<div class="card-content">
    <div class="card-body">
        <form action="" id="add_product_details" method="POST">
            <!-- Line 1 --> 
            <div class="row">
                <div class="col-sm-12 <?php echo isset($_GET["page"]) && $_GET["page"] == "gst" ? "col-xl-4" : "col-xl-6" ?> col-md-12">
                    <?php if (isset($_GET) && isset($_GET["edit"]) == "true") { ?>
                        <input type="hidden" name="LREditSave" id="LREditSave">
                        <input type="hidden" name="LRNUMBEREdit"
                            value="<?php echo isset($_GET["lr_no"]) ? $_GET["lr_no"] : ""; ?>">
                    <?php } else { ?>
                        <input type="hidden" name="LRNUMBERNew" id="LRNUMBERNew"
                            readonly>
                    <?php }; ?>
                    <div class="input-group mb-3">
                        <label for="senderEdit" class="input-group-text "><?php echo $language['sender']; ?></label>
                        <input type="text" value="<?php echo !empty($data['nameone']) ? $data['nameone'] : '';?>"
                            class="form-control d-inline litanswer rounded-right border_round w-50"  list="sendername" id="senderEdit" name="senderEdit"
                            autocomplete="on" required autofocus>
                        <datalist id="sendername">
                            
                        </datalist>
                    </div>
                </div>
                <div class="col col-sm-12 <?php echo isset($_GET["page"]) && $_GET["page"] == "gst" ? "col-xl-4" : "col-xl-6" ?> col-md-12">
                    <div class="input-group mb-3">
                        <label for="sendernumEdit" class="input-group-text "><?php echo $language['sendern']; ?></label>
                        <input type="text" value="<?php echo !empty($data['numone']) ? $data['numone'] : '' ;?>"
                            minlength="10" maxlength="10" class="form-control distog border_round" id="sendernumEdit"
                            name="sendernumEdit" autocomplete="on"
                            onkeypress='return event.charCode >= 46 && event.charCode <= 57'>
                    </div>
                </div>
                <?php if(isset($_GET["page"]) && $_GET["page"] == "gst"){?>
                <div class="col col-sm-12 col-xl-4 col-md-12">
                    <div class="input-group mb-3">
                        <label for="senderGST"
                            class="input-group-text "><?php echo $language['sender'] . " GST"; ?></label>
                        <input type="text" value="<?php echo !empty($data['gstone']) ? $data['gstone'] : '' ;?>"
                            class="form-control distog border_round rounded-right" id="senderGST" name="senderGST"
                            autocomplete="on">
                    </div>
                </div>
                <?php }?>
                <div class="col col-sm-12 <?php echo isset($_GET["page"]) && $_GET["page"] == "gst" ? "col-xl-4" : "col-xl-6" ?> col-md-12">
                    <div class="input-group mb-3">
                        <label for="reciverEdit" class="input-group-text "><?php echo $language['reciver']; ?></label>
                        <input type="text" value="<?php echo !empty($data['nametwo']) ? $data['nametwo'] : '' ;?>"
                            class="form-control d-inline w-50 recivernameEdit border_round rounded-right" id="reciverEdit" list="recivername" name="reciverEdit" required>
                        <datalist id="recivername">
                            
                        </datalist>
                    </div>
                </div>
                <div class="col col-sm-12 <?php echo isset($_GET["page"]) && $_GET["page"] == "gst" ? "col-xl-4" : "col-xl-6" ?> col-md-12">
                    <div class="input-group mb-3">
                        <label for="recivernumEdit"
                            class="input-group-text "><?php echo $language['recivern']; ?></label>
                        <input type="text" value="<?php echo !empty($data['numtwo']) ? $data['numtwo'] : '' ;?>"
                            minlength="10" maxlength="10" class="form-control distog border_round rounded-right" id="recivernumEdit"
                            name="recivernumEdit" onkeypress='return event.charCode >= 46 && event.charCode <= 57'>
                    </div>
                </div>
                <?php if(isset($_GET["page"]) && $_GET["page"] == "gst"){?>
                <div class="col col-sm-12 col-xl-4 col-md-12">
                    <div class="input-group mb-3">
                        <label for="reciverGST"
                            class="input-group-text "><?php echo $language['reciver'] . " GST"; ?></label>
                        <input type="text" value="<?php echo !empty($data['gsttwo']) ? $data['gsttwo'] : '' ;?>"
                             class="form-control distog border_round rounded-right" id="reciverGST" name="reciverGST"
                            autocomplete="on">
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table test table-bordered" id="invoiceItem">
                        <tr>
                            <td class="border border-dark border-round text-center" width="38%">
                                <?php echo $language['itemdetail']; ?>
                            </td>
                            <td class="border border-dark border-round text-center" width="15%">
                                <?php echo $language['qtyamount']; ?>
                            </td>
                            <td class="border border-dark border-round text-center" width="15%">
                                <?php echo $language['Pricing']; ?>
                            </td>
                            <td class="border border-dark border-round text-center" width="15%">
                                <?php echo $language['weight']; ?>(KG)
                            </td>
                            <td class="border border-dark border-round text-center" width="15%">
                                <?php echo $language['amount']; ?>
                            </td>
                        </tr>
                        <?php if (isset($_GET) && isset($_GET["edit"]) == "true") {

                            $items = !empty($data["item"]) ? explode(',', $data["item"]) : [];
                            $rates = !empty($data["rate"]) ? explode(',', $data["rate"]) : [];
                            $qtys = !empty($data["qtyarray"]) ? explode(',', $data["qtyarray"]) : [];
                            $weights = !empty($data["weightarray"]) ? explode(',', $data["weightarray"]) : [];
                            $totals = !empty($data["totalarray"]) ? explode(',', $data["totalarray"]) : [];

                            for ($i = 0; $i < $total_item; $i++) {
                                $item = isset($items[$i]) ? trim($items[$i]) : '';
                                $rate = isset($rates[$i]) ? trim($rates[$i]) : '';
                                $qty = isset($qtys[$i]) ? trim($qtys[$i]) : '';
                                $weight = isset($weights[$i]) ? trim($weights[$i]) : '';
                                $total = isset($totals[$i]) ? trim($totals[$i]) : '';
                                ?>
                                <tr id="item_<?php echo $i ?>">
                                    <td><input type="text" value="<?php echo $item; ?>" name="detail[]" id="productName_<?php echo $i ?>"
                                            class="form-control productName" list="detailsname" autocomplete="off"></td>
                                    <td><input type="number" value="<?php echo $qty; ?>" name="qty[]" id="quantity_<?php echo $i ?>"
                                            class="form-control quantity" autocomplete="off"></td>
                                    <td><input type="text" value="<?php echo $rate; ?>" name="rate[]" id="price_<?php echo $i ?>"
                                            class="form-control price" autocomplete="off"></td>
                                    <td><input type="number" value="<?php echo $weight; ?>" name="weight[]" id="weight_<?php echo $i ?>"
                                            class="form-control weight" autocomplete="off"></td>
                                    <td><input type="number" value="<?php echo $total; ?>" name="total[]" id="total_<?php echo $i ?>"
                                            class="form-control total" autocomplete="off"></td>
                                </tr><?php
                            }
                        } else {
                            ?>

                            <tr id="item_0">
                                <td><input type="text" value="<?php echo !empty($data["item"]) ? $data["item"] : ""; ?>"
                                        name="detail[]" id="productName_0" class="form-control productName"
                                        list="detailsname" autocomplete="off"></td>
                                <td><input type="number" value="<?php echo !empty($data["qty"]) ? $data["qty"] : ""; ?>"
                                        name="qty[]" id="quantity_0" class="form-control quantity" autocomplete="off"></td>
                                <td><input type="number" value="<?php echo !empty($data["rate"]) ? $data["rate"] : ""; ?>"
                                        name="rate[]" id="price_0" class="form-control price" autocomplete="off"></td>
                                <td><input type="number"
                                        value="<?php echo !empty($data["weight"]) ? $data["weight"] : ""; ?>"
                                        name="weight[]" id="weight_0" class="form-control weight" autocomplete="off"></td>
                                <td><input type="number" value="<?php echo !empty($data["total"]) ? $data["total"] : ""; ?>"
                                        name="total[]" id="total_0" class="form-control total" autocomplete="off"></td>
                            </tr>
                        <?php }
                        ; ?>
                    </table>
                        <?php if($total_fields > 0){ ;?>
                            <div class="row">
                            <?php
                            for($i = 0 ; $i < $total_fields ; $i++){ 
                                    
                                ?>
                                    <?php if(!empty($add_data[$i]["display"]) && ($add_data[$i]["display"] == "on")){;?>
                                        <div class="col col-sm-12 col-xl-4 col-md-4">
                                            <div class="input-group mb-3">
                                                <label for="<?php echo $add_data[$i]["field_name"]; ?>" class="input-group-text ">
                                                    <?php echo $add_data[$i]["field_name"]; ?>
                                                </label>
                                                <input type="<?php echo $add_data[$i]["field_type"] == "int" ? "number" : $add_data[$i]["field_type"]; ?>"  name="fields[<?php echo $add_data[$i]["field_name"];?>]" value="<?php echo !empty($add_data[$i]["field_value"]) ? $add_data[$i]["field_value"] : ""; ?>" class="form-control distog border_round rounded-right additional_tr" autocomplete="on" <?php echo $add_data[$i]["relation"] != "editable" ? "disabled" : "" ;?> id="additional_val_<?php echo $i ;?>">
                                                <?php if($add_data[$i]["relation"] != "editable"){?>
                                                <input type="hidden" name="fields[<?php echo $add_data[$i]["field_name"];?>]" value="<?php echo $add_data[$i]["field_value"] ;?>">
                                                <?php };?>
                                                <input type="hidden" name="total_relation" value="<?php echo !empty($add_data[$i]["total"]) && $add_data[$i]["total"] == "on" ? $add_data[$i]["total"] : ""; ?>" class="form-control distog border_round rounded-right additional_tr" autocomplete="on" id="total_relation_<?php echo $i ;?>">
                                            </div>
                                        </div>
                                       
                            <?php 
                                if($add_data[$i]["display"] == "on" && ($add_data[$i]["field_type"] == "int" || $add_data[$i]["field_type"] == "float") && $add_data[$i]["total"] == "on") 
                                {
                                    $charges = $charges + !empty($add_data[$i]["field_value"]) ? $add_data[$i]["field_value"] : 0;
                                }
                            ?>
                        <?php }}};?>
                        </div>
                        <input type="hidden" name="total_items" id="total_item" value="<?php echo !empty($total_fields) ? $total_fields : 0 ;?>">
                        <input type="hidden" name="total_charges" id="total_charges" value="">
                </div>
            </div>

            <datalist id="detailsname">
                <?php if(isset($myitemdetails) && !empty($myitemdetails)){
                    foreach ($myitemdetails as $engitem => $gujitem) { ?>
                    <option value="<?php echo $gujitem; ?>"><?php echo $engitem . " - " . $gujitem; ?></option>
                <?php }}else{ ?>
                    <option value="No Item Available">No Items Are Available</option>
                <?php } ;?>
            </datalist>

            <!-- Line 4 -->
            <div class="row">
                <div class="col col-sm-12 col-xl-3 col-md-12">

                    <div class="input-group mb-3">
                        
                        <label for="paymentEdit" class="input-group-text "><?php echo $language['payment']; ?></label>
                        <select name="paymentEdit" id="paymentEditbakijama"
                            class="form-select form-control jamabakientry">
                            <option value="To Pay" <?php echo isset($data["type"]) && $data["type"] == $language['topay'] ? "selected" : ""; ?>>
                            <?php echo $language['topay'] ;?>
                            </option>
                            <option value="To Paid" <?php echo isset($data["type"]) && $data["type"] == $language['topaid'] ? "selected" : ""; ?>>
                            <?php echo $language['topaid'] ;?>
                            </option>
                            <?php if(isset($_GET) && $_GET["page"] != "gst"){?>
                            <option value="Free of Charge" <?php echo isset($data["type"]) && $data["type"] == $language['foc'] ? "selected" : ""; ?>><?php echo $language['foc'] ;?>
                            </option>
                            <?php } ;?>
                            <option value="Accounting Software" <?php echo isset($data["type"]) && $data["type"] == $language['accounting'] ? "selected" : ""; ?>>
                            <?php echo $language['accounting'] ;?>
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col col-sm-12 col-xl-3 col-md-12">
                    <div class="input-group mb-3">
                        <label for="placeEdit" class="input-group-text "><?php echo $language['placetosend']; ?></label>
                        <select name="placeEdit" id="placeEdit" class="form-select">
                            <?php if(isset($branchnamesf)){
                                foreach ($branchnamesf as $branchf) { ?>
                                <option value="<?php echo $branchf; ?>" <?php echo (!empty($data["place"]) && $data["place"] == $branchf) ? 'selected' : ''; ?>>
                                    <?php echo $branchf; ?>
                                </option>
                            <?php }}else{ ?>
                                <option value="not">No Places Available</option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
                <div class="col  col-sm-12 col-xl-3 col-md-12">
                    <div class="input-group mb-3">
                        <label for="remarkEdit" class="input-group-text "><?php echo $language['remark']; ?></label>
                        <input size="90%" type="text"
                            value="<?php echo !empty($data["remark"]) ? $data["remark"] : ""; ?>" class="form-control"
                            id="remarkEdit" name="remarkEdit">
                    </div>
                </div>
                <div class="col  col-sm-12 col-xl-3 col-md-12">
                    <div class="input-group mb-3">
                        <label for="remarkEdit" class="input-group-text "><?php echo $language['grandtotal']; ?></label>
                        <input type="text" value="<?php echo !empty($data["total"]) ? $data["total"] : ""; ?>"
                            class="form-control" id="grandtotal" name="grandtotal" readonly>
                        <input type="hidden" class="form-control" id="manualtrigger" readonly>
                        <input type="hidden" value="bakijama" class="form-control" id="lrtypeis" readonly>
                    </div>
                </div>
                <div class="col col-sm-12 col-xl-2 col-md-12 d-none">
                    <div class="input-group mb-3">
                        <label for="driverEdit" class="input-group-text "><?php echo $Str_DriverName; ?></label>
                        <input type="hidden" class="form-control" value="" id="driverEdit" name="driverEdit"
                            onkeypress='return event.charCode >= 46 && event.charCode <= 57' minlength="10"
                            maxlength="10" list="drivernumber">
                        <datalist id="drivernumber">
                            <?php foreach ($drivenumbers as $drivenumber) { ?>
                                <option value="<?php echo $drivenumber; ?>"><?php echo $drivenumber; ?></option>
                            <?php } ?>
                        </datalist>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="active" id="activeInput" value="<?php echo !empty($page) ? $page : "" ;?>">
            <input type="hidden" name="lastpaymentnumber" id="lastpaymentnumber" value="<?php echo $lastnumber ;?>">
            <input type="hidden" name="lastgstnumber" id="lastgstnumber" value="<?php echo $viewlastgstnumber ;?>">
            <button type="submit" id="submitbuttontosubmitform"
                class="btn btn-danger btn-lg my-4 btn_save_item"><?php echo $language['save'] . " & " . $language['print']; ?></button>
        </form>
    </div>
</div>


