<?php

function read_from_stdin() {
  $lines = array();
  while( $line = fscanf(STDIN, "%s\n") ) {
    $number = 0;
    for ( $i = strlen($line[0]) - 1; $i >= 0; $i-- ) {
      $number += (substr($line[0], strlen($line[0]) - 1 - $i, 1)) == '1' ? pow(2, $i) : 0;
    }
    $lines[] = array(
      '0' => $line[0],
      '1' => $number
    );
  }
  return $lines;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$input = read_from_stdin();

// print_r($input); exit;

$gamma = 0;
$epsilon = 0;

$one_count = 0;
$zero_count = 0;

for ( $i = strlen($input[0][0]) - 1; $i >= 0; $i-- ) {

  $digit = pow(2, $i);

  foreach ($input as $line)  {
    $one_count += ($line[1] & $digit) == $digit ? 1 : 0;
    $zero_count += ($line[1] & $digit) == 0 ? 1 : 0;
  }
  
  $gamma += ($one_count > $zero_count) ? $digit : 0 ;
  $epsilon += ($one_count < $zero_count) ? $digit : 0 ;
  $one_count = 0;
  $zero_count = 0;
}


printf("Final score is gamma: %d, epsilon: %d\n", $gamma, $epsilon);
printf("Final result is %d\n", $gamma * $epsilon);