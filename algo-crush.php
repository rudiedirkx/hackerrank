<?php

// https://www.hackerrank.com/challenges/crush
// 1000000 2
// 140906 999280 90378
// 651237 912072 87106

const NUM_SIZE = 12;
const BATCH_SIZE = 1e6;

header('Content-type: text/plain; charset=utf-8');

// $fp = fopen("php://stdin", "r");
$fp = fopen("algo-crush-01.txt", "r");

list($size, $num_operations) = fscanf($fp, '%i %i');
echo number_format($size, 0) . "\n";

// Create batches of 100k outside of memory
$num_batches = ceil($size / BATCH_SIZE);
$batches = [];
$str_num = str_repeat(' ', NUM_SIZE - 1) . '0';
for ($i=0; $i < $num_batches; $i++) {
    $bfp = tmpfile();
    $batches[] = $bfp;
    fwrite($bfp, str_repeat($str_num, BATCH_SIZE));
}

echo number_format(memory_get_peak_usage() / 1e6) . " MB\n";

// Fetch operations into memory
$operations = [];
for ($n = 0; $n < $num_operations; $n++) {
    list($from, $to, $add) = fscanf($fp, '%i %i %i');
    $operations[] = [$from, $to, $add];
}

echo number_format(count($operations), 0) . "\n";

echo number_format(memory_get_peak_usage() / 1e6) . " MB\n";

usort($operations, function($a, $b) {
    return $a[0] - $b[0];
});

echo number_format(memory_get_peak_usage() / 1e6) . " MB\n";

// Execute per batch
class Batcher {
    public $batches;
    public $current = -1;
    public $data;

    function __construct(array $batches) {
        $this->batches = $batches;
    }

    function update($i, $add) {
        $batch = floor($i / BATCH_SIZE);
        $pos = $i % BATCH_SIZE;

        $fp = $this->batches[$batch];

        fseek($fp, $pos);
        $int = (int) fgets($fp, NUM_SIZE);
        // var_dump($int);
        $int += $add;

        $int = str_pad($int, NUM_SIZE, '0', STR_PAD_LEFT);
        fseek($fp, $pos);
        fwrite($fp, $int, NUM_SIZE);
    }
}

$batcher = new Batcher($batches);

foreach ($operations as $o => list($from, $to, $add)) {
    echo "op $o\n";
    // $batcher->update($from-1, $add);
    for ($i = $from-1; $i < $to; $i++) {
        $batcher->update($i, $add);
    }
}

echo number_format(memory_get_peak_usage() / 1e6) . " MB\n";



return;



// $list = array_fill(0, $size, '0');
$list = [];

for ($n = 0; $n < $operations; $n++) {
    list($from, $to, $add) = fscanf($fp, '%i %i %i');
    $add = (int) $add;
    for ($i = $from-1; $i < $to; $i++) {
        if (!isset($list[$i])) {
            $list[$i] = 0;
        }
        $list[$i] += $add;
    }
}

// print_r($list);
echo max($list);
