<?php 
    $num = 29;
    $flag = true;

    for($i=2;$i<25;$i++)
    {
        if($num % $i == 0)
        {
            $flag = false;
        }    
    }

    if($flag == false)
    {
        echo "$num is not prime";
    }
    else
    {
        echo "$num is prime";
    }
?>