<?php

function read_from_stdin(&$sequence, &$digits) {
  
  $sequence = array();
  $digits = array();
  while (($line = fgets(STDIN)) !== false) {
    $numbers = explode('|', rtrim($line));
    $sequence[] = explode(' ', trim($numbers[0]));
    $digits[] = explode(' ', trim($numbers[1]));
  }
  
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
read_from_stdin($sequence, $digits);

$counts = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$sum = 0;
foreach ($sequence as $lidx => $line) {
  $digit_arrangement = array();
  foreach ($line as $didx => $digit) {
    $len = strlen($digit);
    switch ($len) {
      case 2:
        $counts[1]++;
        add_code($digit_arrangement, 1, $digit);
        break;
      case 3:
        $counts[7]++;
        add_code($digit_arrangement, 7, $digit);
        break;
      case 4:
        $counts[4]++;
        add_code($digit_arrangement, 4, $digit);
        break;
      case 7:
        $counts[8]++;
        add_code($digit_arrangement, 8, $digit);
        break;
    }
  }

  while ( count($digit_arrangement) < 10) {
    foreach ($line as $didx => $digit) {
      infer_code($digit_arrangement, $digit);
    }
  }

  $lookup = array();
  foreach ( $digit_arrangement as $num=>$da) {
    sort($da);
    $key = implode('', $da);
    $lookup[$key] = '' . $num;
  }
  
  $num_string = '';
  foreach ($digits[$lidx] as $didx => $digit) {
    $digit_array = str_split($digit);
    sort($digit_array);
    $digit_str = implode('', $digit_array);
    $num_string .= $lookup[$digit_str];
  }

  unset($digit_arrangement);
  unset($lookup);

  $sum += intval($num_string);

}


printf("Total sum is: %d\n", $sum );


function add_code(&$arrangement, $index, $digits) {
  $darr = str_split($digits);
  sort($darr);
  $arrangement[$index] = $darr;
}

function infer_code(&$arrangement, $digit) {
  $digit_array = str_split($digit);
  sort($digit_array);
  $digit_len = strlen($digit);
  $digit_arr = str_split($digit);
  switch ($digit_len) {
    case 6:
      if ( difference($arrangement[4], $digit_arr) == 0) {
        $arrangement[9] = $digit_array;
      } else if ( difference($arrangement[1], $digit_arr) == 0 ) {
        $arrangement[0] = $digit_array;
      } else if ( difference($arrangement[1], $digit_arr) == 1 ) {
        $arrangement[6] = $digit_array;
      }
      break;
    case 5:
      if ( difference($arrangement[1], $digit_arr) == 0) {
        $arrangement[3] = $digit_array;
      } else if ( difference($arrangement[4], $digit_arr) == 1 ) {
        $arrangement[5] = $digit_array;
      } else if ( difference($arrangement[4], $digit_arr) == 2 ) {
        $arrangement[2] = $digit_array;
      } 
  }
}

function difference ($a1, $a2) {
  $diff = array_diff($a1, $a2);
  $diff_length = count($diff);
  return $diff_length;
}