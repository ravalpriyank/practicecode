<?php
require_once("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial = !empty($_POST['serials']) ? $_POST['serials'] : "";
    $Serials = explode(',', $serial);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/dispatch.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container-flude">
        <table class="table table-bordered mt-3 text-center ">
            <thead class="receipt_table_head">
                <th scope="col">LR Number</th>
                <th scope="col">Qty</th>
                <th scope="col">Items</th>
                <th scope="col">Booking Office</th>
                <th scope="col">Place To Send</th>
                <th scope="col">Vehicle Number</th>
                <th scope="col">Dispatch Date</th>
                <th scope="col">Status</th>
            </thead>
            <tbody class="">
                <?php
                foreach ($Serials as $sno) {
                    $query = "SELECT * FROM `transportz` WHERE `sno` = '" . $sno . "'";
                    $run_query = mysqli_query($conn2, $query);
                    $raw = mysqli_fetch_assoc($run_query);

                    if (!empty($raw["ddate"])) {
                        $date_parts = explode('-', $raw["ddate"]);
                        if (count($date_parts) == 3) {
                            $final_dispatch = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
                        }
                    }

                    if ($raw["dstatus"] == "na") {
                        $raw["dstatus"] = "At Stock";
                    }
                    ?>
                    <tr scope="row" class="">
                        <td><?php echo !empty($raw["lrwithcode"]) ? $raw["lrwithcode"] : ""; ?></td>
                        <td><?php echo !empty($raw["qty"]) ? $raw["qty"] : ""; ?></td>
                        <td><?php echo !empty($raw["item"]) ? $raw["item"] : ""; ?></td>
                        <td><?php echo !empty($raw["branch"]) ? $raw["branch"] : ""; ?></td>
                        <td><?php echo !empty($raw["place"]) ? $raw["place"] : ""; ?></td>
                        <td><?php echo !empty($raw["vnumber"]) ? $raw["vnumber"] : ""; ?></td>
                        <td><?php echo !empty($final_dispatch) ? $final_dispatch : ""; ?></td>
                        <td><?php echo !empty($raw["dstatus"]) ? $raw["dstatus"] : ""; ?></td>
                    </tr>
                <?php }
                ; ?>
            </tbody>
        </table>

    </div>

</body>
<script>
    window.print();
    setTimeout(window.close, 500);
</script>

</html>