<?php 
    $num = 10;

    for($i=1;$i<=$num;$i++)
    {
        if($i == 1)
        {
            $prime = false;
        }
        else
        {   
            $prime = true;

            for($j=2;$j<$i;$j++)
            {
                if($i % $j == 0)
                {
                    $prime = false;
                }
            }

            if($prime == true)
            {
                echo $i."<br>";
            }
        }
        
    }
?>