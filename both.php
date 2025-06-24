<?php 
    function checkBoth($num)
    {
        $no = $num;
        $rev = 0;
        $org = $no;

        $prime = true;
        $palindrom = false;

        while($no > 0)
        {
            $lst = $no % 10;
            $rev = $rev * 10 + $lst;
            $no = (int)($no / 10);
        }

        if($org == $rev)
        {
            $palindrom = true;
        }

        for($i=2;$i<$org;$i++)
        {
            if($org % $i == 0)
            {
                $prime = false;
            }
        }

        if($palindrom == true && $prime == false)
        {
            echo "$org is palindrom but not prime";
        }
        elseif($palindrom == false && $prime == true)
        {
            echo "$org is not palindrom but prime";
        }
        else
        {
            echo "$org is palindrom and prime";
        }
    }

    checkBoth(4);
?>