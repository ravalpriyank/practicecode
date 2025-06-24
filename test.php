<?php 
   $num = 212;
   $old = $num;
   $sum = 0;
   $rev = 0;

   while($num > 0)
   {
      $lst = $num % 10;
      $sum = $sum + $lst;
      $rev = $rev * 10 + $lst;
      $num = (int)($num / 10);
   }

   if($rev === $old)
   {
      echo "palindrom";
   }
   else
   {
      echo "not palindrom";
   }
   
?>