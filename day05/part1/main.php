<?php

function read_from_stdin() {
  $lines = array();
  while( $line = fscanf(STDIN, "%d,%d -> %d,%d\n") ) {
    list ($x1, $y1, $x2, $y2) = $line;
    $lines[] = array(
      'x1' => $x1,
      'y1' => $y1,
      'x2' => $x2,
      'y2' => $y2
    );
  }
  return $lines;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$input = read_from_stdin();

$vents = array();

foreach ($input as $vent) {

  if ( $vent['x1'] != $vent['x2'] && $vent['y1'] != $vent['y2'] ) {
    continue;
  }
  $x1 = min($vent['x1'],$vent['x2']);
  $x2 = max($vent['x1'],$vent['x2']);
  $y1 = min($vent['y1'],$vent['y2']);
  $y2 = max($vent['y1'],$vent['y2']);

  for ($x = $x1; $x <= $x2; $x++) {
    for ($y = $y1; $y <= $y2; $y++) {
      $vents[$y][$x] = isset($vents[$y][$x]) ? $vents[$y][$x] + 1 : 1;
    }
  }
}

$danger = 0;
foreach ($vents as $y=>$yval) {
  foreach ($yval as $x=>$xval) {
    $danger = $xval >= 2 ? $danger + 1 : $danger;
  }
} 

printf("Final result is %d\n", $danger);