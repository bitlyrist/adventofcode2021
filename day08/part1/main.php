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

foreach ($digits as $lidx => $line) {
  foreach ($line as $didx => $digit) {
    $len = strlen($digit);
    switch ($len) {
      case 2:
        $counts[2]++;
        break;
      case 3:
        $counts[7]++;
        break;
      case 4:
        $counts[4]++;
        break;
      case 7:
        $counts[8]++;
        break;
    }
  }
}


printf("Count of unique digits is: %d\n", array_sum($counts) );
