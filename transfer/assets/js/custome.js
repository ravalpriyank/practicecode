jQuery(document).ready(function(){

    var date = jQuery("#ddate").val(); 
    var place = jQuery('#place_filter').val();

    jQuery("#get_dispatch_detail").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "ajax" : {
            "url" : "get_dispatch_detail.php",
            "type" : "POST",
            "data" :
            {
                "date" : date,
                "place" : place,
            }
        },
        "language": {
            searchPlaceholder: "Search By Reciept No"
        },
        "columns" : [
            {
                "data": null,
                sortable: false,
                render: function (data, type, row) {
                    return '<input type="checkbox" class="dcheckbox" id="dcheckbox" name="dcheckbox" value="' + data.lrn + '">';
                }
            },
            { "data": "lrn", sortable: true },
            { "data": "item", sortable: true },
            { "data": "qty", sortable: true },
            { "data": "place", sortable: true },
            { "data": "dstatus", sortable: true },
        ],
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [1, 'desc'],
        ],
        "bDestroy": true,
    });
    
});

jQuery(document).ready(function(){
    jQuery("#checkAll").change(function(){
        var isChecked = jQuery(this).is(':checked');
        jQuery('.dcheckbox').each(function() {
            jQuery(this).prop('checked', isChecked);
        });
    });
});

jQuery(document).ready(function(){
    jQuery(".btn-dispatch").click(function(){
        var vehical_no = jQuery("#vehicle_number").val();
        var entry_date = jQuery("#entry_date").val();
        var dispatch_date = jQuery("#kt_daterangepicker2").val();
        var checkedValues = [];
        jQuery('.dcheckbox:checked').each(function() {
            checkedValues.push(jQuery(this).val());
        });
        
        if(checkedValues == "")
        {
            alert("Please Select Record To Update Vehicle Details");
            location.reload();
            return;
        }
        
        jQuery.ajax({
            "url" : "update_vehicle_no.php",
            "type" : "POST",
            "data" :
            {
                "vehicle_number" : vehical_no,
                "entry_date" : entry_date,
                "dispatch_date" : dispatch_date,
                "records" : checkedValues,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },
        })

    });
});

jQuery(document).ready(function(){
    jQuery("#btn_inc").click(function(){

        var edit = jQuery("#edit_income").val();
        var eid = jQuery("#edit_id").val();
        var reason = jQuery("#inc_reason").val();
        var detail = jQuery("#inc_detail").val();
        var date = jQuery("#inc_date").val();
        var amount = jQuery("#inc_amount").val();

        jQuery.ajax({
            "url" : "add_income_details.php",
            "type" : "POST",
            "data" : {
                "inc_reason" : reason,
                "inc_detail" : detail,
                "inc_date" : date,
                "inc_amount" : amount,
                "edit" : edit,
                "eid" : eid,
            },
            "success" : function(response){
                var currentUrl = window.location.href;
                var newUrl = currentUrl.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
                window.location.href = newUrl;
            }
        })
    })
});

jQuery(document).ready(function(){
    var user = jQuery("#user").val();
    var user_role = jQuery("#user_role").val();

    jQuery("#tbl_income_detail").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "bInfo": true,
        "ajax" : {
            "url" : "display_incomes.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "date", sortable: true },
            { "data": "income", sortable: true },
            { "data": "incomedetail", sortable: true },
            { "data": "amount", sortable: true },
            { "data": "incomer", sortable: true },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    if(user_role == "Office")
                    {
                        if(row.incomer == user)
                        {
                            return '<div style="display:flex;justify-content:center;"><a href="income.php?sno=' + data.sno + '&edit=true" id="editbtn_' + data.sno + '" ><i class="fas fa-edit edit_icon"></i></a><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_income(' + data.sno + ')"><i class="fa fa-trash delete_icon" style="padding:5px;"></i></a></div>';
                        }
                        else
                        {
                            return '<div><i class="fa-solid fa-lock text-danger"></i></div>';
                        }
                    }
                    else
                    {
                        return '<div><a href="income.php?sno=' + data.sno + '&edit=true" id="editbtn_' + data.sno + '" ><i class="fas fa-edit edit_icon"></i></a><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_income(' + data.sno + ')"><i class="fa fa-trash delete_icon" style="padding:5px;"></i></a></div>';
                    }
                }
            },
        ],
        "language": {
            searchPlaceholder: "Search By No"
        },
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [1, 'desc'],
        ],
        "bDestroy": true,
    });
});

//delete income
function delete_income(Id) {
    var strconfirm = confirm("Are You Sure Want To Delete This Income?");

    if (strconfirm == true) {
        jQuery.ajax({
            "url": "delete_income.php",
            "type": "POST",
            "data": {
                "id": Id,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

// delete item
function delete_item(Id) {
    var strconfirm = confirm("Are You Sure Want To Delete This Item ?");
    if (strconfirm == true) {
        jQuery.ajax({
            "url": "delete_item.php",
            "type": "POST",
            "data": {
                "id": Id,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

//reset password
function reset_password(Id) {
    jQuery.ajax({
        "url": "reset_user_password.php",
        "type": "POST",
        "data": {
            "id": Id,
        },
        success: function (response) {
            alert(response);
            location.reload();
        },

    });
}

//expense data table
jQuery(document).ready(function(){
    var user = jQuery("#user").val();
    var user_role = jQuery("#user_role").val();
   
    jQuery("#tbl_expense_detail").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "bInfo": true,
        "ajax" : {
            "url" : "display_expenses.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "date", sortable: true },
            { "data": "expense", sortable: true },
            { "data": "expensedetail", sortable: true },
            { "data": "amount", sortable: true },
            { "data": "expenser", sortable: true },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    if(user_role == "Office")
                    {
                        if(row.expenser == user)
                        {
                            return '<div style="display:flex;justify-content:center;"><a href="expense.php?sno=' + data.sno + '&edit=true" id="editbtn_' + data.sno + '" ><i class="fas fa-edit edit_icon"></i></a><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_expense(' + data.sno + ')"><i class="fa fa-trash delete_icon" style="padding:5px 10px;"></i></a></div>';
                        }
                        else
                        {
                            return '<div><i class="fa-solid fa-lock text-danger"></i></div>';
                        }
                    }
                    else
                    {
                        return '<div><a href="expense.php?sno=' + data.sno + '&edit=true" id="editbtn_' + data.sno + '" ><i class="fas fa-edit edit_icon"></i></a><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_expense(' + data.sno + ')"><i class="fa fa-trash delete_icon" style="padding:5px 10px;"></i></a></div>';
                    }
                    
                }
            },
        ],
        "language": {
            searchPlaceholder: "Search By No"
        },
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [0, 'desc'],
        ],
        "bDestroy": true,
    });
});

// expense details
jQuery(document).ready(function(){
    jQuery("#btn_exp").click(function(){
        var edit = jQuery("#edit_expense").val();
        var eid = jQuery("#edit_id").val();
        var reason = jQuery("#exp_reason").val();
        var detail = jQuery("#exp_detail").val();
        var date = jQuery("#exp_date").val();
        var amount = jQuery("#exp_amount").val();

        jQuery.ajax({
            "url" : "add_expense_details.php",
            "type" : "POST",
            "data" : {
                "exp_reason" : reason,
                "exp_detail" : detail,
                "exp_date" : date,
                "exp_amount" : amount,
                "edit" : edit,
                "eid" : eid,
            },
            "success" : function(response){
                var currentUrl = window.location.href;
                var newUrl = currentUrl.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
                window.location.href = newUrl;
            }
        })
    })
});

//delete expense
function delete_expense(Id) {
    var strconfirm = confirm("Are You Sure Want To Delete This Expense?");

    if (strconfirm == true) {
        jQuery.ajax({
            "url": "delete_expense.php",
            "type": "POST",
            "data": {
                "id": Id,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

jQuery(document).ready(function() {
    jQuery(".get_customer").submit(function(e) {
        e.preventDefault();
        var cid = jQuery("#relation_no").val();
        jQuery.ajax({
            "url": "get_customer_relations.php",
            "type": "POST",
            "data": {
                "cust_id": cid,
            },
            "success": function(response) {
                if (response != null) {
                    jQuery("#senderEdit").val(response.sender_name);
                    jQuery("#sendernumEdit").val(response.sender_mobile);
                    jQuery("#senderGST").val(response.sender_gst);
                    jQuery("#reciverEdit").val(response.receiver_name);
                    jQuery("#recivernumEdit").val(response.receiver_mobile);
                    jQuery("#reciverGST").val(response.receiver_gst);
                    jQuery("#paymentEditbakijama").val(response.payment_method);
                } else {
                    alert("No customer found");
                    return;
                }
            }
        });
    });
});



jQuery(document).ready(function(){

    var filter_date = jQuery("#fdate").val();
    var sender = jQuery("#sender").val();
    var receiver = jQuery("#receiver").val();
    var type = jQuery("#type").val();
    var format = jQuery("#current_receipt_format").val();

    if(format == "format1")
    {
        var page = "format1_print.php";
        var extra = 0;
    }
    else if(format == "format2")
    {
        var page = "format2_print.php";
        var extra = 0;
    }
    else if(format == "format3")
    {
        var page = "format3_print.php";
        var extra = 0;
    }
    else if(format == "format4")
    {
        var extra = jQuery("#total_charges").val();
        var page = "format4_print.php";
    }
    else if(format == "format5")
    {
        var page = "format5_print.php";
        var extra = 0;
    }
    else if(format == "format6")
    {
        var page = "format6_print.php";
        var extra = 0;
    }
    else
    {
        var page = "printnewfull.php";
    }
   
    jQuery("#tbl_parcel_detail").DataTable({
        "searching":true,
        "filter": false,
        "processing": false,
        "serverSide": true,
        "ordering": false,
        "ajax" : {
            "url" : "display_parcels.php",
            "type" : "POST",
            "data" :
            {
                "filter_date" : filter_date,
                "sender" : sender,
                "receiver" : receiver,
                "type" : type,
            }
        },
        "language": {
            searchPlaceholder: "Search here..."
        },
        "columns" : [
            { "data": "timestamp", sortable: false},
            { "data": "lrwithcode", sortable: false },
            { "data": "nameone", sortable: false },
            { "data": "nametwo", sortable: false },
            { "data": "item", sortable: false },
            { "data": "qty", sortable: false },
            { "data": "total", sortable: false },
            { "data": "type", sortable: false },
            { "data": "place", sortable: false },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    if (row.status === "deleted") {
                        return '<div><a href="javascript:void(0);" id="restorebtn_' + data.lrn + '" onClick="restore_parcel(\'' + data.lrn + '\', \'' + data.timestamp + '\')"> <i class="fa fa-recycle"></i></a></div>';
                    } else {
                        if(row.gst === "YES"){
                            // if(format == "")
                            return '<div class="icons"><div><button class="btn btn-sm-primary p-1"><a href="gst-module.php?page=gst&lr_no=' + data.lrn + '&time='+data.timestamp+'&edit=true" id="editbtn_' + data.lrn + '" ><i class="fas fa-edit edit_icon"></i></a></button></div><div><button class="btn btn-sm-primary p-1"><a href="javascript:void(0);" id="deletebtn_' + data.lrn + '" onClick="delete_parcel(\'' + data.lrn + '\', \'' + data.timestamp + '\')"><i class="fa fa-trash delete_icon" ></i></a></button></div><div><button class="btn btn-sm-primary p-1"><a href="' + page + '?PrintLR=' + data.lrwithcode + '&extra=' + extra + '&gst=yes&time3='+ data.timestamp +'" id="printbtn_' + data.lrn + '" target="_blank"><i class="fa fa-print"></i></a></button></div><div><button class="btn btn-sm-primary p-1"><a href="display_lr_details.php?lrn=' + data.lrwithcode + '&time2='+ data.timestamp +'" id="searchbtn_' + data.lrn + '" target="_blank"><i class="fa fa-search edit_icon"></i></a></button></div></div>';
                        }else{
                            return '<div class="icons"><div><button class="btn btn-sm-primary p-1"><a href="transport.php?lr_no=' + data.lrn + '&time='+data.timestamp+'&edit=true" id="editbtn_' + data.lrn + '" ><i class="fas fa-edit edit_icon"></i></a></button></div><div><button class="btn btn-sm-primary p-1"><a href="javascript:void(0);" id="deletebtn_' + data.lrn + '" onClick="delete_parcel(\'' + data.lrn + '\', \'' + data.timestamp + '\')"><i class="fa fa-trash delete_icon" ></i></a></button></div><div><button class="btn btn-sm-primary p-1"><a href="' + page + '?PrintLR=' + data.lrwithcode + '&extra=' + extra + '&gst=no&time3='+ data.timestamp +'" id="printbtn_' + data.lrn + '" target="_blank"><i class="fa fa-print"></i></a></button></div><div><button class="btn btn-sm-primary p-1"><a href="display_lr_details.php?lrn=' + data.lrwithcode + '&time2='+ data.timestamp +'" id="searchbtn_' + data.lrn + '" target="_blank"><i class="fa fa-search edit_icon"></i></a></button></div></div>';
                        }
                        
                    }
                }
            },
        ],
        "paging": false,
        "select": false,
        "createdRow": function(row, data, dataIndex) {
            if (data.status === "deleted") {
                jQuery('td', row).each(function() {
                    jQuery(this).html('<del>' + jQuery(this).html() + '</del>');
                });
            }
        },
       "footerCallback": function(row, data, start, end, display) {
            var api = this.api();
            var total = api
                .column(6)
                .data()
                .reduce(function(a, b) {
                    return a + parseFloat(b) || 0;
                }, 0);

            jQuery(api.column(6).footer()).html(total);
        },
        "bDestroy": true,
    });
})

function delete_parcel(Id,Time){
    var strconfirm = confirm("Are You Sure Want To Delete This Parcel Details?");

    if (strconfirm == true) {
        jQuery.ajax({
            "url": "delete_parcel.php",
            "type": "POST",
            "data": {
                "id": Id,
                "time" : Time,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

function restore_parcel(Id,Time){
    var strconfirm = confirm("Are You Sure Want To Restore This Parcel Details?");

    if (strconfirm == true) {
        jQuery.ajax({
            "url": "restore_parcel.php",
            "type": "POST",
            "data": {
                "id": Id,
                "time" : Time,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

//user accounts detail table

jQuery(document).ready(function(){
     
        var fdate = jQuery("#filter_date").val();
        var branch = jQuery("#account_branch").val();
        var extra_fees = jQuery("#extra_charge").val();
        
        jQuery("#tbl_account_info").DataTable({
            "searching": true,
            "filter": true,
            "processing": true,
            "serverSide": true,
            "bInfo": true,
            "ajax": {
                "url": "display_user_accounts.php",
                "type": "POST",
                "data": {
                    "filter_date": fdate,
                    "account_branch": branch,
                    "extra_charge": extra_fees
                },
            },
            "columns": [
                { "data": "sno", sortable: true },
                { "data": "nameone", sortable: true },
                {
                    "data": null,
                    className: "dt-center editor-edit",
                    sortable: false,
                    render: function (data, type, row) {
                        return '<form action="print_account_invoice.php" method="POST" target="_blank" style="display: inline;"><input type="hidden" name="sno" value="' + data.sno + '"><input type="hidden" name="date_range" value="' + fdate + '"><input type="hidden" name="person" value="' + data.nameone + '"><input type="hidden" name="charge" value="' + extra_fees + '"><input type="hidden" name="print" value="true"><button type="submit" style="background: none; border: none; cursor: pointer;"><i class="fas fa-print edit_icon  me-3"></i></button></form><form action="print_account_invoice.php" method="post" target="_blank" style="display: inline;"><input type="hidden" name="sno" value="' + data.sno + '"><input type="hidden" name="date_range" value="' + fdate + '"><input type="hidden" name="person" value="' + data.nameone + '"><input type="hidden" name="charge" value="' + extra_fees + '"><input type="hidden" name="print" value="false"><button type="submit" style="background: none; border: none; cursor: pointer;"><i class="fa fa-file edit_icon"></i></button></form>';
                    }                                           
                }
            ],
            "paging": true,
            "pageLength": 10,
            "select": true,
            "order": [
                [1, 'desc']
            ],
            "initComplete": function(settings, json) {
                var currentUrl = window.location.href;
                var newUrl = currentUrl.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
                // window.location.href = newUrl;
            },
            "bDestroy": true,
        });
    
});

function printInvoice(isPrint, sno) {
    var printUrl = 'print_account_invoice.php?sno=' + sno + '&date_range=' + fdate + '&person=' + data.nameone + '&charge=' + extra_fees + '&print=' + isPrint;
    var win = window.open(printUrl, '_blank');
    win.focus();

    // After printing, remove attributes from the URL
    if (win && isPrint) {
        win.addEventListener('load', function () {
            win.history.pushState({}, document.title, 'print_account_invoice.php');
        });
    }
}

jQuery(document).ready(function(){
    jQuery(".btn_save_setting").click(function(){

       var company = jQuery(".company_name").val();
       var head_office = jQuery(".main-head").val();
       var main_city = jQuery(".main-city").val();
       var logo_url = jQuery(".logo_url").val();
       var setting_update = jQuery("#generalsetting").val();

       jQuery.ajax({
            "url": "company_setting_logic.php",
            "type": "POST",
            "data": {
                "company": company,
                "head_office" : head_office,
                "main_city" : main_city,
                "logo" : logo_url,
                "setting_update" : setting_update,
            },
            success: function (response) {
                alert(response);
            },

        });
    });
});

jQuery(document).ready(function(){
    jQuery("#add_driver").click(function(){
        var dname = jQuery("#driver_name").val();
        var dnumber = jQuery("#driver_number").val();
        var edit = jQuery("#edit_driver").val();
        var dsno = jQuery("#edit_id").val();
      
        jQuery.ajax({
            "url" : "add_driver_details.php",
            "type" : "POST",
            "data" : {
                "driver_name" : dname,
                "driver_number" : dnumber,
                "edit_permission" : edit,
                "edit_id" : dsno,
            },
            "success" : function(response){
                alert(response);
                var currentUrl = window.location.href;
                var newUrl = currentUrl.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
                window.location.href = newUrl;
            }
        });

    });
});

jQuery(document).ready(function(){
    jQuery("#tbl_driver_info").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "bInfo": true,
        "ajax" : {
            "url" : "display_driver_details.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "name", sortable: true },
            { "data": "mobile", sortable: true },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    return '<div><a href="driver_cunductor_setting.php?sno=' + data.sno + '&edit=true" id="editbtn_' + data.sno + '" ><i class="fas fa-edit edit_icon"></i></a><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_driver(' + data.sno + ')"><i class="fa fa-trash delete_icon" style="padding:5px;"></i></a></div>';
                }
            },
        ],
        "language": {
            searchPlaceholder: "Search By Name"
        },
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [1, 'asc'],
        ],
        "bDestroy": true,
    });
});

//delete driver

function delete_driver(Id){
    var strconfirm = confirm("Are You Sure Want To Delete This Driver Details?");

    if (strconfirm == true) {
        jQuery.ajax({
            "url": "delete_driver.php",
            "type": "POST",
            "data": {
                "id": Id,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

// jQuery(document).ready(function(){
//     jQuery(".btn_add_branch").click(function(){
        
//        var bname = jQuery("#branch_name").val();
//        var bcode = jQuery("#branch_code").val();
//        var gbcode = jQuery("#gst_branch_code").val();
//        var bstate = jQuery("#branch_state").val();
//        var bcity = jQuery("#branch_city").val();
//        var min_lr = jQuery("#minimum_lr").val();
//        var max_lr = jQuery("#maximum_lr").val();
//        var bmobile = jQuery("#branch_mobile").val();
//        var is_head = jQuery('input[name="Head_Office"]:checked').val();
//        var bheading = jQuery("#print_heading").val();
//        var baddress = jQuery("#address").val();
//        var tcolor = jQuery("#branch_title_color").val();
//        var edit = jQuery("#edit_branch").val();
//        var add = jQuery("#add_branch").val();
//        var edit_id = jQuery("#edit_id").val();
//        var top_margin = jQuery("#top_margin").val();
//        var scale_ratio = jQuery("#scale_ratio").val();
//        var first_branch = jQuery("#first_branch").val();

//         jQuery.ajax({
//             "url" : "add_new_branch_details.php",
//             "type" : "POST",
//             "data" : {
//                 "branch_name" : bname,
//                 "branch_code" : bcode,
//                 "gst_branch_code" : gbcode,
//                 "branch_state" : bstate,
//                 "branch_city" : bcity,
//                 "minimum_lr" : min_lr,
//                 "maximum_lr" : max_lr,
//                 "branch_mobile" : bmobile,
//                 "is_head" : is_head,
//                 "branch_heading" : bheading,
//                 "branch_address" : baddress,
//                 "title_color" : tcolor,
//                 "edit_branch" : edit,
//                 "top_margin" : top_margin,
//                 "scale_ratio" : scale_ratio,
//                 "branch_id" : edit_id,
//                 "first_branch" : first_branch
//             },
//             "success" : function(response){
//                 alert(response);
//                 location.reload();
//                 var currentUrl = window.location.href;
//                 var newUrl = currentUrl.split('?')[0];
//                 window.history.replaceState({}, document.title, newUrl);
//                 window.location.href = newUrl;
//             }
//         });
//     });
// });

jQuery(document).ready(function(){
    jQuery("#tbl_branch_info").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "ordering" : false,
        "bInfo": true,
        "ajax" : {
            "url" : "display_branch_details.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "name", sortable: true },
            { "data": "code", sortable: true },
            { "data": "gst_code", sortable: true },
            { "data": "city", sortable: true },
            { "data": "phone", sortable: true },
            { "data": "minnum", sortable: true },
            { "data": "maxnum", sortable: true },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    return '<div><a href="branch_setting.php?sno=' + data.sno + '&edit=true" id="editbtn_' + data.sno + '" ><i class="fas fa-edit edit_icon"></i></a><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_branch(' + data.sno + ')"><i class="fa fa-trash delete_icon" style="padding:5px;"></i></a></div>';
                }
            },  
        ],
        "createdRow": function (row, data, dataIndex) {
            var cell = jQuery('td', row).eq(9);
            var colorCode = cell.text();
            cell.css('background-color', colorCode);
            cell.css('color', colorCode);
        },
        "language": {
            searchPlaceholder: "Search By Branch Name"
        },
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [1, 'asc'],
        ],
        "bDestroy": true,
    });
});

//delete customer
function delete_customer(Id){
    var strconfirm = confirm("Are You Sure Want To Delete This Customer Details?");

    if (strconfirm == true) {
        jQuery.ajax({
            "url": "delete_customer.php",
            "type": "POST",
            "data": {
                "id": Id,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

//display customers
jQuery(document).ready(function(){
    jQuery("#tbl_customer_info").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "ordering" : false,
        "bInfo": true,
        "ajax" : {
            "url" : "display_customers.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "rid", sortable: true },
            { "data": "sender_name", sortable: true },
            { "data": "sender_mobile", sortable: true },
            { "data": "sender_gst", sortable: true },
            { "data": "receiver_name", sortable: true },
            { "data": "receiver_mobile", sortable: true },
            { "data": "receiver_gst", sortable: true },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    return '<div><a href="relation_management.php?sno=' + data.sno + '&edit=true" id="editbtn_' + data.sno + '" ><i class="fas fa-edit edit_icon"></i></a><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_customer(' + data.sno + ')"><i class="fa fa-trash delete_icon" style="padding:5px;"></i></a></div>';
                }
            },  
        ],
        "createdRow": function (row, data, dataIndex) {
            var cell = jQuery('td', row).eq(9);
            var colorCode = cell.text();
            cell.css('background-color', colorCode);
            cell.css('color', colorCode);
        },
        "language": {
            searchPlaceholder: "Search By Branch Name"
        },
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [1, 'asc'],
        ],
        "bDestroy": true,
    });
});

// delete branch
function delete_branch(Id){
    var strconfirm = confirm("Are You Sure Want To Delete This Branch Details?");

    if (strconfirm == true) {
        jQuery.ajax({
            "url": "delete_branch.php",
            "type": "POST",
            "data": {
                "id": Id,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },

        });
    }

}

jQuery(document).ready(function(){
    jQuery("#btn_edit_acc").click(function(){
        var correct_name = jQuery("#right_acc_name").val();
        var incorrect_name = jQuery("#wrong_acc_name").val();
       
        jQuery.ajax({
            "url" : "edit_account_holder.php",
            "type" : "POST",
            "data" : {
                "correct_name" : correct_name,
                "incorrect_name" : incorrect_name,
            },
            "success" : function(response){
                alert(response);
                var currentUrl = window.location.href;
                var newUrl = currentUrl.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
                window.location.href = newUrl;
            }
        });

    });
});

jQuery(document).ready(function(){
    jQuery("#tbl_acc_holders").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "ordering" : false,
        "bInfo": true,
        "ajax" : {
            "url" : "display_acc_holder_details.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "nameone", sortable: true },
        ],
        "language": {
            searchPlaceholder: "Search By Name"
        },
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [1, 'asc'],
        ],
        "bDestroy": true,
    });
});

jQuery(document).ready(function(){
    var user = jQuery("#current_user").val();
    jQuery("#tbl_branch_users").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "bInfo": true,
        "ajax" : {
            "url" : "display_branch_users_details.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "username", sortable: true },
            { "data": "branch", sortable: true },
            { "data": "roll", sortable: true },
            { "data": "date", sortable: true },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    if(row.username != user && (row.roll == "SuperDuperAdmin" || row.roll == "SuperAdmin" || row.roll == "Admin")){
                    return '<div><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick=""><i class="fa-solid fa-lock delete_icon"></i></a></div>';
                }else{
                    return '<div><a href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="reset_password(' + data.sno + ')"><i class="fa-solid fa-key delete_icon"></i></a></div>';
                }
            }
        },
        ],
        "language": {
            searchPlaceholder: "Search By Name"
        },
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [1, 'asc'],
        ],
        "bDestroy": true,
    });
});

// sender data list
jQuery(document).ready(function(){
    jQuery("#senderEdit").on("input" , function(){
        var sender = jQuery("#senderEdit").val();
        if(sender.length >= 3)
        {
            jQuery.ajax({
                "url" : "get_sender.php",
                "type" : "POST",
                "data" : {
                    "sender" : sender,
                },
                "success" : function(response) {
                    var dataList = jQuery('#sendername');
                    dataList.empty();
                    var results = JSON.parse(response);
                    results.forEach(function(item) {
                        dataList.append('<option value="' + item + '">'+ item +'</option>');
                    });
                }
            });
        }
    });
});

//receiver data list
jQuery(document).ready(function(){
    jQuery("#reciverEdit").on("input" , function(){
        var receiver = jQuery("#reciverEdit").val();
        if(receiver.length >= 3)
        {
            jQuery.ajax({
                "url" : "get_receiver.php",
                "type" : "POST",
                "data" : {
                    "receiver" : receiver,
                },
                "success" : function(response) {
                    var dataList = jQuery('#recivername');
                    dataList.empty();
                    var results = JSON.parse(response);
                    results.forEach(function(item) {
                        dataList.append('<option value="' + item + '">'+ item +'</option>');
                    });
                }
            });
        }
    });
});


//searching lr validation
jQuery(document).ready(function(){
    jQuery(".search_lr").click(function(){
        jQuery("#search_by_lr").validate({
            rules : {
                lr_number : {
                    required: true,
                }
            },
            messages : {
                lr_number : {
                    required: "<span class='text-danger'>* Please enter the LR number *</span>",
                },
            }
        });
    });
});

//transportentry validation
jQuery(document).ready(function(){
    const urlParams = new URLSearchParams(window.location.search);
    const page = urlParams.get('page');
    const isSenderNumRequired = page !== null && page !== 'transport';

    let gstErrorMessage = "";

jQuery.validator.addMethod("gstFormat", function (value, element) {
    // Check if the length is exactly 15 characters
    if (value === "") {
        return true;
    }

    if (value.length !== 15) {
        gstErrorMessage = "<span class='text-danger'>GST number must be exactly 15 characters long.</span>";
        return false;
    }

    // Check if the first two characters are digits (State code)
    if (!/^[0-9]{2}$/.test(value.substring(0, 2))) {
        gstErrorMessage = "<span class='text-danger'>The first two characters of the GST number must be digits (State code).</span>";
        return false;
    }

    // Check if the next 10 characters follow PAN format (AAAAA0000A)
    if (!/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(value.substring(2, 12))) {
        gstErrorMessage = "<span class='text-danger'>Characters 3 to 12 of the GST number must follow the PAN format (AAAAA0000A).</span>";
        return false;
    }

    // Check if the 13th character is alphanumeric
    if (!/^[A-Z0-9]{1}$/.test(value.substring(12, 13))) {
        gstErrorMessage = "<span class='text-danger'>The 13th character of the GST number must be a letter or digit.</span>";
        return false;
    }

    // Check if the 14th character is 'Z'
    if (value.substring(13, 14) !== 'Z') {
        gstErrorMessage = "<span class='text-danger'>The 14th character of the GST number must be 'Z'.</span>";
        return false;
    }

    // Check if the 15th character is alphanumeric
    if (!/^[A-Z0-9]{1}$/.test(value.substring(14, 15))) {
        gstErrorMessage = "<span class='text-danger'>The 15th character of the GST number must be a letter or digit.</span>";
        return false;
    }

    // If all checks pass
    gstErrorMessage = ""; // Clear error message
    return true;
}, function () {
    return gstErrorMessage; // Return the specific error message
});

    jQuery(".btn_save_item").click(function(){
        jQuery("#add_product_details").validate({
            rules : {
                'senderEdit' : {
                    required : true,
                },
                'sendernumEdit' : {
                    required : isSenderNumRequired,
                    minlength : 10,
                    maxlength : 10,
                },
                'senderGST' : {
                    required : true,
                    gstFormat: true,
                },
                'reciverEdit' : {
                    required : true,
                },
                'recivernumEdit' : {
                    required : isSenderNumRequired,
                    minlength : 10,
                    maxlength : 10,
                },
                'reciverGST' : {
                    required : true,
                    gstFormat: true,
                },
                'detail[]' : {
                    required : true,
                },
                // 'rate[]' : {
                //     required : true,
                // }
            },
            messages : {
                'senderEdit' : {
                    required : "* Please select the sender name *",
                },
                'sendernumEdit' : {
                    required : "* Please enter the sender mobile number *",
                    minlength :"* Please enter minimum 10 digit number *",
                    maxlength :"* Please enter maximum 10 digit number *",
                },
                'senderGST': {
                    required: "* Please enter the sender GST number *",
                    gstFormat: function () {
                        return gstErrorMessage;
                    },
                },
                'reciverEdit' : {
                    required : "* Please select the receiver name *",
                },
                'recivernumEdit' : {
                    required : "* Please enter the receiver mobile number *",
                    minlength :"* Please enter minimum 10 digit number *",
                    maxlength :"* Please enter maximum 10 digit number *",
                },
                'reciverGST' : {
                    required : "* Please enter the receiver GST number *",
                    gstFormat: function () {
                        return gstErrorMessage;
                    },
                },
                'detail[]' : {
                    required : "* Please select atleast one item *",
                },
                // 'rate[]' : {
                //     required : "*Enter the rate*",
                // }
            },
            submitHandler: function(form) {
                var strmsg = confirm('બુકિંગ વેરીફીકેસન');
                if (strmsg) {
                    form.submit(); 
                }
            }
        });
    });

    //customer relation validation 
    jQuery(".btn_add_customer").click(function(){
        jQuery("#add_customer").validate({
            rules : {
                'sender_name' : {
                    required : true,
                },
                'sender_no' : {
                    required : true,
                    minlength : 10,
                    maxlength : 10,
                },
                'sender_gst' : {
                    gstFormat: true,
                },
                'receiver_name' : {
                    required : true,
                },
                'receiver_no' : {
                    required : true,
                    minlength : 10,
                    maxlength : 10,
                },
                'receiver_gst' : {
                    gstFormat: true,
                },
                'detail[]' : {
                    required : true,
                },
            },
            messages : {
                'sender_name' : {
                    required : "<span class='text-danger w-100'>* Please enter the sender name *</span>",
                },
                'sender_no' : {
                    required : "<span class='text-danger'>* Please enter the sender mobile number *</span>",
                    minlength :"<spman class='text-danger'>* Please enter minimum 10 digit number *</spman>",
                    maxlength :"<span class='text-danger'>* Please enter maximum 10 digit number *</span>",
                },
                'sender_gst': {
                    gstFormat: function () {
                        return gstErrorMessage;
                    },
                },
                'receiver_name' : {
                    required : "<span class='text-danger'>* Please enter the receiver name *</span>",
                },
                'receiver_no' : {
                    required : "<span class='text-danger'>* Please enter the receiver mobile number *</span>",
                    minlength :"<span class='text-danger'>* Please enter minimum 10 digit number *</span>",
                    maxlength :"<span class='text-danger'>* Please enter maximum 10 digit number *</span>",
                },
                'receiver_gst' : {
                    gstFormat: function () {
                        return gstErrorMessage;
                    },
                },
            },
            submitHandler: function(form) {
                form.submit(); 
            }
        });
    });

    //add new branch validation
    jQuery(document).ready(function () {
        jQuery("#create_new_branch").validate({
            rules: {
                'branch_name': {
                    required: true,
                },
                'branch_mobile': {
                    required: true,
                },
                'branch_code': {
                    required: true,
                },
                'gst_branch_code': {
                    required: true,
                },
                'branch_state': {
                    required: true,
                },
                'branch_city': {
                    required: true,
                },
                'print_heading': {
                    required: true,
                },
                'minimum_lr': {
                    required: true,
                },
                'maximum_lr': {
                    required: true,
                },
                'address': {
                    required: true,
                },
                'top_margin': {
                    required: true,
                },
                'scale_ratio': {
                    required: true,
                },
            },
            messages: {
                'branch_name': {
                    required: "<span class='text-danger w-100'>* Please enter the branch name *</span>",
                },
                'branch_mobile': {
                    required: "<span class='text-danger'>* Please enter mobile number *</span>",
                },
                'branch_code': {
                    required: "<span class='text-danger'>* Please enter the branch code *</span>",
                },
                'gst_branch_code': {
                    required: "<span class='text-danger'>* Please enter the gst branch code *</span>",
                },
                'minimum_lr': {
                    required: "<span class='text-danger'>* Please enter the minimum lr number *</span>",
                },
                'maximum_lr': {
                    required: "<span class='text-danger'>* Please enter the maximum lr number *</span>",
                },
                'branch_state': {
                    required: "<span class='text-danger'>* Please select the branch state *</span>",
                },
                'branch_city': {
                    required: "<span class='text-danger'>* Please select the branch city *</span>",
                },
                'print_heading': {
                    required: "<span class='text-danger'>* Please select the branch heading *</span>",
                },
                'address': {
                    required: "<span class='text-danger'>* Please enter the branch address *</span>",
                },
                'top_margin': {
                    required: "<span class='text-danger'>* Please enter the top margin *</span>",
                },
                'scale_ratio': {
                    required: "<span class='text-danger'>* Please enter the scale ratio *</span>",
                },
            },
            submitHandler: function (form) {
                var bname = jQuery("#branch_name").val();
                var bcode = jQuery("#branch_code").val();
                var gbcode = jQuery("#gst_branch_code").val();
                var bstate = jQuery("#branch_state").val();
                var bcity = jQuery("#branch_city").val();
                var min_lr = jQuery("#minimum_lr").val();
                var max_lr = jQuery("#maximum_lr").val();
                var bmobile = jQuery("#branch_mobile").val();
                var is_head = jQuery('input[name="Head_Office"]:checked').val();
                var bheading = jQuery("#print_heading").val();
                var baddress = jQuery("#address").val();
                var tcolor = jQuery("#branch_title_color").val();
                var edit = jQuery("#edit_branch").val();
                var edit_id = jQuery("#edit_id").val();
                var top_margin = jQuery("#top_margin").val();
                var scale_ratio = jQuery("#scale_ratio").val();
                var first_branch = jQuery("#first_branch").val();
    
                jQuery.ajax({
                    "url": "add_new_branch_details.php",
                    "type": "POST",
                    "data": {
                        "branch_name": bname,
                        "branch_code": bcode,
                        "gst_branch_code": gbcode,
                        "branch_state": bstate,
                        "branch_city": bcity,
                        "minimum_lr": min_lr,
                        "maximum_lr": max_lr,
                        "branch_mobile": bmobile,
                        "is_head": is_head,
                        "branch_heading": bheading,
                        "branch_address": baddress,
                        "title_color": tcolor,
                        "edit_branch": edit,
                        "top_margin": top_margin,
                        "scale_ratio": scale_ratio,
                        "branch_id": edit_id,
                        "first_branch": first_branch
                    },
                    "success": function (response) {
                        alert(response);
                        location.reload();
                        var currentUrl = window.location.href;
                        var newUrl = currentUrl.split('?')[0];
                        window.history.replaceState({}, document.title, newUrl);
                        window.location.href = newUrl;
                    }
                });
    
                return false;
            }
        });
    });

    jQuery("#btn_add_member").click(function(){
        jQuery("#add_new_member").validate({
            rules : {
                'user_name' : {
                    required : true,
                },
                'user_password' : {
                    required : true,
                },
                'confirm_password' : {
                    required: true,
                },
            },
            messages : {
                'user_name' : {
                    required : "<span class='text-danger w-100'>* Please enter the User name *</span>",
                },
                'user_password' : {
                    required : "<span class='text-danger'>* Please enter the password *</span>",
                },
                'confirm_password': {
                    required : "<span class='text-danger'>* Please enter the confirm password *</span>",
                },
            },
            submitHandler: function (form) {
                var username = jQuery("#user_name").val();
                var user_passwd = jQuery("#user_password").val();
                var confirm_passwd = jQuery("#confirm_password").val();
                var branch = jQuery("#user_branch").val();
                var role = jQuery("#user_designation").val();

                jQuery.ajax({
                    "url": "add_new_company_member.php",
                    "type": "POST",
                    "data": {
                        "username": username,
                        "user_passwd": user_passwd,
                        "confirm_passwd": confirm_passwd,
                        "branch": branch,
                        "role": role,
                    },
                    "success": function (response) {
                        alert(response);
                        location.reload();
                    }
                })

                return false;
            }
        });
    });
    
});

//login page validation
jQuery(document).ready(function(){
    jQuery(".btn_login_user").click(function(){
        jQuery("#login-form").validate({
            rules : {
                company_code : {
                    required: true,
                    minlength : 4,
                    maxlength : 4,
                },
                username : {
                    required: true,
                },
                password : {
                    requires : true,
                }
            },
            messages : {
                company_code : {
                    required: "<span class='text-danger'>* Please enter the company code *</span>",
                    minlength : "<span class='text-danger'>* Please enter atleast 4 digit company code *</span>",
                    maxlength : "<span class='text-danger'>* Please enter only 4 digit company code *</span>",
                },
                username : {
                    required: "<span class='text-danger'>* Please enter the username *</span>",
                },
                password : {
                    required : "<span class='text-danger'>* Please enter the password *</span>"
                }
            }
        });
    });
});

jQuery(document).ready(function(){
    jQuery(".btn_paid").click(function(){
        jQuery(".data_paid .d-none").removeClass('d-none').addClass('d-block');
        jQuery(".data_all div").addClass('d-none').removeClass('d-block');
        jQuery(".data_pay div").addClass('d-none').removeClass('d-block');
        jQuery(".data_account div").addClass('d-none').removeClass('d-block');
    });

    jQuery(".btn_pay").click(function(){
        jQuery(".data_pay .d-none").removeClass('d-none').addClass('d-block');
        jQuery(".data_all div").addClass('d-none').removeClass('d-block');
        jQuery(".data_paid div").addClass('d-none').removeClass('d-block');
        jQuery(".data_account div").addClass('d-none').removeClass('d-block');
    });

    jQuery(".btn_account").click(function(){
        jQuery(".data_account .d-none").removeClass('d-none').addClass('d-block');
        jQuery(".data_all div").addClass('d-none').removeClass('d-block');
        jQuery(".data_paid div").addClass('d-none').removeClass('d-block');
        jQuery(".data_pay div").addClass('d-none').removeClass('d-block');
    });

    jQuery(".btn_all").click(function(){
        jQuery(".data_all div").addClass('d-block').removeClass('d-none');
        jQuery(".data_account div").addClass('d-none').removeClass('d-block');
        jQuery(".data_paid div").addClass('d-none').removeClass('d-block');
        jQuery(".data_pay div").addClass('d-none').removeClass('d-block');
    });

});

function updateChart(seriesData, labelsData) {

    chart.updateOptions({
        series: seriesData,
        labels: labelsData,
    });
}

function updateChart2(seriesData1) {
    chart1.updateOptions({
        series: seriesData1,
    });
}

jQuery(document).ready(function(){
    jQuery(".btn_paid").click(function () {
        if(paid_total == "")
        {
            jQuery(".piechart").addClass('d-none');
            jQuery(".err-msg").addClass('d-block').removeClass('d-none');
        }else
        {
            jQuery(".piechart").addClass('d-block').removeClass('d-none');
            jQuery(".err-msg").addClass('d-none').removeClass('d-block');
        }
        var piechartColors = getChartColorsArray("#wallet-balance");
        var paidOptions = {
            series: paid_total,
            labels: paid_branch,
            colors: piechartColors
        };
        updateChart(paidOptions.series, paidOptions.labels);
    });

    jQuery(".btn_pay").click(function () {
        if(topay_total == "")
        {
            jQuery(".piechart").addClass('d-none');
            jQuery(".err-msg").addClass('d-block').removeClass('d-none');;
        }else
        {
            jQuery(".piechart").addClass('d-block').removeClass('d-none');
            jQuery(".err-msg").addClass('d-none').removeClass('d-block');
        }
        var piechartColors = getChartColorsArray("#wallet-balance");
        var paidOptions = {
            series: topay_total,
            labels: topay_branch,
            colors: piechartColors
        };
        updateChart(paidOptions.series, paidOptions.labels);
    });

    jQuery(".btn_account").click(function () {
        if(account_total == "")
        {
            jQuery(".piechart").addClass('d-none');
            jQuery(".err-msg").addClass('d-block').removeClass('d-none');;
        }else
        {
            jQuery(".piechart").addClass('d-block').removeClass('d-none');
            jQuery(".err-msg").addClass('d-none').removeClass('d-block');
        }
        var piechartColors = getChartColorsArray("#wallet-balance");
        var paidOptions = {
            series: account_total,
            labels: account_branch,
            colors: piechartColors
        };
        updateChart(paidOptions.series, paidOptions.labels);
    });

    jQuery(".btn_all").click(function () {
        if(all_total == "")
        {
            jQuery(".piechart").addClass('d-none');
            jQuery(".err-msg").addClass('d-block').removeClass('d-none');
        }else
        {
            jQuery(".piechart").addClass('d-block').removeClass('d-none');
            jQuery(".err-msg").addClass('d-none').removeClass('d-block');
        }
        var piechartColors = getChartColorsArray("#wallet-balance");
        var paidOptions = {
            series: all_total,
            labels: all_branch,
            colors: piechartColors
        };
        updateChart(paidOptions.series, paidOptions.labels);
    });
});

jQuery(document).ready(function(){
    jQuery(".month-select").change(function(){
        var month = jQuery(this).find(":selected").val();
        jQuery.ajax({
            "url" : "branch_investment.php",
            "type" : "POST",
            "data" : {
                "month" : month,
            },
            "success" : function(response) {
                var data = JSON.parse(response);
                var income = data.income;
                var expense = data.expense;
                var total = data.total;

                var invested_total = parseInt(income) + parseInt(expense) + parseInt(total);
                if(invested_total == 0)
                {
                    invested_total = 1;
                }
                var income_per = ((parseInt(total) + parseInt(income)) * 100) / invested_total;
                var income_per = income_per != null ? (Math.ceil(income_per)) : 0;

                jQuery(".income-main .income").text("+ ₹"+income);
                jQuery(".expense-main .expense").text("- ₹"+expense);
                jQuery(".investment .invested_amount").text("₹"+total);

                var seriesData1 = [income_per];  
                updateChart2(seriesData1);
                
            }
        });
    });
});

jQuery(document).ready(function(){
    jQuery(".headingSize").change(function(){
        var font_size = this.value;
       
        if(font_size == "small")
        {
            jQuery(".heading-style").css("font-size","small");
        }
        if(font_size == "medium")
        {
            jQuery(".heading-style").css("font-size","medium");
        }
        if(font_size == "large")
        {
            jQuery(".heading-style").css("font-size","large");
        }
        if(font_size == "x-large")
        {
            jQuery(".heading-style").css("font-size","x-large");
        }

    });

    jQuery(".fontSize").change(function(){
        var font_size = this.value;
        
        if(font_size == "small")
        {
            jQuery(".receipt-body-style").css("font-size","small");
        }
        if(font_size == "medium")
        {
            jQuery(".receipt-body-style").css("font-size","medium");
        }
        if(font_size == "large")
        {
            jQuery(".receipt-body-style").css("font-size","large");
        }
        if(font_size == "x-large")
        {
            jQuery(".receipt-body-style").css("font-size","x-large");
        }

    });

    jQuery(".lrnSize").change(function(){
        
        var font_size = this.value;
       
        if(font_size == "small")
        {
            jQuery(".lrn-size").css("font-size","small");
        }
        if(font_size == "medium")
        {
            jQuery(".lrn-size").css("font-size","medium");
        }
        if(font_size == "large")
        {
            jQuery(".lrn-size").css("font-size","large");
        }
        if(font_size == "x-large")
        {
            jQuery(".lrn-size").css("font-size","x-large");
        }

    });
});

//on toggle remove item details
jQuery(document).ready(function(){

    jQuery("#book_office").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".booking_ofc1").removeClass("d-none");

        }
        else
        {
            jQuery(".booking_ofc1").addClass("d-none");
        }
    });

    jQuery("#sending_place").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".sending_ofc1").removeClass("d-none");
        }
        else
        {
            jQuery(".sending_ofc1").addClass("d-none");
        }
    });

    jQuery("#gst_detail").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".print_gst1").removeClass("d-none");
        }
        else
        {
            jQuery(".print_gst1").addClass("d-none");
        }
    });

    jQuery("#remarks").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".remark").removeClass("d-none");
        }
        else
        {
            jQuery(".remark").addClass("d-none");
        }
    });
    

    jQuery("#booking_time").on("change" , function(){

        if(jQuery(this).is(":checked"))
        {
            jQuery(".book_time1").removeClass("d-none");
            jQuery(".prnt_time1").addClass("border-start-1");
            
        }
        else
        {
            jQuery(".book_time1").addClass("d-none");
            jQuery(".prnt_time1").addClass("border-start-0");
         
        }
    });

    jQuery("#print_office").on("change", function () {
        if (jQuery(this).is(":checked")) {
            jQuery(".prnt_time1").removeClass("d-none"); 
            // Use inline JavaScript to set style with !important
            document.querySelector(".book_time1").style.setProperty("border-right", "1px solid #000", "important");
        } else {
            jQuery(".prnt_time1").addClass("d-none");
            // Reset the border-right style
            document.querySelector(".book_time1").style.setProperty("border-right", "0", "important");
        }
    });
    

    jQuery("#booking_time, #print_office").on("change", function() {

        if (!jQuery("#booking_time").is(":checked") && !jQuery("#print_office").is(":checked")) {
                // Remove border by adding the "no border" class and removing the "with border" class
                jQuery('.remark_border')
                    // .removeClass('remark_border_with_border')
                    .css('border-bottom','1px solid #000 !important');
        }
        if (!jQuery("#booking_time").is(":checked") && !jQuery("#print_office").is(":checked")) {
            // Remove border by adding the "no border" class and removing the "with border" class
            jQuery('.remark_border')
                .removeClass('remark_border_with_border')
                .addClass('remark_border_no_border');
        } else {
            // Add border by adding the "with border" class and removing the "no border" class
            jQuery('.remark_border')
                .removeClass('remark_border_no_border')
                .addClass('remark_border_with_border');
        }
    });
    

    jQuery("#book_office2").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".booking_ofc2").removeClass("d-none");
            jQuery(".place_to_send").removeAttr("colspan","2");
            jQuery(".row_lrn").removeAttr("colspan","4");
        }
        else
        {
            jQuery(".booking_ofc2").addClass("d-none");
            jQuery(".place_to_send").attr("colspan","2");
            jQuery(".row_lrn").attr("colspan","4");
        }
    });

    jQuery("#place_send2").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".place_to_send").removeClass("d-none");
            jQuery(".row_lrn").removeAttr("colspan","4");
        }
        else
        {
            jQuery(".place_to_send").addClass("d-none");
            jQuery(".row_lrn").attr("colspan","4");
        }
    });

    jQuery("#place_send2,#book_office2").on("change" , function(){
        if(jQuery("#book_office2").is(":checked"))
        {
            jQuery(".row_lrn").attr("colspan","4");
        }

        if(jQuery("#place_send2").is(":checked"))
        {
            jQuery(".row_lrn").attr("colspan","4");
        }
    });

    jQuery("#gst_detail2").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".gst_print2").removeClass("d-none");
        }
        else
        {
            jQuery(".gst_print2").addClass("d-none");
        }
    });

    jQuery("#remarks_pr2").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".remark_print2").removeClass("d-none");
        }
        else
        {
            jQuery(".remark_print2").addClass("d-none");
        }
    });

    jQuery("#booking_time2").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".book_time2").removeClass("d-none");
        }
        else
        {
            jQuery(".book_time2").addClass("d-none");
        }
    });

    jQuery("#print_time2").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".print_time2").removeClass("d-none");
        }
        else
        {
            jQuery(".print_time2").addClass("d-none");
        }
    });

    jQuery("#booking_time2 , #print_time2").on("change",function(){
        if(!jQuery("#booking_time2 , #print_time2").is(":checked"))
        {
            jQuery(".date_time2").addClass("d-none");
            jQuery(".receiver_section").attr("colspan","2");
        }
        else
        {
            jQuery(".date_time2").removeClass("d-none");
            jQuery(".receiver_section").attr("colspan","1");
        }
    });

    jQuery("#book_office3").on("change" , function(){
       if(jQuery(this).is(":checked"))
       {
            jQuery(".book_print3").removeClass("d-none");
       }
       else
       {
            jQuery(".book_print3").addClass("d-none");
       }
    });

    jQuery("#place_send3").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_plc3").removeClass("d-none");
             jQuery(".print_book3").removeAttr("colspan" , "3");
        }
        else
        {
             jQuery(".print_plc3").addClass("d-none");
             jQuery(".print_book3").attr("colspan" , "3");
        }
     });

     jQuery("#gst_details_print3").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".gst_print3").removeClass("d-none");
        }
        else
        {
             jQuery(".gst_print3").addClass("d-none");
        }
     });

     jQuery("#remark_print3").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_remark3").removeClass("d-none");
        }
        else
        {
             jQuery(".print_remark3").addClass("d-none");
        }
     });

     jQuery("#booking_time3").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".book_date3").removeClass("d-none");
        }
        else
        {
             jQuery(".book_date3").addClass("d-none");
        }
     });

     jQuery("#print_tm3").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_date3").removeClass("d-none");
        }
        else
        {
             jQuery(".print_date3").addClass("d-none");
        }
     });

     jQuery("#booking_time3,#print_tm3").on("change",function(){
        if(!jQuery("#booking_time3,#print_tm3").is(":checked"))
        {
            jQuery(".print_book3").addClass("d-none");
            jQuery(".print_plc3").attr("colspan","3");
        }
        else
        {
            jQuery(".print_book3").removeClass("d-none");
            jQuery(".print_plc3").attr("colspan","2");
            
        }
    });

     jQuery("#book_office4").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".book_place4").removeClass("d-none");
        }
        else
        {
             jQuery(".book_place4").addClass("d-none");
        }
     });

     jQuery("#place_send4").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".place_print4").removeClass("d-none");
        }
        else
        {
             jQuery(".place_print4").addClass("d-none");
        }
     });  
     
     jQuery("#gst_details4").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_gst4").removeClass("d-none");
        }
        else
        {
             jQuery(".print_gst4").addClass("d-none");
        }
     }); 
    
     jQuery("#booking_time4").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".book_print4").removeClass("d-none");
        }
        else
        {
             jQuery(".book_print4").addClass("d-none");
        }
     });

     jQuery("#print_tm4").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_time4").removeClass("d-none");
        }
        else
        {
             jQuery(".print_time4").addClass("d-none");
        }
     });

     jQuery("#booking_time4,#print_tm4").on("change",function(){
        if(!jQuery("#booking_time4,#print_tm4").is(":checked"))
        {
            jQuery(".date_time4").addClass("d-none");
        }
        else
        {
            jQuery(".date_time4").removeClass("d-none");
            
        }
    });

     jQuery("#remark4").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".remark_print4").removeClass("d-none");
        }
        else
        {
             jQuery(".remark_print4").addClass("d-none");
        }
     });

     jQuery("#book_office5").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".book_print5").removeClass("d-none");
        }
        else
        {
             jQuery(".book_print5").addClass("d-none");
        }
     });

     jQuery("#place_send5").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".send_place5").removeClass("d-none");
        }
        else
        {
             jQuery(".send_place5").addClass("d-none");
        }
     });

     jQuery("#gst_details5").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_gst5").removeClass("d-none");
        }
        else
        {
             jQuery(".print_gst5").addClass("d-none");
        }
     });

     jQuery("#remark_print5").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".remark_5").removeClass("d-none");
        }
        else
        {
             jQuery(".remark_5").addClass("d-none");
        }
     });

     jQuery("#booking_time5").on("change", function () {
        if (jQuery(this).is(":checked")) {
            jQuery(".print_book5").removeClass("d-none");
        } else {
            jQuery(".print_book5").addClass("d-none");
        }
    });

     jQuery("#print_office5").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_time5").removeClass("d-none");
             jQuery(".print_book5").removeClass("border-end-0");
        }
        else
        {
             jQuery(".print_time5").addClass("d-none");
             jQuery(".print_book5").addClass("border-end-0");
        }
     });

     jQuery("#booking_time5,#print_office5").on("change",function(){
        if(!jQuery("#booking_time5,#print_office5").is(":checked"))
        {
            jQuery(".remark5").css("border-bottom","0 !important;");
        }
        else
        {
            jQuery(".date_time4").removeClass("d-none");
            
        }
    });

    jQuery("#booking_time5, #print_office5").on("change", function() {

        if (jQuery("#booking_time5").is(":checked") && !jQuery("#print_office5").is(":checked")) {
            jQuery(".print_book5").addClass("border-end-0");
        }
        
    });

     jQuery("#book_office6").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".book_ofc6").removeClass("d-none");
        }
        else
        {
             jQuery(".book_ofc6").addClass("d-none");
        }
     });

     jQuery("#place_send6").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_plc6").removeClass("d-none");
             jQuery(".print_date6").attr("colspan" , "4");
        }
        else
        {
             jQuery(".print_plc6").addClass("d-none");
             jQuery(".print_date6").attr("colspan" , "4");
        }
     });

     jQuery("#booking_time6").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".book_time6").removeClass("d-none");
        }
        else
        {
             jQuery(".book_time6").addClass("d-none");
        }
     });

     jQuery("#print_tm6").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_time6").removeClass("d-none");
        }
        else
        {
             jQuery(".print_time6").addClass("d-none");
        }
     });  

     jQuery("#booking_time6,#print_tm6").on("change",function(){
        if(!jQuery("#booking_time6,#print_tm6").is(":checked"))
        {
            jQuery(".print_date6").addClass("d-none");
            jQuery(".print_plc6").attr("colspan","3");
        }
        else
        {
            jQuery(".print_date6").removeClass("d-none");
            jQuery(".print_plc6").attr("colspan","2");  
        }
    });


     jQuery("#remark_details6").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".print_rematk6").removeClass("d-none");
        }
        else
        {
             jQuery(".print_rematk6").addClass("d-none");
        }
     });

     jQuery("#print_barcode6").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
            jQuery(".barcode").removeClass("d-none");
            jQuery(".notice").prop("colspan","2");
        }
        else
        {
            jQuery(".barcode").addClass("d-none");
            jQuery(".notice").prop("colspan","3");
        }
     });

     jQuery("#gst_details6").on("change" , function(){
        if(jQuery(this).is(":checked"))
        {
             jQuery(".gst_print6").removeClass("d-none");
        }
        else
        {
             jQuery(".gst_print6").addClass("d-none");
        }
     });

});

jQuery(document).ready(function(){
    jQuery("#heading_font").on("input",function(){
        var heading = jQuery(this).val();
        jQuery(".heading-style").css("font-size",heading+"px");
    });

    jQuery("#body_font").on("input",function(){
        var body = jQuery(this).val();
        jQuery(".receipt-body-style").css("font-size",body+"px");
    });

    jQuery("#lr_font").on("input",function(){
        var lr = jQuery(this).val();
        jQuery(".lrn-size").css("font-size",lr+"px");
    });
});


//get user data on transport entry

jQuery(document).ready(function(){
    jQuery("#sendernumEdit").blur(function(){
       
        var mobile = jQuery("#sendernumEdit").val();

        jQuery.ajax({
            "url" : "get_details.php",
            "type" : "POST",
            "dataType" : 'json',
            "data" : {
                "mobile" : mobile,
            },
            "success" : function(response) {
                if(response != null){
                jQuery("#senderEdit").val(response["nameone"]);
                jQuery("#senderGST").val(response["gstone"]);
                }
            }
        });

    });

    jQuery("#recivernumEdit").blur(function(){
        var mobile = jQuery("#recivernumEdit").val();

        jQuery.ajax({
            "url" : "get_details.php",
            "type" : "POST",
            "dataType" : 'json',
            "data" : {
                "mobile" : mobile,
            },
            "success" : function(response) {
                if(response != null){
                jQuery("#reciverEdit").val(response["nametwo"]);
                jQuery("#reciverGST").val(response["gsttwo"]);
                }
            }
        });

    });
});

jQuery(document).ready(function(){
    jQuery("#btn_add_item").click(function(){
        var itemen = jQuery("#itemen").val();
        var itemgu = jQuery("#itemgu").val();

        jQuery.ajax({
            "url" : "add_item_logic.php",
            "type" : "POST",
            "data" : {
                "itemen" : itemen,
                "itemgu" : itemgu,
            },
            "success" : function(response){
                alert(response);
                location.reload();
            }
        })
    })
});

jQuery(document).ready(function(){
    jQuery("#btn_change_passwd").click(function(){

        var new_pass = jQuery("#new_passwd").val();
        var confirm_pass = jQuery("#confirm_passwd").val();

        jQuery.ajax({
            "url" : "change_user_passwd.php",
            "type" : "POST",
            "data" : {
                "new_pass" : new_pass,
                "confirm_pass" : confirm_pass,
            },
            "success" : function(response){
                alert(response);
                location.reload();
            }
        })
    })
});

// jQuery(document).ready(function(){
//     jQuery("#btn_add_member").click(function(){
        
//         var username = jQuery("#user_name").val();
//         var user_passwd = jQuery("#user_password").val();
//         var confirm_passwd = jQuery("#confirm_password").val();
//         var branch = jQuery("#user_branch").val();
//         var role = jQuery("#user_designation").val();

//         jQuery.ajax({
//             "url" : "add_new_company_member.php",
//             "type" : "POST",
//             "data" : {
//                 "username" : username,
//                 "user_passwd" : user_passwd,
//                 "confirm_passwd" : confirm_passwd,
//                 "branch" : branch,
//                 "role" : role,
//             },
//             "success" : function(response){
//                 alert(response);
//                 location.reload();
//             }
//         })
//     })
// });

jQuery(document).ready(function(){
    jQuery("#tbl_item_details").DataTable({
        "searching":true,
        "filter": true ,
        "processing": true,
        "serverSide": true,
        "bInfo": true,
        "ajax" : {
            "url" : "display_items.php",
            "type" : "POST",
        },
        "columns" : [
            { "data": "sno", sortable: true },
            { "data": "itemen", sortable: true },
            { "data": "itemgu", sortable: true },
            {
                "data": null,
                className: "dt-center editor-edit",
                sortable: false,
                render: function (data, type, row) {
                    return '<div><botton class="delete_icon" href="javascript:void(0);" id="deletebtn_' + data.sno + '" onClick="delete_item(' + data.sno + ')">Delete</button></div>';      
                }
            },
         
        ],
        "paging": true,
        "pageLength": 10,
        "select": true,
        "order": [
            [0, 'asc'],
        ],
        "bDestroy": true,
    });
});

//multi mobile number allocation
jQuery(document).ready(function(){
    jQuery("#branch_mobile").on('input' ,function(){
        this.value = this.value.replace(/[^0-9, ]/g, ''); 

        if(this.value.startsWith(","))
        {
            this.value = this.value.replace(/[^0-9]/g, ''); 
        }
    });
});

//validation for searching lr 
jQuery(document).ready(function(){
    jQuery("#search_by_lr").submit(function(event){
        var search = jQuery("#lr_number").val();
        var regex = /^[A-Za-z]+\s*-\s*[0-9]+$/;

        if(search !== "")
        {
            if (!regex.test(search)) {
                event.preventDefault();
                jQuery("#lr_error").css("display" , "block");
            } else {
                jQuery("#lr_error").css("display" , "none");
            }
        }
        
    });
});

jQuery(document).ready(function(){
    jQuery("#serial_number").on("input",function(){
        var sno = jQuery("#serial_number").val();
        var branch = jQuery("#userbranch").val();

        jQuery.ajax({
            "url" : "add_tracking_history.php",
            "type" : "POST",
            "data" : {
                "serial_number" : sno,
                "branch" : branch,
            },
            "success" : function(response){
                location.reload();
            }
        })
    });
});

jQuery(document).ready(function(){
    jQuery("#AdditionalItem").on("change" , ".field_type" ,function(){
        var id = jQuery(this).attr("id");
        var index = id.split("_");
        var option = jQuery("#type_"+index[1]).find(":selected").val();
        option = jQuery.trim(option);
        if(option == "Integer")
        {
            jQuery("#field_value_"+index[1]).attr("type","number");
            jQuery(".total_check_"+index[1]).prop("disabled",false).css("opacity","1");
        }
        else if(option == "Float")
        {
            jQuery("#field_value_"+index[1]).attr("type","float");
            jQuery(".total_check_"+index[1]).prop("disabled",false).css("opacity","1");
        }
        else
        {
            jQuery("#field_value_"+index[1]).attr("type","text");
            jQuery(".total_check_"+index[1]).prop("disabled",true).css("opacity","0.5");
        }
    });
});

function checkTime() {
    $.ajax({
        url: 'reset_gst_permission.php',
        method: 'GET',
    });
}

function startTimer() {
    var targetDate = new Date("2024-04-01T00:00:00");
    var now = new Date();
    var timeDifference = targetDate - now;

    if (timeDifference > 0) {
        setTimeout(function() {
            checkTime();
        }, timeDifference);
    } 
}

window.onload = startTimer;




