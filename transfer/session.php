<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == "true") {
    unset($_SESSION['loggedin']);
    session_destroy();
    header("location: login.php");
    exit;
}

$usertableis = "gtmanager";
$expensetableis = "expense";
$salarytableis = "salary";
$usertableis = "users";
?>