<?php

namespace TwoFAS\Light\Login_Token;

use TwoFAS\Light\User\User;

class Login_Token {

	/** @var User */
	private $user;

	/** @var string */
	private $hash;

	/** @var int */
	private $expiry;

	/** @var string */
	private $context;

	/**
	 * @param User   $user
	 * @param string $hash
	 * @param int    $expiry
	 * @param string $context
	 */
	public function __construct( User $user, $hash, $expiry, $context ) {
		$this->user    = $user;
		$this->hash    = $hash;
		$this->expiry  = $expiry;
		$this->context = $context;
	}

	/**
	 * @return User
	 */
	public function get_user() {
		return $this->user;
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

	/**
	 * @return string
	 */
	public function get_context() {
		return $this->context;
	}
}
