<?php

namespace TwoFAS\Light\Login_Token;

use TwoFAS\Encryption\Random\RandomGenerator;
use TwoFAS\Light\Cookie\Cookie;
use TwoFAS\Light\Hash\Hash_Generator;
use TwoFAS\Light\Time\Time;
use TwoFAS\Light\User\User_Repository;

class Login_Token_Manager_Factory {

	/** @var Login_Token_Config */
	private $config;

	/**
	 * @param Login_Token_Config $config
	 */
	public function __construct( Login_Token_Config $config ) {
		$this->config = $config;
	}

	/**
	 * @return Login_Token_Manager
	 */
	public function create() {
		$time                = new Time();
		$cookie              = new Login_Token_Cookie( $this->config, Cookie::create() );
		$user_meta           = new Login_Token_User_Meta( $this->config );
		$token_validator     = new Login_Token_Validator( $time );
		$user_repository     = new User_Repository();
		$hash_generator      = new Hash_Generator( new RandomGenerator() );
		$login_token_factory = new Login_Token_Factory( $this->config, $hash_generator, $time );

		return new Login_Token_Manager(
			$this->config,
			$cookie,
			$user_meta,
			$token_validator,
			$login_token_factory,
			$user_repository
		);
	}
}
