<?php
require_once("connection.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $new_passwd = !empty($_POST["new_pass"]) ? $_POST["new_pass"] : "";
    $confirm_passwd = !empty($_POST["confirm_pass"]) ? $_POST["confirm_pass"] : "";

    if ($new_passwd == $confirm_passwd) {
        $change_sql = "UPDATE `users` SET `password` = '$new_passwd' WHERE `username` = '" . $_SESSION["username"] . "'";
        $run_change_sql = mysqli_query($conn2, $change_sql);

        if ($run_change_sql) {
            echo "User Password Updated Successfully";
        } else {
            echo "Something Went Wrong";
        }
    } else {
        echo "Please Make Sure Both Passwords Are Same";
    }
}
?>