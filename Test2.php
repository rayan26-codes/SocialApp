<?php
$num = [9, 1, 6, 5, 8, 3];

$temp = "";

for ($i=0; $i < count($num); $i++) { 
    for ($j= $i + 1; $j < count($num); $j++) { 
        if ($num[$i] > $num[$j]) {
            $temp = $num[$i];
            $num[$i] = $num[$j];
            $num[$j] = $temp;
        }
    }
}

print_r($num);
?>