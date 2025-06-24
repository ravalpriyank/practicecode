<?php 
    for($i=1;$i<=1000;$i++)
    {
        $prime = true;
        $armstrong = true;
        
        if($i==1)
        {
            $prime = false;
        }
        else
        {
            for($j=2;$j<$i;$j++)
            {
                if($i % $j == 0)
                {
                    $prime = false;
                }
            }
        }

        $org = $i;
        $Value = armValue($i);

        if($org != $Value)
        {
            $armstrong = false;
        }

        if($prime == true && $armstrong == true)
        {
            echo $i."<br>";
        }
    }

    

    function countNum($no)
    {
        $num = $no;
        $count = 0;

        while($num > 0)
        {
            $count++;
            $num = (int)($num / 10);
        }

        return $count;
    } 
    
    function armValue($value)
    {
        $no = $value;
        $total = countNum($no);
        $sum = 0;

        while($no>0)
        {
            $lst = $no % 10;

            $arm = 1;

            for($i=1;$i<=$total;$i++)
            {
                $arm = $arm * $lst;
            }

            $sum = $sum + $arm;
            $no = (int)($no / 10);
        }

        return $sum;
    }
?>