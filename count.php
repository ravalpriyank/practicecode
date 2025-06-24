<?php
    //letters count
    $str = "hello";
    $strcount = 0;

    while(isset($str[$strcount]))
    {
        $strcount++;
    }

    echo "total letters : ".$strcount."<br>";

    //digits count 
    $num = 120;
    $count = 0;

    while($num > 0)
    {
        $count++;
        $num = (int)($num / 10);
    }

    echo "total digits : ".$count;
?>