<?php
function cleanbranch($string)
{
    return preg_replace('/[A-Z]-+/', "", $string);
}

function getbranch($string)
{
    global $conn2;
    $query = "SELECT `name` FROM `branchlog` WHERE `code` = '$string'";
    $run_query = mysqli_query($conn2, $query);

    $data = mysqli_fetch_assoc($run_query);

    return $data["name"];

}

function CleanBranchCode($string)
{
    global $conn2;
    $query = "SELECT `name` FROM `branchlog` WHERE `branchwithcode` = '$string'";
    $run_query = mysqli_query($conn2, $query);

    $data = mysqli_fetch_assoc($run_query);

    if (isset($data["name"]) && !empty($data["name"])) {
        return $data["name"];
    }
}

function getCity($city, $conn2)
{
    $sql1 = "SELECT `city` FROM `branchlog` WHERE `name`= '$city' OR `branchwithcode` = '$city'";
    $run_sql1 = mysqli_query($conn2, $sql1);
    $actual_city = mysqli_fetch_assoc($run_sql1);

    return $actual_city["city"];
}

function filterByBranch($data, $branch)
{
    return array_filter($data, function ($item) use ($branch) {
        return $item['branch'] === $branch;
    });
}

function getBranchList($string, $conn2)
{
    $query = "SELECT * FROM `branchlog` WHERE `city` = '$string'";
    $run_query = mysqli_query($conn2, $query);
    $banch_list = array();

    if (mysqli_num_rows($run_query) > 0) {
        while ($row = mysqli_fetch_assoc($run_query)) {
            $banch_list[] = $row["name"];
        }
    }

    return $banch_list;

}

function geturlrole($string)
{
    global $conn2;
    $query = "SELECT `roll` FROM `users` WHERE `username` = '$string'";
    $run_query = mysqli_query($conn2, $query);
    $user_role = mysqli_fetch_assoc($run_query);

    return $user_role["roll"];
}

function getsimplearray($tablename, $tablecol)
{
    global $conn2;
    $databasenamequery = mysqli_query($conn2, "SELECT * FROM `$tablename`");
    $mainoutput[] = null;
    while ($row = mysqli_fetch_array($databasenamequery)) {
        $mainoutput[] = $row["$tablecol"];
    }
    return $mainoutput;
}
// Get any Table by Just Table Name 
function gettable($tablename)
{
    global $conn2;
    $tableis = "SELECT * FROM `$tablename`";
    $table = mysqli_query($conn2, $tableis);
    return $table;
}
// Get Table by Tablename, Specified collumn and collumn values 
function getspecifiedtable($tablename, $colname, $value)
{
    global $conn2;
    $tableis = "SELECT * FROM `$tablename` where $colname = '$value'";
    $table = mysqli_query($conn2, $tableis);
    return $table;
}
// get array with repeated and null values 
function simplifyarray($arratnametopart)
{
    $newarray = [];
    foreach ($arratnametopart as $part) {
        if (in_array($part, $newarray)) {
            continue;
        } else {
            $newarray[] = $part;
        }
    }
    $finearray = array_values(array_filter($newarray));
    return $finearray;
}

// GET array without null and repeated values 
function getdirectsenderarray($tablename, $tablecol, $search)
{
    global $conn2;
    $databasenamequery = mysqli_query($conn2, "SELECT * FROM `$tablename` WHERE `nameone` LIKE '$search%'");
    $mainoutput1[] = null;
    $mainoutput2[] = null;
    while ($row = mysqli_fetch_array($databasenamequery)) {
        $tempvar = $row["$tablecol"];
        $conditiont = strpos($tempvar, ',');
        if ($conditiont !== false) {
            $mainoutput2 = explode(',', $tempvar);
        } else {
            $mainoutput1[] = $row["$tablecol"];
        }
    }
    $mainoutput = array_merge($mainoutput1, $mainoutput2);

    $newarray = [];
    foreach ($mainoutput as $part) {
        if (in_array($part, $newarray)) {
            continue;
        } else {
            $newarray[] = $part;
        }
    }
    $finearray = array_values(array_filter($newarray));
    return $finearray;
}

function getdirectreceiverarray($tablename, $tablecol, $search)
{
    global $conn2;
    $databasenamequery = mysqli_query($conn2, "SELECT * FROM `$tablename` WHERE `nametwo` LIKE '$search%'");
    $mainoutput1[] = null;
    $mainoutput2[] = null;
    while ($row = mysqli_fetch_array($databasenamequery)) {
        $tempvar = $row["$tablecol"];
        $conditiont = strpos($tempvar, ',');
        if ($conditiont !== false) {
            $mainoutput2 = explode(',', $tempvar);
        } else {
            $mainoutput1[] = $row["$tablecol"];
        }
    }
    $mainoutput = array_merge($mainoutput1, $mainoutput2);

    $newarray = [];
    foreach ($mainoutput as $part) {
        if (in_array($part, $newarray)) {
            continue;
        } else {
            $newarray[] = $part;
        }
    }
    $finearray = array_values(array_filter($newarray));
    return $finearray;
}

function getdirectarray($tablename, $tablecol)
{
    global $conn2;
    $databasenamequery = mysqli_query($conn2, "SELECT * FROM `$tablename`");
    $mainoutput1[] = null;
    $mainoutput2[] = null;
    while ($row = mysqli_fetch_array($databasenamequery)) {
        $tempvar = $row["$tablecol"];
        $conditiont = strpos($tempvar, ',');
        if ($conditiont !== false) {
            $mainoutput2 = explode(',', $tempvar);
        } else {
            $mainoutput1[] = $row["$tablecol"];
        }
    }
    $mainoutput = array_merge($mainoutput1, $mainoutput2);

    $newarray = [];
    foreach ($mainoutput as $part) {
        if (in_array($part, $newarray)) {
            continue;
        } else {
            $newarray[] = $part;
        }
    }
    $finearray = array_values(array_filter($newarray));
    return $finearray;
}

function getdirectshortarray($tablename, $tablecol)
{
    global $conn2;
    $databasenamequery = mysqli_query($conn2, "SELECT * FROM `$tablename`");
    $mainoutput[] = null;
    while ($row = mysqli_fetch_array($databasenamequery)) {
        $mainoutput[] = $row["$tablecol"];
    }

    $newarray = [];
    foreach ($mainoutput as $part) {
        if (in_array($part, $newarray)) {
            continue;
        } else {
            $newarray[] = $part;
        }
    }
    $finearray = array_values(array_filter($newarray));
    return $finearray;
}

function getarraywithstring($tablename, $tablecol, $checkvar, $storevar)
{
    global $conn2;
    $databasenamequery = mysqli_query($conn2, "SELECT * FROM `$tablename`");
    $mainoutput[] = null;
    while ($row = mysqli_fetch_array($databasenamequery)) {
        if ($row["$tablecol"] == $checkvar) {
            $mainoutput[] = $row["$storevar"];
        }
    }

    $newarray = [];
    foreach ($mainoutput as $part) {
        if (in_array($part, $newarray)) {
            continue;
        } else {
            $newarray[] = $part;
        }
    }
    $finearray = array_values(array_filter($newarray));
    return $finearray;
}

function convertstringtotable($stringvar)
{
    $arrayvar = explode(',', $stringvar);
    $printedvar = null;
    foreach ($arrayvar as $part) {
        $printedvar .= $part;
        $printedvar .= "</br>";
    }
    return $printedvar;
}
