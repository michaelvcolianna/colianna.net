<?php

namespace TwoFAS\Light\Login_Token;

use TwoFAS\Light\Exception\Token_Validation_Failed_Exception;
use TwoFAS\Light\Time\Time;

class Login_Token_Validator {

	/** @var Time */
	private $time;

	/**
	 * @param Time $time
	 */
	public function __construct( Time $time ) {
		$this->time = $time;
	}

	/**
	 * @param Login_Token $token
	 * @param string      $hash
	 *
	 * @throws Token_Validation_Failed_Exception
	 */
	public function validate( Login_Token $token, $hash ) {
		if ( $token->get_expiry() <= $this->time->get_current_timestamp() ) {
			throw new Token_Validation_Failed_Exception();
		}

		if ( $hash !== $token->get_hash() ) {
			throw new Token_Validation_Failed_Exception();
		}
	}
}
