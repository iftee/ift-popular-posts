<?php

namespace ift\epp;

/* Stops direct visit */
if( ! defined( 'ABSPATH' ) ) {
  exit( 'Go away!' );
}

/* Trancuates string to word limit */
function epp_truncuate( $phrase, $max_words ) {
  $phrase_array = explode( ' ', $phrase );
  if( count( $phrase_array ) > $max_words && $max_words > 0 )
    $phrase = implode( ' ', array_slice( $phrase_array, 0, $max_words ) ) . '...';
  return $phrase;
}