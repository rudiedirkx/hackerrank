<?php

// https://www.hackerrank.com/challenges/even-tree

$fp = fopen("php://stdin", "r");
list($num_nodes, $num_edges) = fscanf($fp, '%i %i');

// Map edges
$edges = [];
while (list($to, $from) = fscanf($fp, '%i %i')) {
    $edges[$to][] = $from;
    $edges[$from][] = $to;
}

// Map branches
$addBranches = function(array &$tree, int $source, int $parent = 0) use (&$addBranches, $edges) {
    foreach ($edges[$source] as $node) {
        if ($node != $parent) {
            $tree['down'][$source][] = $node;
            $tree['up'][$node] = $source;
            $addBranches($tree, $node, $source);
        }
    }
};

$tree = ['down' => [], 'up' => [], 'size' => [/*array_fill(1, $num_nodes, 1)*/]];
$addBranches($tree, 1);

$ends = array_diff(range(1, $num_nodes), array_keys($tree['down']));
print_r($ends);

$branchSize = function(array &$tree, int $leaf0) {
    $size = function($leaf) use (&$size, $tree, $leaf0) {
        if (!isset($tree['size'][$leaf])) {
            $num = 1;
            foreach ((array) @$tree['down'][$leaf] as $child) {
                $num += $size($child);
            }
            $tree['size'][$leaf] = $num;
        }
        return $tree['size'][$leaf];
    };
    $tree['size'][$leaf0] = $size($leaf0);
};
for ($leaf = $num_nodes; $leaf >= 1; $leaf--) {
    $branchSize($tree, $leaf);
}

// print_r($tree);

// Remove branches

