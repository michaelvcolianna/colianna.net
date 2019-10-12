<?php

namespace TwoFAS\Light\Step_Token;

class Step_Token_Cookie {
	
	/** @var string */
	private $user_login;
	
	/** @var string */
	private $hash;
	
	/**
	 * @param $cookie_value
	 *
	 * @return null|Step_Token_Cookie
	 */
	public static function create_from_cookie_value( $cookie_value ) {
		if ( empty( $cookie_value ) ) {
			return null;
		}
		
		$exploded_value = explode( Step_Token::COOKIE_VALUE_DELIMITER, $cookie_value );
		
		if ( count( $exploded_value ) < 2 ) {
			return null;
		}
		
		$user_login   = $exploded_value[0];
		$encoded_hash = $exploded_value[1];
		$decoded_hash = base64_decode( $encoded_hash );
		
		return new self( $user_login, $decoded_hash );
	}
	
	/**
	 * Step_Token_Cookie constructor.
	 *
	 * @param string $user_login
	 * @param string $hash
	 */
	private function __construct( $user_login, $hash ) {
		$this->user_login = $user_login;
		$this->hash       = $hash;
	}
	
	/**
	 * @return string
	 */
	public function get_user_login() {
		return $this->user_login;
	}
	
	/**
	 * @return string
	 */
	public function get_hash() {
		return $this->hash;
	}
}
