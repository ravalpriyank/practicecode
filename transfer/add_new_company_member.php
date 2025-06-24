<?php
require_once("connection.php");

$date = date("d-m-Y");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    $username = !empty($_POST["username"]) ? $_POST["username"] : "";
    $password = !empty($_POST["user_passwd"]) ? $_POST["user_passwd"] : "";
    $confirm_password = !empty($_POST["confirm_passwd"]) ? $_POST["confirm_passwd"] : "";
    $branch = !empty($_POST["branch"]) ? $_POST["branch"] : "";
    $role = !empty($_POST["role"]) ? $_POST["role"] : "";

    if ($password == $confirm_password) {
        $insert_sql = "INSERT INTO users(`username`,`password`,`branch`,`roll`,`user_profile`,`date`)VALUES('$username','$password','$branch','$role','assets/images/avatar-1.jpg',CURRENT_TIMESTAMP())";
        $run_insert_sql = mysqli_query($conn2, $insert_sql);

        if ($run_insert_sql) {
            echo "User Created Successfully";
        } else {
            echo "Something Went Wrong";
        }
    } else {
        echo "Makre Sure That Both Passwords Should Be Same";
    }
}
?>