<?php

// https://www.hackerrank.com/challenges/bigger-is-greater

header('Content-type: text/plain; charset=utf-8');

// echo doWord('dkhc'); // works

echo doWord('ddkhc'); // makes 'dkdhc', but should make 'dhdkc'

function doWord(string $word) {
	$letters = $orig_letters = str_split(trim($word));
	$size = count($letters);

	for ($i = 2; $i <= $size; $i++) {
		$letters = sortLastN($orig_letters, $i);
		if ($letters) {
			return $letters;
		}
	}

	return 'no answer';
}

function sortLastN(array $letters, $last) {
	$start = count($letters) - $last;
	$suf = $suf0 = array_slice($letters, $start);
	sort($suf);
	if ($suf == $suf0) {
		return false;
	}

	$gt = $suf0[0];
	$bigger = array_filter($suf0, function($letter) use ($gt) {
		return $letter > $gt;
	});
	if (!$bigger) {
		return false;
	}
	$smallest = min($bigger);
	if ($smallest == $gt) {
		return false;
	}

	$i = array_search($smallest, $suf0);
	unset($suf0[$i]);
	array_unshift($suf0, $smallest);

	$pre = array_slice($letters, 0, $start);
	return implode($pre) . implode($suf0);
}
