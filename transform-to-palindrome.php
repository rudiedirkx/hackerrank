<?php

// https://www.hackerrank.com/contests/w33/challenges/transform-to-palindrome

header('Content-type: text/plain; charset=utf-8');

$handle = fopen("php://stdin", "r");
$handle = fopen("transform-to-palindrome-01.txt", "r");
$handle = fopen("transform-to-palindrome-02.txt", "r");
fscanf($handle,"%d %d %d", $n, $k, $m);

$_time = microtime(1);

$transformations = [];
for ($a0 = 0; $a0 < $k; $a0++) {
	fscanf($handle, "%d %d", $x, $y);
	$transformations[$x][$y] = true;
	$transformations[$y][$x] = true;
}

//print_r($transformations);

// echo number_format((microtime(1) - $_time) * 1000, 3) . "\n";
// $_time - microtime(1);

$a = explode(" ", fgets($handle));
$a = array_map(function($n) {
	return [(int) $n];
}, $a);

//print_r($a);

// echo number_format((microtime(1) - $_time) * 1000, 3) . "\n";
// $_time - microtime(1);

foreach ($a as &$ns) {
	$new_ns = $ns;
	while (count($new_ns) > 0) {
		$new_new_ns = [];
		foreach ($new_ns as $new_n) {
			foreach ($transformations[$new_n] as $next_n => $foo) {
				if (!in_array($next_n, $ns)) {
					$new_new_ns[] = $next_n;
					$ns[] = $next_n;
				}
			}
		}
		$new_ns = $new_new_ns;
	}

	sort($ns);
	$ns = implode(':', $ns);
	unset($ns);
}

// print_r($a);

// echo number_format((microtime(1) - $_time) * 1000, 3) . "\n";
// $_time - microtime(1);

$first = function($arr, $nth = 0) {
	return $arr[$nth];
};
$last = function($arr, $nth = 0) {
	return $arr[count($arr) - $nth - 1];
};

$length = 0;

$evalEnds = function() use ($first, $last, &$a, &$length) {
	if ($first($a) == $last($a)) {
		$a = array_slice($a, 1, -1);
		$length += 2;
		return count($a) > 0;
	}

	if (count($a) <= 2) {
		$length++;
		return false;
	}

	for ($i = 1; $i < 10; $i++) {
		if ($first($a, $i) == $last($a, 0)) {
			array_splice($a, 0, $i);
			return true;
		}
		elseif ($first($a, 0) == $last($a, $i)) {
			array_splice($a, -$i, $i);
			return true;
		}
	}

	return false;
};

while ($evalEnds()) {
	// echo "\n";

	// var_dump($length);
	// print_r($a);
}

// echo number_format((microtime(1) - $_time) * 1000, 3) . "\n";
// $_time - microtime(1);

// echo "\n";
echo $length;
