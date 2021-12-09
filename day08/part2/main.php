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

$sum = 0;
foreach ($sequence as $lidx => $line) {
  
  $digit_arrangement = array();
  while ( count($digit_arrangement) < 10) {
    foreach ($line as $digit) {
      $digit = str_split($digit);
      infer_code($digit_arrangement, $digit);
    }
  }

  $lookup = array();
  foreach ( $digit_arrangement as $num=>$da) {
    $lookup[ implode('', $da) ] = '' . $num;
  }
  
  $num_string = '';
  foreach ($digits[$lidx] as $didx => $digit) {
    $digit_arr = str_split($digit);
    sort($digit_arr);
    $digit_str = implode('', $digit_arr);
    $num_string .= $lookup[$digit_str];
  }

  unset($digit_arrangement);
  unset($lookup);

  $sum += intval($num_string);

}


printf("Total sum is: %d\n", $sum );


function add_code(&$arrangement, $index, $digits) {
  sort($digits);
  $arrangement[$index] = $digits;
}

function infer_code(&$arrangement, $digit) {
  $digit_str = implode('', $digit);
  $digit_len = strlen($digit_str);
  switch ($digit_len) {
    case 2:
      add_code($arrangement, 1, $digit);
      break;
    case 3:
      add_code($arrangement, 7, $digit);
      break;
    case 4:
      add_code($arrangement, 4, $digit);
      break;
    case 7:
      add_code($arrangement, 8, $digit);
      break;
    case 6:
      if ( array_key_exists(4, $arrangement) && difference($arrangement[4], $digit) == 0) {
        add_code($arrangement, 9, $digit);
      } else if ( array_key_exists(1, $arrangement) && difference($arrangement[1], $digit) == 0 ) {
        add_code($arrangement, 0, $digit);
      } else if ( array_key_exists(1, $arrangement) && difference($arrangement[1], $digit) == 1 ) {
        add_code($arrangement, 6, $digit);
      }
      break;
    case 5:
      if ( array_key_exists(1, $arrangement) && difference($arrangement[1], $digit) == 0) {
        add_code($arrangement, 3, $digit);
      } else if ( array_key_exists(4, $arrangement) && difference($arrangement[4], $digit) == 1 ) {
        add_code($arrangement, 5, $digit);
      } else if ( array_key_exists(4, $arrangement) && difference($arrangement[4], $digit) == 2 ) {
        add_code($arrangement, 2, $digit);
      }
      break;
  }
}

function difference ($a1, $a2) {
  $diff = array_diff($a1, $a2);
  $diff_length = count($diff);
  return $diff_length;
}