<?php

// https://www.hackerrank.com/challenges/non-divisible-subset

$source = @$_SERVER['argv'][1] ?: 'php://stdin';
$fp = fopen($source, 'r');

$meta = array_map('intval', explode(' ', fgets($fp)));
$numbers = array_map('intval', explode(' ', fgets($fp)));
sort($numbers);
list(, $k) = $meta;

header('Content-type: text/plain; charset=utf-8');

$mods = array_combine($numbers, array_map(function($number) use ($k) {
  return $number % $k;
}, $numbers));

print_r($mods);

$combos = [];
foreach ($mods as $number1 => $mod1) {
  foreach ($mods as $number2 => $mod2) {
    if ($mod1 + $mod2 == $k && !in_array("$number2:$number1", $combos)) {
      $combos[] = "$number1:$number2";
    }
  }
}

print_r($combos);
