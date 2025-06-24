<?php
    for($i=0;$i<=4;$i++)
    {
        for($s=0;$s<4-$i;$s++)
        {
            echo "&nbsp;&nbsp;&nbsp;";
        }

        for($j=0;$j<=$i;$j++)
        {
            echo "* ";
        }

        echo "<br>";
    }

?>