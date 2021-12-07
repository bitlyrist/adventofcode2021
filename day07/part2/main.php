<?php

function read_from_stdin() {
  $numbers = explode(',', fscanf(STDIN, "%s\n")[0]);
  return $numbers;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$crabs = read_from_stdin();

$movediffs = array();
$min = min($crabs);
$max = max($crabs);
foreach ($crabs as $crabidx => $crab) {
  for ($i = $min; $i < $max; $i++) {
    $movediffs[$i][$crabidx] = (abs($crab - $i) * abs($crab - $i) + abs($crab - $i)) / 2;
  }
}

$minfuel = PHP_INT_MAX;
for ($i = $min; $i < $max; $i++) {
  $diff = array_sum($movediffs[$i]);
  $minfuel = ( $diff < $minfuel) ? $diff : $minfuel ;
}

printf("Minimum fuel usage is: %d\n", $minfuel);
