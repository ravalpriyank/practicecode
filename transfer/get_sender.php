<?php
require_once("connection.php");
require_once("layouts/core/mainfunctions.php");

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = !empty($_POST["sender"]) ? $_POST["sender"] : "";

    $sender_data = getdirectsenderarray('transportz', 'nameone', $sender);

    if (is_array($sender_data)) {
        echo json_encode($sender_data);
    } else {
        echo json_encode([]);
    }
}
?>