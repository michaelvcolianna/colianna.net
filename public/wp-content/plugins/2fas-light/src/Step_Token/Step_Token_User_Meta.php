<?php

namespace TwoFAS\Light\Step_Token;

class Step_Token_User_Meta {
	
	/** @var string */
	private $hash;
	
	/** @var int */
	private $expiry;
	
	/**
	 * @param array|null $user_meta
	 *
	 * @return null|Step_Token_User_Meta
	 */
	public static function create_from_user_meta( array $user_meta = null ) {
		if ( empty( $user_meta ) || ! isset( $user_meta['hash'], $user_meta['expiry'] ) ) {
			return null;
		}
		
		return new self( $user_meta['hash'], $user_meta['expiry'] );
	}
	
	/**
	 * Step_Token_User_Meta constructor.
	 *
	 * @param string $hash
	 * @param int    $expiry
	 */
	private function __construct( $hash, $expiry ) {
		$this->hash   = $hash;
		$this->expiry = $expiry;
	}
	
	/**
	 * @return string
	 */
	public function get_hash() {
		return $this->hash;
	}
	
	/**
	 * @return int
	 */
	public function get_expiry() {
		return $this->expiry;
	}
}
