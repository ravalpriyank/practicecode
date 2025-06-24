<?php 
    $userRole = "SuperAdmin";
    $reportRole = "SuperAdmin";

    $accessRolls1 = ["Office","CityAdmin","Admin","SuperAdmin","Developer"];
    $accessRolls2 = ["CityAdmin","Admin","SuperAdmin","Developer"];
    $accessRolls3 = ["Admin","SuperAdmin","Developer"];
    $accessRolls4 = ["SuperAdmin","Developer"];

    $office = "Hello i am office user";
    $city = "Hello i am city user";
    $admin = "Hello i am admin user";
    $super = "Hello i am super user";
    $developer = "Hello i am developer";

    if($reportRole == "Office" && in_array($userRole,$accessRolls1))
    {
        echo $developer."<br>";
        echo $super."<br>";
        echo $admin."<br>";
        echo $city."<br>";
        echo $office."<br>";
    }

    if($reportRole == "CityAdmin" && in_array($userRole,$accessRolls2))
    {
        echo $developer."<br>";
        echo $super."<br>";
        echo $admin."<br>";
        echo $city."<br>";
    }

    if($reportRole == "Admin" && in_array($userRole,$accessRolls3))
    {
        echo $developer."<br>";
        echo $super."<br>";
        echo $admin."<br>";
    }

    if($reportRole == "SuperAdmin" && in_array($userRole,$accessRolls4))
    {
        echo $developer."<br>";
        echo $super."<br>";
    }
?>