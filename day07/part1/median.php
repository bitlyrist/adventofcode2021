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
$floor_median = floor($count_crabs / 2);
$ceil_median = ceil($count_crabs / 2);
$floor_sum = 0;
$ceil_sum = 0;
foreach ($crabs as $crab) {
  $floor_sum += abs($crab - $crabs[$floor_median]);
  $ceil_sum += abs($crab - $crabs[$ceil_median]);
}

printf("Minimum fuel usage is: %d\n", min($floor_sum, $ceil_sum) );
