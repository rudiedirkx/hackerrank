<?php

// https://www.hackerrank.com/challenges/crush
// 1000000 2
// 140906 999280 90378
// 651237 912072 87106

$fp = fopen("php://stdin", "r");
list($iNums, $iOps) = fscanf($fp, '%i %i');

$numbers = [];

echo number_format(memory_get_peak_usage() / 1e6) . " MB\n";

while (list($from, $to, $add) = fscanf($fp, '%f %f %f')) {
    if (!isset($numbers[$from-1])) {
        $numbers[$from-1] = 0.0;
    }
    if (!isset($numbers[$to])) {
        $numbers[$to] = 0.0;
    }
    $numbers[$from-1] += $add;
    $numbers[$to] -= $add;
}

echo number_format(memory_get_peak_usage() / 1e6) . " MB\n";

print_r($numbers);

echo max($numbers);
