<?php

function read_from_stdin() {
  $lines = array();
  while( $line = fscanf(STDIN, "%d\n") ) { 
    $lines[] = $line; 
  }
  return $lines;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$input = read_from_stdin();

$score = null;
$previous = null;
foreach ($input as $i)  {
  if ($previous === null) {
    $previous = $i[0];
    $score = 0;
    continue;
  }

  $score += ($i[0] > $previous) ? 1 : 0;
  $previous = $i[0]; 

}

printf("Final score is: %d\n", $score);