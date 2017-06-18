<?php

// https://www.hackerrank.com/challenges/crush
// 1000000 2
// 140906 999280 90378
// 651237 912072 87106

header('Content-type: text/plain; charset=utf-8');

// $fp = fopen("php://stdin", "r");
$fp = fopen("algo-crush-01.txt", "r");
list($iNums, $iOps) = fscanf($fp, '%i %i');

$numbers = array_fill(0, $iNums, 0);

while (list($from, $to, $add) = fscanf($fp, '%i %i %i')) {
    for ($p = $from-1; $p < $to; $p++) {
        $numbers[$p] += $add;
    }
}

echo max($numbers);
