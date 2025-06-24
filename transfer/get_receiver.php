<?php
require_once("connection.php");
require_once("layouts/core/mainfunctions.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $receiver = !empty($_POST["receiver"]) ? $_POST["receiver"] : "";
    $receiver_data = getdirectreceiverarray('transportz', 'nametwo', $receiver);

    if (is_array($receiver_data)) {
        echo json_encode($receiver_data);
    } else {
        echo json_encode([]);
    }
}
?>