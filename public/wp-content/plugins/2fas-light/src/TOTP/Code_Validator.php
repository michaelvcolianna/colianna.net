<?php

namespace TwoFAS\Light\TOTP;

use TwoFAS\Light\Exception\Empty_TOTP_Token_Exception;
use TwoFAS\Light\Exception\Invalid_TOTP_Secret;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Format;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Supplied;
use TwoFAS\Light\Exception\Non_String_TOTP_Token_Exception;

class Code_Validator {
	
	/** @var Code_Generator */
	private $totp_code_generator;
	
	/**
	 * Code_Validator constructor.
	 *
	 * @param Code_Generator $totp_code_generator
	 */
	public function __construct( Code_Generator $totp_code_generator ) {
		$this->totp_code_generator = $totp_code_generator;
	}
	
	/**
	 * @param string $totp_token
	 *
	 * @throws Non_String_TOTP_Token_Exception
	 * @throws Empty_TOTP_Token_Exception
	 * @throws Invalid_TOTP_Token_Format
	 * @throws Invalid_TOTP_Secret
	 * @throws Invalid_TOTP_Token_Supplied
	 */
	public function validate_code( $totp_token ) {
		$this->validate_format( $totp_token );
		
		$valid_tokens = $this->totp_code_generator->generate_tokens();
		
		if ( ! in_array( $totp_token, $valid_tokens, true ) ) {
			throw new Invalid_TOTP_Token_Supplied();
		}
	}
	
	/**
	 * @param string $totp_token
	 *
	 * @throws Empty_TOTP_Token_Exception
	 * @throws Invalid_TOTP_Token_Format
	 * @throws Non_String_TOTP_Token_Exception
	 */
	private function validate_format( $totp_token ) {
		if ( ! is_string( $totp_token ) ) {
			throw new Non_String_TOTP_Token_Exception();
		}
		
		if ( empty( $totp_token ) ) {
			throw new Empty_TOTP_Token_Exception();
		}
		
		if ( preg_match( '/^[0-9]{6}$/', $totp_token ) !== 1 ) {
			throw new Invalid_TOTP_Token_Format();
		}
	}
}
