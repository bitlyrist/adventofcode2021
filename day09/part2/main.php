<?php

function read_from_stdin(&$numbers, &$counted) {
  $numbers = array();
  $counted = array();
  while( $line = fscanf(STDIN, "%s\n") ) {
    $strnums = str_split($line[0]);
    $intnums = array();
    $cnums = array();
    for ( $i = 0; $i < count($strnums); $i++ ) {
      $intnums[$i] = intval($strnums[$i]);
      $cnums[$i] = false;
    }
    $numbers[] = $intnums;
    $counted[] = $cnums;
    unset($intnums);
  }
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
read_from_stdin($elevations, $counted);

$vents = array();
foreach ($elevations as $y=>$line) {
  foreach ($line as $x=>$elev) {
    if ( is_vent($elevations, $y, $x) == true ) {
      $vents[] = array('y' => $y, 'x' => $x);
    }
  }
}

$basins = array();
foreach ( $vents as $vent) {
  $basin = basin($elevations, $vent['y'], $vent['x'], $counted);
  $basins[] = $basin;
}

rsort($basins);
$product = $basins[0] * $basins[1] * $basins[2];
printf("Product of largest basins is: %d\n", $product);


function is_vent($e, $y, $x) {
  $isvent = true;
  $isvent = ( !array_key_exists($y-1, $e) || $e[$y][$x] < $e[$y-1][$x] ) ? $isvent & true : $isvent & false;
  $isvent = ( !array_key_exists($y+1, $e) || $e[$y][$x] < $e[$y+1][$x] ) ? $isvent & true : $isvent & false;
  $isvent = ( !array_key_exists($x+1, $e[$y]) || $e[$y][$x] < $e[$y][$x+1] ) ? $isvent & true : $isvent & false;
  $isvent = ( !array_key_exists($x-1, $e[$y]) || $e[$y][$x] < $e[$y][$x-1] ) ? $isvent & true : $isvent & false;
  return $isvent;
}

function basin ($e, $y, $x, &$c) {
  if ( $c[$y][$x] == true ) { return 0; }
  $c[$y][$x] = true;
  $basin = 1;
  $basin += ( array_key_exists($y-1, $e) && $e[$y-1][$x] < 9 ) ? basin($e, $y-1, $x, $c) : 0;
  $basin += ( array_key_exists($y+1, $e) && $e[$y+1][$x] < 9 ) ? basin($e, $y+1, $x, $c) : 0;
  $basin += ( array_key_exists($x+1, $e[$y]) && $e[$y][$x+1] < 9 ) ? basin($e, $y, $x+1, $c) : 0; 
  $basin += ( array_key_exists($x-1, $e[$y]) && $e[$y][$x-1] < 9 ) ? basin($e, $y, $x-1, $c) : 0;
  return $basin;
}



