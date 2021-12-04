<?php

function read_from_stdin() {
  $lines = array();
  while( $line = fscanf(STDIN, "%s %d\n") ) { 
    $lines[] = $line; 
  }
  return $lines;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$input = read_from_stdin();

// print_r($input);

// directional modifiers
$directions = array(
  'forward' => array(
    'x' => 1,
    'y' => 0
  ),
  'down' => array(
    'x' => 0,
    'y' => 1
  ),
  'up' => array(
    'x' => 0,
    'y' => -1
  )
);

// print_r($directions); exit;

$location = array('x' => 0, 'y' => 0);

foreach ($input as $i)  {
  $location['x'] += $directions[$i[0]]['x'] * $i[1];
  $location['y'] += $directions[$i[0]]['y'] * $i[1];
  $location['y'] = $location['y'] < 0 ? 0 : $location['y'];
}

printf("Final location is: [%d, %d]\n", $location['x'], $location['y']);
printf("Final score is %d\n", $location['x'] * $location['y']);