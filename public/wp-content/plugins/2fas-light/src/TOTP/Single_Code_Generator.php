<?php

namespace TwoFAS\Light\TOTP;

use LogicException;

class Single_Code_Generator {
	
	/**
	 * Length of the Token generated
	 */
	const TOTP_TOKEN_LENGTH = 6;
	
	/** @var int Interval between key regeneration */
	private $key_regeneration;
	
	/**
	 * Single_Code_Generator constructor.
	 *
	 * @param int $key_regeneration
	 */
	public function __construct( $key_regeneration ) {
		$this->key_regeneration = $key_regeneration;
	}
	
	/**
	 * @param string $binary_key
	 * @param int    $timestamp
	 *
	 * @return string
	 */
	public function generate_token( $binary_key, $timestamp ) {
		$counter = $this->get_counter( $timestamp );
		$code    = $this->oath_hotp( $binary_key, $counter );
		
		return (string) $code;
	}
	
	/**
	 * Returns the floating Unix Timestamp divided by the keyRegeneration period.
	 *
	 * @param int $timestamp
	 *
	 * @return int
	 */
	private function get_counter( $timestamp ) {
		return floor( $timestamp / $this->key_regeneration );
	}
	
	/**
	 * Takes the secret key and the timestamp and returns the one time
	 * password.
	 *
	 * @param string (binary) $key - Secret key in binary form.
	 * @param int $counter - Timestamp as returned by get_timestamp.
	 *
	 * @return string
	 * @throws LogicException
	 */
	private function oath_hotp( $key, $counter ) {
		if ( strlen( $key ) < 8 ) {
			throw new LogicException;
		}
		$bin_counter = pack( 'N*', 0 ) . pack( 'N*', $counter ); // Counter must be 64-bit int
		$hash        = hash_hmac( 'sha1', $bin_counter, $key, true );
		
		return str_pad( $this->oath_truncate( $hash ), self::TOTP_TOKEN_LENGTH, '0', STR_PAD_LEFT );
	}
	
	/**
	 * Extracts the OTP from the SHA1 hash.
	 *
	 * @param string (binary) $hash
	 *
	 * @return int
	 */
	private function oath_truncate( $hash ) {
		$offset = ord( $hash[19] ) & 0xf;
		
		return (
			       ( ( ord( $hash[ $offset + 0 ] ) & 0x7f ) << 24 ) |
			       ( ( ord( $hash[ $offset + 1 ] ) & 0xff ) << 16 ) |
			       ( ( ord( $hash[ $offset + 2 ] ) & 0xff ) << 8 ) |
			       ( ord( $hash[ $offset + 3 ] ) & 0xff )
		       ) % pow( 10, self::TOTP_TOKEN_LENGTH );
	}
}
