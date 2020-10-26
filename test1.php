<?php
$arr = [];
// $seed = 10;
// mt_srand( $seed );
// for($i = 0; $i < 1000000; $i++) {
//     $arr[] = mt_rand(10,100);
// }
$arr = UniqueRandomNumbersWithinRange(100, 1000000, 1000000000000);
// $arr = [1, 3, 6, 4, 1, 2];
// print_r($arr);
echo '<br>';
echo '<br>';
print_r(solution($arr));


function solution($A) {
    $A = array_unique($A);
    // asort($A);


    $start = microtime(TRUE);
    for($i=1; in_array($i,$A);$i++);
    $end = microtime(TRUE);
    echo '<br>';
    echo "The code took " . ($end - $start) . " seconds to complete.";
    echo '<br>';
    return $i;
}

function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

?>