<?php

namespace TwoFAS\Light\TOTP;

use LogicException;
use TwoFAS\Light\Exception\Invalid_TOTP_Secret;
use TwoFAS\Light\Time\Time;

class Code_Generator {
	
	/**
	 * Interval between key regeneration
	 */
	const KEY_REGENERATION = 30;
	
	/**
	 * How many seconds behind or ahead of current time should codes be generated for to allow minor client/server
	 * time discrepancies. Must be divisible by self::KEY_REGENERATION.
	 */
	const SECONDS_BEHIND_OR_AHEAD = 120;
	
	/**
	 * @var string
	 */
	private $secret;
	
	/**
	 * @var int
	 */
	private $duration;
	
	/**
	 * @var Time
	 */
	private $time;
	
	/**
	 * @var Format_Validator
	 */
	private $format_validator;
	
	/**
	 * @var Single_Code_Generator
	 */
	private $single_code_generator;
	
	/**
	 * @var Base32_Decoder
	 */
	private $base32_decoder;
	
	/**
	 * Code_Generator constructor.
	 *
	 * @param string                $totp_secret
	 * @param Time                  $time
	 * @param Format_Validator      $format_validator
	 * @param Single_Code_Generator $single_code_generator
	 * @param Base32_Decoder        $base32_decoder
	 */
	public function __construct(
		$totp_secret,
		Time $time,
		Format_Validator $format_validator,
		Single_Code_Generator $single_code_generator,
		Base32_Decoder $base32_decoder
	) {
		$this->secret                = $totp_secret;
		$this->duration              = self::SECONDS_BEHIND_OR_AHEAD * 2;
		$this->time                  = $time;
		$this->format_validator      = $format_validator;
		$this->single_code_generator = $single_code_generator;
		$this->base32_decoder        = $base32_decoder;
	}
	
	/**
	 * @return array
	 * @throws Invalid_TOTP_Secret
	 */
	public function generate_tokens() {
		$this->format_validator->validate_secret_format( $this->secret );
		
		$tokens_for_period = array();
		$binary_key        = $this->base32_decoder->decode( $this->secret );
		
		for ( $code_offset = 0; $code_offset < $this->get_codes_amount(); $code_offset ++ ) {
			$tokens_for_period[] = $this->generate_token_for_code_offset( $binary_key, $code_offset );
		}
		
		return $tokens_for_period;
	}
	
	/**
	 * @param string $binary_key
	 * @param int    $code_offset
	 *
	 * @return string
	 */
	private function generate_token_for_code_offset( $binary_key, $code_offset ) {
		$timestamp = $this->time->get_current_time() + $this->get_period( $code_offset );
		
		return $this->single_code_generator->generate_token( $binary_key, $timestamp );
	}
	
	/**
	 * @param int $offset
	 *
	 * @return int
	 */
	private function get_period( $offset ) {
		return - self::SECONDS_BEHIND_OR_AHEAD + ( $offset * self::KEY_REGENERATION );
	}
	
	/**
	 * @return int
	 */
	private function get_codes_amount() {
		if ( $this->duration % self::KEY_REGENERATION ) {
			throw new LogicException( 'Number of codes is not valid' );
		}
		
		return $this->duration / self::KEY_REGENERATION;
	}
}
