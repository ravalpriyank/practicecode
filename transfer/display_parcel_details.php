<?php

if (isset($_GET) && isset($_GET["sendername"]) || isset($_GET["receivername"]) || isset($_GET["filter_date"])) {

    $sender = !empty($_GET["sendername"]) ? $_GET["sendername"] : "";
    $receiver = !empty($_GET["receivername"]) ? $_GET["receivername"] : "";
    $fdate = !empty($_GET["filter_date"]) ? $_GET["filter_date"] : "";

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<style>
    th {
        font-size: 16px !important;
    }
</style>

<body>
    <div class="main_content">
        <div class="parcel_detail table-responsive mt-4">
            <table class="table table-bordered tbl_parcel_detail w-100 " id="tbl_parcel_detail">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">
                            <?php echo !empty($language["Date2"]) ? $language["Date2"] : ""; ?></th>
                        <th width="10%" class="text-center">
                            <?php echo !empty($language["Rno"]) ? $language["Rno"] : ""; ?></th>
                        <th width="10%" class="text-center">
                            <?php echo !empty($language["sender2"]) ? $language["sender2"] : ""; ?></th>
                        <th width="10%" class="text-center" style="font-size:14px">
                            <?php echo !empty($language["reciver2"]) ? $language["reciver2"] : ""; ?></th>
                        <th width="10%" class="text-center">
                            <?php echo !empty($language["itemdetail"]) ? $language["itemdetail"] : ""; ?></th>
                        <th width="12%" class="text-center">
                            <?php echo !empty($language["qtyamount"]) ? $language["qtyamount"] : ""; ?></th>
                        <th width="10%" class="text-center">
                            <?php echo !empty($language["amount"]) ? $language["amount"] : ""; ?></th>
                        <th width="10%" class="text-center">
                            <?php echo !empty($language["payment"]) ? $language["payment"] : ""; ?></th>
                        <th width="10%" class="text-center" style="font-size:14px">
                            <?php echo !empty($language["placetosend"]) ? $language["placetosend"] : ""; ?></th>
                        <th width="10%" class="text-center" style="font-size:14px !important">
                            <?php echo !empty($language["Uaction"]) ? $language["Uaction"] : ""; ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align:right">Total :</td>
                        <td></td>
                        <td colspan="3" class="rate_total"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>



</body>

</html>