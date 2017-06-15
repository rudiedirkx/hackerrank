<?php

// https://www.hackerrank.com/challenges/bigger-is-greater

header('Content-type: text/plain; charset=utf-8');

// echo doWord('dkhc'); // works

echo doWord('ddkhc'); // wrong

function doWord($word) {
	$letters = $orig_letters = str_split(trim($word));
	$size = count($letters);

	for ($i = 2; $i < $size; $i++) {
		$letters = sortLastN($orig_letters, $i);
		if ($letters != $orig_letters) {
			return implode($letters);
		}
	}

	$letters = $orig_letters;
	$first = $letters[0];
	$next = array_reduce($letters, function($next, $letter) use ($first) {
		return $letter > $first ? ($next ? min($letter, $next) : $letter) : $next;
	}, '');
var_dump($next);
	if ($next) {
		unset($letters[array_search($next, $letters)]);
		sort($letters);
		return $next . implode($letters);
	}

	return 'no answer';
}

function sortLastN($letters, $last) {
	$start = count($letters) - $last;
	$pre = array_slice($letters, 0, $start);
	$suf = array_slice($letters, $start);
	rsort($suf);
	return array_merge($pre, $suf);
}
