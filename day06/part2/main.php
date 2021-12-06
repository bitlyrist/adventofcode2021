<?php

function read_from_stdin(&$numbers) {
  $numbers = explode(',', fscanf(STDIN, "%s\n")[0]);
  return $numbers;
}


$fish_count = 0;
$fishes = array();
for ($i=0; $i < 9; $i++) {
  $fishes[$i] = 0;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
read_from_stdin($start);
foreach ($start as $i) {
  $fishes[intval($i)]++;
  $fish_count++;
}

$days = 256;
for ($i = 0; $i < $days; $i++) {
  $newfish = $fishes[0];
  for ($f = 1; $f < 9; $f++) {
    $fishes[$f-1] = $fishes[$f];
    $fishes[$f] = 0;
  }
  $fishes[8] = $newfish;
  $fishes[6] += $newfish;
  $fish_count += $newfish;
}
printf("Day %d: %s\n", ($i + 1), implode(',', $fishes));
printf("There are %d fish\n", $fish_count);



