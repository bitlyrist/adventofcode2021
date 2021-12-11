<?php

function read_from_stdin(&$lines) {
  $lines = array();
  while( $line = fscanf(STDIN, "%s\n") ) {
    $lines[] = str_split($line[0]);
  }
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
read_from_stdin($chunks);
// print_r($chunks); exit;

$OPEN = array(
  '(' => ')',
  '[' => ']',
  '{' => '}',
  '<' => '>'
);
$CLOSED = array(
  ')' => 1,
  ']' => 2,
  '}' => 3,
  '>' => 4
);


$incomplete = array();
$score = array();
foreach ($chunks as $linenum => $chunk) {
  $chunkstack = array();
  $illegal_found = false;
  foreach ($chunk as $char) {
    if ( isset($OPEN[$char]) ) {
      array_push($chunkstack, $char);
    } else {
      $peak = array_pop($chunkstack);
      if ( $char != $OPEN[$peak] ) {
        $illegal_found = true;
        break;
      }
      $peak = null;
    }
  }

  if ( !$illegal_found ) {
    $incomplete[$linenum] = array();
    $score[$linenum] = 0;
    while ($peak = array_pop($chunkstack)) {
      array_push($incomplete[$linenum], $OPEN[$peak]);
      $score[$linenum] = (5 * $score[$linenum]) + $CLOSED[ $OPEN[$peak] ];
    }
  }

  unset($chunkstack);
}

sort($score);

printf("The middle score is %d\n", $score[ ((count($score) + 1) / 2) - 1 ]);
