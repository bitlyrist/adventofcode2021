<?php

function read_from_stdin() {
  $numbers = explode(',', fscanf(STDIN, "%s\n")[0]);
  return $numbers;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$crabs = read_from_stdin();

sort($crabs);
$count_crabs = count($crabs);
$count_crabs = ($count_crabs % 2) == 0 ? $count_crabs - 1 : $count_crabs + 1;
$floor_crab = $crabs[floor($count_crabs / 2)];
$ceil_crab = $crabs[ceil($count_crabs / 2)];
$floor_sum = 0;
$ceil_sum = 0;
foreach ($crabs as $crab) {
  $floor_sum += abs($crab - $floor_crab);
  $ceil_sum += abs($crab - $ceil_crab);
}

printf("Minimum fuel usage is: %d\n", min($floor_sum, $ceil_sum) );
