<?php

namespace TwoFAS\Light\Login_Token;

use InvalidArgumentException;
use TwoFAS\Light\Cookie\Cookie;
use TwoFAS\Light\Exception\Invalid_Or_Empty_Cookie_Value_Exception;
use TwoFAS\Light\User\User;

class Login_Token_Cookie {
	
	const COOKIE_VALUE_DELIMITER = '|';
	const COOKIE_HTTP_ONLY       = true;
	
	/** @var Login_Token_Config */
	private $config;
	
	/** @var Cookie */
	private $cookie;
	
	/**
	 * @param Login_Token_Config $config
	 * @param Cookie             $cookie
	 */
	public function __construct( Login_Token_Config $config, Cookie $cookie ) {
		$this->config = $config;
		$this->cookie = $cookie;
	}
	
	/**
	 * @return string
	 * @throws Invalid_Or_Empty_Cookie_Value_Exception
	 */
	public function get_user_login() {
		return $this->get_cookie_component( 0 );
	}
	
	/**
	 * @return string
	 * @throws Invalid_Or_Empty_Cookie_Value_Exception
	 */
	public function get_hash() {
		$decoded_hash = base64_decode( $this->get_cookie_component( 1 ), true );
		
		if ( false === $decoded_hash ) {
			throw new Invalid_Or_Empty_Cookie_Value_Exception();
		}
		
		return $decoded_hash;
	}
	
	/**
	 * @param User   $user
	 * @param string $hash
	 * @param int    $expiration_time
	 */
	public function store( User $user, $hash, $expiration_time ) {
		$encoded_hash = base64_encode( $hash );
		$cookie_value = implode( self::COOKIE_VALUE_DELIMITER, [ $user->get_login(), $encoded_hash ] );
		
		$this->cookie->set_cookie(
			$this->config->get_cookie_name(),
			$cookie_value,
			$expiration_time,
			self::COOKIE_HTTP_ONLY
		);
	}
	
	public function delete() {
		$cookie_value = $this->cookie->get_cookie_value( $this->config->get_cookie_name() );
		if ( ! empty( $cookie_value ) ) {
			$this->cookie->delete_cookie( $this->config->get_cookie_name() );
		}
	}
	
	/**
	 * @param int $component_index
	 *
	 * @return string
	 * @throws Invalid_Or_Empty_Cookie_Value_Exception
	 * @throws InvalidArgumentException
	 */
	private function get_cookie_component( $component_index ) {
		if ( ! in_array( $component_index, [ 0, 1 ], true ) ) {
			throw new InvalidArgumentException( 'Component index must be either 0 or 1' );
		}
		
		$cookie_value = $this->cookie->get_cookie_value( $this->config->get_cookie_name() );
		if ( empty( $cookie_value ) ) {
			throw new Invalid_Or_Empty_Cookie_Value_Exception();
		}
		
		$value_components = explode( self::COOKIE_VALUE_DELIMITER, $cookie_value );
		
		if ( 2 !== count( $value_components ) ) {
			throw new Invalid_Or_Empty_Cookie_Value_Exception();
		}
		
		return $value_components[ $component_index ];
	}
}
