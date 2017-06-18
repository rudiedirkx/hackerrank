<?php

// https://www.hackerrank.com/challenges/stockmax

header('Content-type: text/plain; charset=utf-8');

$fp = fopen('php://stdin', 'r');
$fp = fopen('stockmax-01.txt', 'r');
list($t) = fscanf($fp, '%i');

$peaks = function(array $prices) {
	// $_time = microtime(1);

	$max_offset = count($prices) - 1;

	arsort($prices, SORT_NUMERIC);
	$peaks = [];
	$last_peak = -1;
	foreach ($prices as $day => $price) {
		if ($day > $last_peak) {
			$last_peak = $day;
			$peaks[$day] = $price;
		}
		if ($day == $max_offset) {
			break;
		}
	}

	// echo number_format((microtime(1) - $_time) * 1000, 3) . "\n";

	return $peaks;
};

while ($t--) {
	list($days) = fscanf($fp, '%i');
	$day_prices = array_map('intval', explode(' ', fgets($fp)));

	$peak_days = $peaks($day_prices);
	// var_dump(count($peak_days));
	// print_r($peak_days);

	$stock = $money = 0;
	foreach ($day_prices as $day => $price) {
		if ($day == $days-1 || isset($peak_days[$day])) {
			if ($stock) {
				// echo "$day. selling $stock stock\n";
				$money += $stock * $price;
				$stock = 0;
			}
			else {
				// echo "$day. not doing anything\n";
			}
		}
		else {
			// echo "$day. buying 1 stock\n";
			$stock++;
			$money -= $price;
		}
	}
	echo "$money\n";
	// exit;
}
