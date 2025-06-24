<?php
if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['ThisPrintMethod'] == "in") {
        if (isset($_POST['chrtbox'])) {
            require_once('general_chart.php');
        } else {
            require_once('printgeneralin.php');
        }
    } elseif ($_POST['ThisPrintMethod'] == "out") {
        if (isset($_POST['pointer'])) {
            require_once('general_outmix.php');
        } else {
            require_once('printgeneralout.php');
        }
    }
}
?>