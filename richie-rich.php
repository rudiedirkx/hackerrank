<?php

// https://www.hackerrank.com/challenges/richie-rich

$handle = fopen("richie-01.txt", "r");
// $handle = fopen("php://stdin", "r");

header('Content-type: text/plain; charset=utf-8');

function richieRich($str, $n, $changes){
	$len = strlen($str);
	$half = floor($len / 2);

	$arr = str_split($str);

	$maxp = count($arr) - 1;
	$changed = [];
	for ($p = 0; $p < $half; $p++) {
		$left = $arr[$p];
		$right = $arr[$maxp - $p];
		if ($left != $right) {
			if ($changes == 0) {
				return '-1';
			}

			$changes--;
			if ($left > $right) {
				$arr[$maxp - $p] = $left;
				$changed[] = $maxp - $p;
				// echo "equalize right $p\n";
			}
			elseif ($left < $right) {
				$arr[$p] = $right;
				$changed[] = $p;
				// echo "equalize left $p\n";
			}
		}
	}

	for ($p = 0; $p < $half; $p++) {
		if ($arr[$p] < 9) {
			$need = isset($changed[$p]) || isset($changed[$maxp - $p]) ? 1 : 2;
			if ($changes >= $need) {
				// echo "replace $p with 9\n";
				$arr[$p] = $arr[$maxp - $p] = 9;
				$changes -= $need;

				if ($changes == 0) {
					break;
				}
			}
		}
	}

	if ($changes > 0 && $len % 2 == 1) {
		// echo "replace middle with 9\n";
		$arr[$half] = '9';
	}

	return implode($arr);
}

fscanf($handle, "%i %i",$n, $k);
fscanf($handle, "%s",$s);
$result = richieRich($s, $n, $k);
echo $result . "\n";
