<?php

function read_from_stdin(&$numbers) {
  $numbers = array();
  while( $line = fscanf(STDIN, "%s\n") ) {
    $strnums = str_split($line[0]);
    $intnums = array();
    for ( $i = 0; $i < count($strnums); $i++ ) {
      $intnums[$i] = intval($strnums[$i]);
    }
    $numbers[] = $intnums;
    unset($intnums);
  }
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
read_from_stdin($elevations);

$vents = array();
foreach ($elevations as $y=>$line) {
  foreach ($line as $x=>$elev) {
    if ( is_vent($elevations, $y, $x) == true ) {
      $vents[] = $elev + 1;
      printf("Found vent %d at [%d,%d]\n", $elev, $y, $x);
    }
  }
}


function is_vent($e, $y, $x) {
  $isvent = true;
  $isvent = ( !array_key_exists($y-1, $e) || $e[$y][$x] < $e[$y-1][$x] ) ? $isvent & true : $isvent & false;
  $isvent = ( !array_key_exists($y+1, $e) || $e[$y][$x] < $e[$y+1][$x] ) ? $isvent & true : $isvent & false;
  $isvent = ( !array_key_exists($x+1, $e[$y]) || $e[$y][$x] < $e[$y][$x+1] ) ? $isvent & true : $isvent & false;
  $isvent = ( !array_key_exists($x-1, $e[$y]) || $e[$y][$x] < $e[$y][$x-1] ) ? $isvent & true : $isvent & false;
  return $isvent;
}



printf("Sum of vents is: %d\n", array_sum($vents));
