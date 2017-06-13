<?php

// https://www.hackerrank.com/challenges/tbsp?h_r=next-challenge&h_v=zen

$source = @$_GET['input'] ?: @$_SERVER['argv'][1] ?: 'php://stdin';
$static_blimps = @$_GET['blimps'] ?: @$_SERVER['argv'][2] ?: 2;

$input = file_get_contents($source);
$lines = preg_split('#(\r\n|\r|\n)#', trim($input));

header('Content-type: text/plain; charset=utf-8');

$meta = array_combine(['cities', 'costs', 'decline'], array_map('floatval', explode(' ', array_shift($lines))));

class Coord {
  public $x;
  public $y;

  function __construct(int $x, int $y) {
    $this->x = $x;
    $this->y = $y;
  }

  function getDistanceTo(Coord $destination) {
    return sqrt(abs($destination->x - $this->x) + abs($destination->y - $this->y));
  }
}

class City {
  public $location;
  public $price;
  public $visited = false;

  function __construct(Coord $location, float $price) {
    $this->location = $location;
    $this->price = $price;
  }
}

class World {
  public $log = true;

  public $home;
  public $location;
  public $cities;

  public $blimps = 0;
  public $num_visited = 0;
  public $profits = [];
  public $travel_costs = [];

  public $output = [];

  function __construct(array $meta, array $cities) {
    $this->meta = $meta;
    $this->location = $this->home = new Coord(0, 0);
    $this->cities = $cities;
  }

  public function log($message) {
    if ($this->log) {
      echo "{$message}\n";
    }
  }

  public function output(Coord $location, $blimps = 0) {
    $this->output[] = "{$location->x} {$location->y}" . ( $blimps ? " {$blimps}" : '' );
  }

  function getClosestUnvisitedCity() {
    $min = 0;
    $closest = null;
    foreach ($this->cities as $city) {
      if (!$city->visited) {
        $distance = $city->location->getDistanceTo($this->location);
        if ($min == 0 || $distance < $min) {
          $closest = $city;
          $min = $distance;
        }
      }
    }

    return $closest;
  }

  function getCity() {
    foreach ($this->cities as $city) {
      if ($this->location == $city->location) {
        return $city;
      }
    }
  }

  function getTravelCostsTo(Coord $destination) {
    return round($this->location->getDistanceTo($destination) * (1 + $this->meta['costs'] * $this->blimps), 1);
  }

  function visitCity(City $city) {
    $from_home = $this->location == $this->home;

    $travel_costs = $this->getTravelCostsTo($city->location);
    $this->log("visiting city {$city->location->x}:{$city->location->y} (-{$travel_costs})");
    $city->visited = true;
    $this->num_visited++;
    $this->travel_costs[] = $travel_costs;
    $this->location = $city->location;

    $this->output($city->location, $from_home ? $this->blimps : 0);
  }

  function goHome() {
    $travel_costs = $this->getTravelCostsTo($this->home);
    $this->log("returning home with {$this->blimps} blimps (-{$travel_costs})");
    $this->travel_costs[] = $travel_costs;
    $this->location = $this->home;

    $this->output($this->home);
  }

  function pickUpBlimps($num) {
    if ($this->location != $this->home) {
      $this->goHome();
    }
    $this->log("picking up {$num} blimps at home");
    $this->blimps += $num;
  }

  function getDecline() {
    $visited = (count($this->num_visited) - 1) / count($this->cities);
    $declines = floor($visited * 10);
    return $declines ? pow($this->meta['decline'], $declines) : 1;
  }

  function getBlimpPrice(City $city) {
    $decline = $this->getDecline();
    return round($decline * $city->price, 1);
  }

  function sellBlimp() {
    $city = $this->getCity();
    $profits = $this->getBlimpPrice($city);
    $this->log("selling blimp (+{$profits})");
    $this->profits[] = $profits;
    $this->blimps--;
  }
}

$cities = [];
foreach ($lines as $line) {
  list($x, $y, $price) = explode(' ', $line);
  $cities[] = new City(new Coord((int) $x, (int) $y), (float) $price);
}

$world = new World($meta, $cities);
$world->log = false;

$static_blimps = array_fill(0, count($cities), $static_blimps);
for ($i = 0; $i < count($cities); $i++) {

// $_time = microtime(1);

  if ($world->blimps == 0) {
    // @todo When to pick up blimps?
    $world->pickUpBlimps(array_shift($static_blimps));
  }

  // @todo Which city to visit next?
  $city = $world->getClosestUnvisitedCity();

// echo "closest city: " . number_format((microtime(1) - $_time) * 1000, 3) . "\n";
// $_time = microtime(1);

  $world->visitCity($city);

  $world->sellBlimp();

  // echo "$i\n";
  // if ($i > 0 && $i % 5 == 0) exit;
}

// echo "\n";

$travel_costs = array_sum($world->travel_costs);
$profits = array_sum($world->profits);
// var_dump($profits, $travel_costs);
// var_dump($profits - $travel_costs);
// echo "\n";

// print_r($world);
// echo "\n";

echo implode("\n", $world->output);

// echo "\n";
// var_dump($profits - $travel_costs);
