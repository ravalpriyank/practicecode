<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
   
    $com_code = !empty($_SESSION["company_code"]) ? $_SESSION["company_code"] : "";

    $servername="localhost";
    $username="root";
    $password="";
    $db="companies";

    $conn1=mysqli_connect($servername,$username,$password,$db);

    if($conn1 === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $query = "SELECT `database_name` FROM `parcel_companies` WHERE `company_code` = '$com_code'";
    $run_query = mysqli_query($conn1,$query);
    $login_data = mysqli_fetch_assoc($run_query);
    
    $current_db = !empty($login_data["database_name"]) ? $login_data["database_name"] : "";
   
    if(empty($current_db))
    {
       header("Location: auth-login.php?login=failed");
    }
    else
    {
        $servername="localhost";
        $username="root";
        $password="";
        $db=$current_db;

        $conn2=mysqli_connect($servername,$username,$password,$db);
        $_SESSION["current_db"] = $current_db;
    }
    
?>