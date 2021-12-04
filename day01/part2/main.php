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

$score = 0;
$previous = null;
$current = null;
for ($i = 3; $i < count($input); $i++) {
  $current = $input[$i][0] + $input[$i-1][0] + $input[$i-2][0];
  $previous = $input[$i-1][0] + $input[$i-2][0] + $input[$i-3][0];
  
  $score += ($current > $previous) ? 1 : 0;
  
}

printf("Final score is: %d\n", $score);