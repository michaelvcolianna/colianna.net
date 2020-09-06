<?php

namespace TwoFAS\Light\Hash;

use TwoFAS\Encryption\Random\RandomStringGenerator;

class Hash_Generator {
	
	/** @var RandomStringGenerator */
	private $random_generator;
	
	/**
	 * Hash_Generator constructor.
	 *
	 * @param RandomStringGenerator $random_generator
	 */
	public function __construct( RandomStringGenerator $random_generator ) {
		$this->random_generator = $random_generator;
	}
	
	/**
	 * @param int $length
	 *
	 * @return string
	 */
	public function generate_hash( $length ) {
		return $this->random_generator->string( $length )->__toString();
	}
	
	/**
	 * @param int $length
	 *
	 * @return string
	 */
	public function generate_alphanumeric_hash( $length ) {
		return $this->random_generator->alphaNum( $length )->__toString();
	}
}
