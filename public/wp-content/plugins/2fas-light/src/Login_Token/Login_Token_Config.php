<?php

namespace TwoFAS\Light\Login_Token;

abstract class Login_Token_Config {
	
	/** @var string */
	private $user_meta_name;
	
	/** @var string */
	private $cookie_name;
	
	/** @var int */
	private $expiration_in_seconds;
	
	/** @var int */
	private $hash_length;
	
	/**
	 * @param string $user_meta_name
	 * @param string $cookie_name
	 * @param int    $expiration_seconds
	 * @param int    $hash_length
	 */
	public function __construct( $user_meta_name, $cookie_name, $expiration_seconds, $hash_length ) {
		$this->user_meta_name        = $user_meta_name;
		$this->cookie_name           = $cookie_name;
		$this->expiration_in_seconds = $expiration_seconds;
		$this->hash_length           = $hash_length;
	}
	
	/**
	 * @return string
	 */
	public function get_user_meta_name() {
		return $this->user_meta_name;
	}
	
	/**
	 * @return string
	 */
	public function get_cookie_name() {
		return $this->cookie_name;
	}
	
	/**
	 * @return int
	 */
	public function get_expiration_in_seconds() {
		return $this->expiration_in_seconds;
	}
	
	/**
	 * @return int
	 */
	public function get_hash_length() {
		return $this->hash_length;
	}
}
