<?php 
$arr = [4,5,2];
$target = 6;
$result = array();

for($i=0;$i<3;$i++)
{
    for($j=0;$j<3;$j++)
    {
        if($arr[$i] + $arr[$j] == $target)
        {
           
            $result = [$i,$j];
            break 2;
        }
    }
}

print_r($result);
?>