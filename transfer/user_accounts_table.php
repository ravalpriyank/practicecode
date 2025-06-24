<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- data table css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script scr="assets/js/custome.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div>
        <table class="table table-bordered" id="tbl_account_info">
            <thead>
                <th><?php echo !empty($language["Account_no"]) ? $language["Account_no"] : ""; ?></th>
                <th><?php echo !empty($language["Account_holders"]) ? $language["Account_holders"] : ""; ?></th>
                <th><?php echo !empty($language["Uaction"]) ? $language["Uaction"] : ""; ?></th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</body>
<!-- datatable js -->
<script type="text/javascript" charset="utf8"
    src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>

</html>