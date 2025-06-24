<?php
    $arr = array();

    for($i=0;$i<5;$i++)
    {
        $arr[$i] = $i + 1;
    }

    for($i=0;$i<5;$i++)
    {
        echo $arr[$i]." ";
    }

    echo "<br>";
    
    for($i=4;$i>=0;$i--)
    {
        echo $arr[$i]." ";
    }
?>