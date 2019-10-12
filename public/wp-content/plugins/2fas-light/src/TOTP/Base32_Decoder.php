<?php

namespace TwoFAS\Light\TOTP;

use LogicException;

class Base32_Decoder {
	
	/** @var Base32_Alphabet */
	private $alphabet;
	
	public function __construct( Base32_Alphabet $base32_alphabet ) {
		$this->alphabet = $base32_alphabet;
	}
	
	/**
	 * Decodes a base32 string into a binary string.
	 *
	 * @param string $b32
	 *
	 * @return string (binary)
	 *
	 * @throws LogicException
	 */
	public function decode( $b32 ) {
		$b32                = strtoupper( $b32 );
		$allowed_characters = $this->alphabet->get_characters();
		if ( ! preg_match( '/^[' . $allowed_characters . ']{' . Secret_Generator::SECRET_LENGTH . '}$/', $b32 ) ) {
			throw new LogicException;
		}
		$l            = strlen( $b32 );
		$n            = 0;
		$j            = 0;
		$binary       = '';
		$decoding_map = $this->alphabet->get_decoding_map();
		for ( $i = 0; $i < $l; $i ++ ) {
			
			$n = $n << 5;                // Move buffer left by 5 to make room
			$n = $n + $decoding_map[ $b32[ $i ] ];    // Add value into buffer
			$j = $j + 5;                // Keep track of number of bits in buffer
			
			if ( $j >= 8 ) {
				$j      = $j - 8;
				$binary .= chr( ( $n & ( 0xFF << $j ) ) >> $j );
			}
		}
		
		return $binary;
	}
}
