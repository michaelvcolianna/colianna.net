<?php

namespace TwoFAS\Light\Cookie;

use TwoFAS\Light\Time\Time;

class Cookie {
	
	const TIME_DIFF_FOR_DELETION = - 3600;
	
	/** @var Time */
	private $time;
	
	/**
	 * @return Cookie
	 */
	public static function create() {
		$time = new Time();
		
		return new self( $time );
	}
	
	/**
	 * Cookie constructor.
	 *
	 * @param Time $time
	 */
	public function __construct( Time $time ) {
		$this->time = $time;
	}
	
	/**
	 * @param string $name
	 * @param string $value
	 * @param int    $expire
	 * @param bool   $httponly
	 *
	 * @return bool
	 */
	public function set_cookie( $name, $value = '', $expire = 0, $httponly = false ) {
		return setcookie( $name, $value, $expire, '/', '', false, $httponly );
	}
	
	public function delete_cookie( $name ) {
		$time = $this->get_expiration_time_from_now( self::TIME_DIFF_FOR_DELETION );
		
		return $this->set_cookie( $name, '', $time );
	}
	
	/**
	 * @param int $expiration_period_in_seconds
	 *
	 * @return int
	 */
	public function get_expiration_time_from_now( $expiration_period_in_seconds ) {
		return $this->time->get_current_time() + $expiration_period_in_seconds;
	}
	
	/**
	 * @param string $name
	 *
	 * @return string|null
	 */
	public function get_cookie_value( $name ) {
		return ! empty( $_COOKIE[ $name ] ) ? $_COOKIE[ $name ] : null;
	}
}
