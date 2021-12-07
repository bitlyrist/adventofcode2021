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
    $diff = abs($crab - $i);
    $movediffs[$i][$crabidx] = ($diff * $diff + $diff) / 2;
  }
}

$movesums = array();
for ($i = $min; $i < $max; $i++) {
  $movesums[$i] = array_sum($movediffs[$i]);
}

printf("Minimum fuel usage is: %d\n", min($movesums));
