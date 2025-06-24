<?php
    $str = "coding";
    $count = 0;

    while(isset($str[$count]))
    {
        $count++;
    }

    $newStr = "";

    for($i=$count-1;$i>=0;$i--)
    {
        $newStr = $newStr.$str[$i];
    }    
    
    echo $newStr;
?>