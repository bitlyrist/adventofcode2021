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
  ')' => 3,
  ']' => 57,
  '}' => 1197,
  '>' => 25137
);

$illegal_char = array();
$ilchcnt = array();
foreach ($chunks as $linenum => $chunk) {
  $chunkstack = array();
  foreach ($chunk as $char) {
    if ( isset($OPEN[$char]) ) {
      array_push($chunkstack, $char);
    } else {
      $peak = array_pop($chunkstack);
      if ( $char != $OPEN[$peak] ) {
        $illegal_char[$linenum] = $char;
        unset($chunks[$linenum]);
        break;
      }
      $peak = null;
    }
  }

  // print_r($chunkstack);
  unset($chunkstack);
}
// print_r($illegal_char);

$ilcnts = array_count_values($illegal_char);
// print_r( $ilcnts);

$product = 0;
foreach ( $ilcnts as $char => $mod ) { 
  $mod = $CLOSED[$char] * $mod;
  // printf("%d\n", $mod);
  $product += $mod;
}

printf("I forget what this number is %d\n", $product);
