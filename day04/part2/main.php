<?php

function read_card_from_stdin() {
  $newline = fscanf(STDIN, "%s\n");
  if ($newline === false)  return false; 

  $card = array();
  $marked = array();
  for ($i = 0; $i < 5; $i++) {
    $card[] = fscanf(STDIN, "%s %s %s %s %s\n");
    $marked[] = array(0, 0, 0, 0, 0);
  }

  return array('card' => $card, 'marked' => $marked);
}

function read_from_stdin() {
  $numbers = explode(',', fscanf(STDIN, "%s\n")[0]);

  $cards = array();
  $marked = array();
  while( $card = read_card_from_stdin() ) {
    $cards[] = $card['card'];
    $marked[] = array(
      'x' => $card['marked'],
      'y' => $card['marked']
    );
  }
  
  $result = array(
    'numbers' => $numbers,
    'cards' => $cards,
    'marked' => $marked
  );

  return $result;
}

// Read all the contents from the line (assuming our alzheimers isn't acting up)
$input = read_from_stdin();

$numbers = $input['numbers'];
$cards = $input['cards'];
$marked = $input['marked'];

$winner_count = count($cards);
foreach ($numbers as $num) {
  mark_cards($num, $cards, $marked);
  do {
    $winner = check_winner($marked);
    if ( !is_null($winner) ) {
      $winner_count--;
      if ($winner_count == 0) {
        $score = calculate_score($num, $cards[$winner], $marked[$winner]['x']);
        printf("Card %d wins with number %d and score %d\n", $winner, $num, $score);
        exit;
      }
      unset($cards[$winner]);
      unset($marked[$winner]);
    }
  } while ( !is_null($winner) );
}

printf("No winner found: %d cards left and last winner %d\n", $winner_count, $last_winner );
      

function mark_cards ($number, $cards, &$marked) {
  foreach ( $cards as $ckey => $cvalue ) {
    foreach ( $cvalue as $cykey => $cyvalue ) {
      foreach ( $cyvalue as $cxkey => $cxvalue ) {
        if ($cxvalue == $number) {
          $marked[$ckey]['x'][$cykey][$cxkey] = '1';
          $marked[$ckey]['y'][$cxkey][$cykey] = '1';
        }
      }
    }
  }
}

function check_winner($marked) {
  foreach ( $marked as $key => $card ) {
    foreach ( $card['x'] as $rkey => $rvalue ) {
      if (implode('', $card['x'][$rkey]) == '11111') { return $key; };
      if (implode('', $card['y'][$rkey]) == '11111') { return $key; };
    }
  }
  return null;
}

function calculate_score($number, $card, $marked) {
  $score = 0;
  foreach ( $card as $cykey => $cyvalue ) {
    foreach ( $cyvalue as $cxkey => $cxvalue ) {
      $score += intval($card[$cykey][$cxkey], 10) * (!(intval($marked[$cykey][$cxkey], 2)));
    }
  }
  return $score * intval($number, 10);
}
