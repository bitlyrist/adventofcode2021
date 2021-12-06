<?php

function read_from_stdin() {
  $numbers = explode(',', fscanf(STDIN, "%s\n")[0]);
  return $numbers;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$fishes = read_from_stdin();

$days = 80;
for ($i = 0; $i < $days; $i++) {
  $newfish = array();
  foreach ($fishes as $fi => $fish) {
    if ($fish == 0) {
      $newfish[] = 8;
      $fishes[$fi] = 7;
    } 
    $fishes[$fi]--;
  }
  $fishes = array_merge($fishes, $newfish);
  // printf("Day %d: %s\n", ($i + 1), implode(',', $fishes));  
}
printf("Day %d: %s\n", ($i + 1), implode(',', $fishes));
printf("There are %d fish\n", count($fishes));



