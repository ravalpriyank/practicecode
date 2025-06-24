<?php
$array = [13,1,3,5,7,2,4,67,34,10];

$array_size = count($array);

for ($i = 0; $i < $array_size - 1; $i++) {
    for ($j = 0; $j < $array_size - 1; $j++) {
        if ($array[$j] > $array[$j + 1]) {
            $temp = $array[$j];
            $array[$j] = $array[$j + 1];
            $array[$j + 1] = $temp;
        }
    }
}

// Print the sorted array
echo "Sorted Array: ";
print_r($array);
?>
<?php
// $array = [13,1,3,5,7,2,4,67,34,10];

// $total = count($array);

// for($i=0;$i<$total;$i++)
// {
//     for($j=$i+1;$j<$total;$j++)
//     {
//         if($array[$i] > $array[$j])
//         {
//             $temp = $array[$i];
//             $array[$i] = $array[$j];
//             $array[$j] = $temp;
//         }
//     }
// }

// print_r($array);
?>
