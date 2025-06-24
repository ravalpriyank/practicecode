<?php 
    // pattern 1

    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=1;$j<=$i;$j++)
    //     {
    //         echo "*";
    //     }
    //     echo "<br>";
    // }

    //pattern 2
    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=5;$j>=$i;$j--)
    //     {
    //         echo "* ";
    //     }
    //     echo "<br>";
    // }

    //pattern 3
    // for($i=1;$i<=5;$i++)
    // {
    //     for($s=1;$s<=5-$i;$s++)
    //     {
    //         echo "S ";
    //     }

    //     for($j=1;$j<=$i;$j++)
    //     {
    //         echo "* ";
    //     }
    //     echo "<br>";
    // }

    //pattern 4
    // for($i=1;$i<=5;$i++)
    // {
    //     for($s=1;$s<$i;$s++)
    //     {
    //         echo "S ";
    //     }
        
    //     for($j=5;$j>=$i;$j--)
    //     {
    //         echo "* ";
    //     }
    //     echo "<br>";
    // }

    //pattern 5
    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=1;$j<=9;$j++)
    //     {
    //         if($j >= 6-$i && $j <= 4+$i)
    //         {
    //             echo "* ";
    //         }
    //         else
    //         {
    //             echo "&nbsp&nbsp&nbsp";
    //         }
    //     }
    //     echo "<br>";
    // }

    //pattern 6
    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=1;$j<=9;$j++)
    //     {
    //         if($j >= 6-$i && $j <= 4+$i)
    //         {
    //             if($i%2 == 0)
    //             {
    //                if($j%2==0)
    //                {
    //                     echo "* ";
    //                } 
    //                else
    //                {
    //                     echo "&nbsp&nbsp&nbsp";
    //                }
    //             }

    //             if($i%2==1)
    //             {
    //                 if($j%2==1)
    //                 {
    //                     echo "* ";
    //                 }
    //                 else
    //                 {
    //                     echo "&nbsp&nbsp&nbsp";
    //                 }
    //             }
                
    //         }
    //         else
    //         {
    //             echo "&nbsp&nbsp&nbsp";
    //         }
    //     }
    //     echo "<br>";
    // }

    //pattern 7 
    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=1;$j<=5;$j++)
    //     {
    //         if($i == 1 || $i == 5)
    //         {
    //             echo "* ";
    //         }
    //         else
    //         {
    //             if($j == 1 || $j == 5)
    //             {
    //                 echo "* ";
    //             }
    //             else
    //             {
    //                 echo "&nbsp&nbsp&nbsp";
    //             }
    //         }
    //     }
    //     echo "<br>";
    // }

    //pattern 8

    // for($k=1;$k<=5;$k++)
    // {
    //     for($l=1;$l<=9;$l++)
    //     {
    //         if($l >= 6-$k && $l <= 4+$k)
    //         {
    //             echo "* ";
    //         }
    //         else
    //         {
    //             echo "&nbsp&nbsp&nbsp";
    //         }
    //     }
    //     echo "<br>";
    // }
    
    // for($i=2;$i<=5;$i++)
    // {
    //     for($j=1;$j<=9;$j++)
    //     {
    //         if($j >= $i && $j <= 10-$i)
    //         {
    //             echo "* ";
    //         }   
    //         else
    //         {
    //             echo "&nbsp&nbsp&nbsp";
    //         }
    //     }
    //     echo "<br>";
    // }

    //pattern 10
    // $count=1;

    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=1;$j<=$i;$j++)
    //     {
    //         echo $count." ";
    //         $count++;
    //     }
    //     echo "<br>";
    // }

    //pattern 11
    // for($i=5;$i>=1;$i--)
    // {
    //     for($j=5;$j>=1;$j--)
    //     {
    //         echo $j." ";
    //     }
    //     echo "<br>";
    // }

    //pattern 12

    // for($i=1;$i<=5;$i++)
    // {
    //     $count=1;
    //     for($j=1;$j<=$i;$j++)
    //     {
    //         echo $count." ";
    //         $count++;
    //     }
    //     echo "<br>";
    // }

    //pattern 13
    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=$i;$j>=1;$j--)
    //     {
    //         echo $j." ";
    //     }
    //     echo "<br>";
    // }

    //pattern14
    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=1;$j<=$i;$j++)
    //     {
    //         if($i==1 || $i==5)
    //         {
    //             echo "* ";
    //         }
    //         else
    //         {
    //             if($j==1 || $j==$i)
    //             {
    //                 echo "* ";
    //             }
    //             else
    //             {
    //                 echo "&nbsp&nbsp&nbsp";
    //             }
    //         }
    //     }
    //     echo "<br>";
    // }

    //pattern 15
    // for($i=5;$i>=1;$i--)              
    // {
    //     for($s=1;$s<=5-$i;$s++)
    //     {
    //         echo "&nbsp&nbsp&nbsp";
    //     }

    //     for($j=1;$j<=$i;$j++)
    //     {
    //         echo "* ";
    //     }
    //     echo "<br>";
    // }

    //pattern 16
    // for($i=1;$i<=5;$i++)
    // {
    //     for($j=1;$j<=9;$j++)
    //     {
    //         if($j >= 6-$i && $j <= 4+$i)
    //         {
    //             if($i%2 == 0)
    //             {
    //                 if($j%2 == 0)
    //                 {
    //                     echo "$i";
    //                 }
    //                 else
    //                 {
    //                     echo "&nbsp&nbsp&nbsp&nbsp";
    //                 }
    //             }

    //             if($i%2 == 1)
    //             {
    //                 if($j%2 == 1)
    //                 {
    //                     echo "$i";
    //                 }
    //                 else
    //                 {
    //                     echo "&nbsp&nbsp&nbsp&nbsp";
    //                 }
    //             }
    //         }
    //         else
    //         {
    //             echo "&nbsp&nbsp&nbsp";
    //         }
    //     }
    //     echo "<br>";
    // }
<<<<<<< HEAD
=======

    print_r("hello world");
  
>>>>>>> a4f9cc34714732eac0934ebef75f955dbf9754fa
?>