<?php

namespace TwoFAS\Light\Step_Token;

use TwoFAS\Light\Time\Time;

class Step_Token_Validator {
	
	/** @var Time */
	private $time;
	
	/**
	 * @return Step_Token_Validator
	 */
	public static function create() {
		$time = new Time();
		
		return new self( $time );
	}
	
	/**
	 * Step_Token_Validator constructor.
	 *
	 * @param Time $time
	 */
	public function __construct( Time $time ) {
		$this->time = $time;
	}
	
	/**
	 * @param Step_Token_Cookie    $token_in_cookie
	 * @param Step_Token_User_Meta $token_in_meta
	 *
	 * @return bool
	 */
	public function validate_token( Step_Token_Cookie $token_in_cookie, Step_Token_User_Meta $token_in_meta ) {
		if ( $token_in_meta->get_expiry() <= $this->time->get_current_time() ) {
			return false;
		}
		
		return $token_in_cookie->get_hash() === $token_in_meta->get_hash();
	}
}
