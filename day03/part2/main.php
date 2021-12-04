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

$greatest_function = "get_greatest_digit";
$least_function = "get_least_digit";

$o2_rating = find_rating($input, $greatest_function);
$co2_rating = find_rating($input, $least_function);

printf("Final score is o2: %d, co2: %d\n", $o2_rating, $co2_rating);
printf("Final result is %d\n", $o2_rating * $co2_rating);



function get_greatest_digit($offset, $input){
  $one_count = 0;
  $zero_count = 0;
  foreach ($input as $line)  {
    $one_count += ($line[1] & $offset) == $offset ? 1 : 0;
    $zero_count += ($line[1] & $offset) == 0 ? 1 : 0;
  }
  return (($one_count >= $zero_count) ? 1 : 0);
}

function get_least_digit($offset, $input){
  $one_count = 0;
  $zero_count = 0;
  foreach ($input as $line)  {
    $one_count += ($line[1] & $offset) == $offset ? 1 : 0;
    $zero_count += ($line[1] & $offset) == 0 ? 1 : 0;
  }
  return (($one_count < $zero_count) ? 1 : 0);
}


function find_rating($input, $digit_function) {

  $keep_list = $input;
  for ( $i = strlen($input[0][0]) - 1; $i >= 0; $i-- ) {

    $digit = pow(2, $i);
  
    $keep_digit = $digit_function($digit, $keep_list);
    $keep_place = ($keep_digit == 1) ? pow(2, $i) : 0;
    
    $new_list = $keep_list;
    foreach ($keep_list as $index=>$line) {
      if ( ($line[1] & $digit) ^ $keep_place ) {
        unset($new_list[$index]);
      }
    }
  
    $keep_list = $new_list;
    if (count($keep_list) == 1) {
      $keep_list = array_values($keep_list);
      return $keep_list[0][1];
    }

  }

}