<?php

namespace TwoFAS\Light\Hash;

use TwoFAS\Encryption\Random\RandomGenerator;

class Hash_Generator {
	
	const GENERATED_HASH_LENGTH = 128;
	
	/** @var RandomGenerator */
	private $random_generator;
	
	/**
	 * Hash_Generator constructor.
	 *
	 * @param RandomGenerator $random_generator
	 */
	public function __construct( RandomGenerator $random_generator ) {
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
