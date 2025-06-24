<!-- transport Table Formating  -->
<script>
    function offddeleted() {
        document.getElementById("overlaydelete").style.display = "none";
    }
</script>


<script>
    function clearInputFields(divElement) {
        $(document).ready(function () {
            var currentdivbuild = 'div#' + divElement + '.col.col-12';
            $(currentdivbuild).find(':input').each(function () {
                switch (this.type) {
                    case 'button':
                    case 'text':
                    case 'submit':
                    case 'password':
                    case 'file':
                    case 'email':
                    case 'date':
                    case 'number':
                        $(this).val('');
                        break;
                    case 'checkbox':
                    case 'radio':
                        this.checked = false;
                        break;
                }
            });
        });
    }
</script>

<script>
    var manualtriger = 1
    $(document).on('click', '#manual', function () {
        if (manualtriger == 1) {
            $('#grandtotal').prop('readonly', false);
            manualtriger = 0;
            $('#manualtrigger').val(parseFloat(manualtriger));
        } else {
            $('#grandtotal').prop('readonly', true);
            manualtriger = 1;
            $('#manualtrigger').val(parseFloat(manualtriger));
        }
    });

    $(document).on('click', '#addRows', function () {
        var rcount = $("#invoiceItem tr:gt(0)").length - 1;
        rcount++;
        var htmlRows = '';
        htmlRows += '<tr id="item_' + rcount + '">';
        htmlRows += '<td><input type="text" name="detail[]" list="detailsname" id="productName_' + rcount + '" class="form-control productName" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="qty[]" id="quantity_' + rcount + '" class="form-control quantity" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="rate[]" id="price_' + rcount + '" class="form-control price" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="weight[]" id="weight_' + rcount + '" class="form-control weight" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="total[]" id="total_' + rcount + '" class="form-control total" autocomplete="off"></td>';
        htmlRows += '</tr>';
        $('#invoiceItem').append(htmlRows);
        calculateTotal();
    });

    $(document).on('click', '#removeRows', function () {
        var rowCount = $("#invoiceItem tr:gt(0)").length - 1;
        if (rowCount > 0) {
            $("#item_" + rowCount).each(function () {
                $(this).closest('tr').remove();
            });
            rowCount--;
            calculateTotal();
        }

    });


    $(document).on('blur', "[id^=quantity_]", function () {
        calculateTotal();
    });
    $(document).on('blur', "[id^=price_]", function () {
        calculateTotal();
    });
    $(document).on('blur', "[id^=weight_]", function () {
        calculateTotal();
    });
    $(document).on('blur', "[id^=additional_val_]", function () {
        calculateTotal();
    });

    function AdditionalCharges() {
        var total_item = jQuery("#total_item").val();
        var charges = 0;

        for (var i = 0; i < total_item; i++) {
            var add_to_total = jQuery("#total_relation_" + i).val();

            if (add_to_total == "on") {
                var charge_value = parseFloat(jQuery("#additional_val_" + i).val()) || 0;
                charges = charges + charge_value;
            }
        }

        jQuery("#total_charges").val(charges);
        return charges;
    }



    function calculateTotal() {
        var totalAmount = 0;
        var total_charges = AdditionalCharges();
        $("[id^='price_']").each(function () {
            var id = $(this).attr('id');
            id = id.replace("price_", '');
            var price = $('#price_' + id).val();
            var quantity = $('#quantity_' + id).val();
            var weight = $('#weight_' + id).val();

            if (quantity <= 0) {
                quantity = 1;
            }
            if (price <= 0) {
                price = 1;
            }
            if (weight > 0) {
                var total = price * weight;
            } else {
                var total = price * quantity;
            }
            $('#total_' + id).val(parseFloat(total));
            totalAmount += total;
        });
        totalAmount = totalAmount + parseFloat(total_charges);
        $('#grandtotal').val(parseFloat(totalAmount));
    }
</script>

<script>

    $(document).on('click', '#addFields', function () {
        var format = jQuery("#current_receipt_format").val();
        var count = $("#AdditionalItem tr:gt(0)").length - 1;
        count++;
        if (count > 2) {
            alert("Maximum 3 Additional fields are allowed");
            return;
        }
        else {
            var htmlRows = '';
            htmlRows += '<tr id="field_' + count + '">';
            htmlRows += '<input type="hidden" name="allow_action[]" id="allow_action_' + count + '" value="off">'
            htmlRows += '<td class="p-0"><input type="checkbox" name="allow_action[]" id="allow_action_' + count + '" class="check_boxs"></td>';
            htmlRows += '<td class="p-1"><input type="text" name="field_name[]" id="field_name_' + count + '" class="form-control" autocomplete="off"></td>';
            htmlRows += '<td  class="p-1"><select name="display[]" id="display_' + count + '" class="form-control field_display"><option value="select_option" selected hidden disabled><?php echo $language['set_display'] ;?></option><option value="gst" class="tint"><?php echo $language['gst'] ;?></option><option value="none_gst" class="none_gst"><?php echo $language['none_gst'] ;?></option><option value="both" class="both"><?php echo $language['both'] ;?></option></select></td>';
            htmlRows += '<td  class="p-1"><select name="type[]" id="type_' + count + '" class="form-control field_type"><option value="select_type" selected hidden disabled><?php echo $language['select_type'] ;?></option><option value="Integer" class="tint"><?php echo $language['integer'] ;?></option><option value="Float" class="tfloat"><?php echo $language['float'] ;?></option><option value="String" class="tstring"><?php echo $language['string'] ;?></option></select></td>';
            htmlRows += '<td class="p-1"><input type="text" name="field_value[]" id="field_value_' + count + '" class="form-control additional_val" autocomplete="off"></td>';
            htmlRows += '<td class="p-1"><select name="relation[]" id="relation_' + count + '" class="form-control"><option value="select_relation" selected hidden disabled><?php echo $language['relation_type'] ;?></option><option value="editable"><?php echo $language['editable'] ;?></option><option value="read_only"><?php echo $language['read_only'] ;?></option></select></td>';
            htmlRows += '<input type="hidden" name="allow_total[]" id="allow_total_' + count + '" value="off">'
            htmlRows += '<td class="p-0"><input type="checkbox" name="allow_total[]" id="allow_total_' + count + '" class="check_boxs total_check_' + count + '"></td>';
            htmlRows += '</tr>';
            $('#AdditionalItem').append(htmlRows);
        }
    });

    $(document).on('click', '#removeFields', function () {
        var fieldCount = $("#AdditionalItem tr:gt(0)").length - 1;
        if (fieldCount > 0) {
            $("#field_" + fieldCount).each(function () {
                $(this).closest('tr').remove();
            });
            fieldCount--;
        }
    });
</script>





<script>
    $('body').on('keydown', 'input, select', function(e) {
        if (e.key === "Enter") {
            var self = $(this),
                form = self.parents('form:eq(0)'),
                focusable, next;
            focusable = form.find('input,a,select,button,textarea').filter(':visible:not([disabled])');
            next = focusable.eq(focusable.index(this) + 1);
            if (next.length) {
                next.focus();    
            } else {
                form.submit();
            }
            return false;
        }
    });
</script>