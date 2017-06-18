<?php

// https://www.hackerrank.com/challenges/even-tree

$fp = fopen("php://stdin", "r");
list($iNodes, $iEdges) = fscanf($fp, '%i %i');

class Node {
	public $name;
	public $parent;
	public $children = [];
	function __construct($name) {
		$this->name = $name;
	}
	function nAbove() {
		$n = 0;
		$node = $this;
		while ($node->parent) {
			$n++;
			$node = $node->parent;
		}
		return $n;
	}
	function nBelow() {
		$run = function($node) use (&$run) {
			$num = count($node->children);
			foreach ($node->children as $child) {
				$run($child);
			}
			return $num;
		};
		return $run($this);
	}
}

$nodes = range(1, $iNodes);
$nodes = array_map(function($name) {
	return new Node($name);
}, array_combine($nodes, $nodes));

while (list($to, $from) = fscanf($fp, '%i %i')) {
	$nodes[$from]->children[$to] = $nodes[$to];
	$nodes[$to]->parent = $nodes[$from];
}
