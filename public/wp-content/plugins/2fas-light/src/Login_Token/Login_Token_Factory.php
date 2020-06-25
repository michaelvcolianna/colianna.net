<?php


namespace TwoFAS\Light\Login_Token;

use TwoFAS\Light\Hash\Hash_Generator;
use TwoFAS\Light\Time\Time;
use TwoFAS\Light\User\User;

class Login_Token_Factory {

	/** @var Login_Token_Config */
	private $config;

	/** @var Hash_Generator */
	private $hash_generator;

	/** @var Time */
	private $time;

	/**
	 * @param Login_Token_Config $login_token_config
	 * @param Hash_Generator     $hash_generator
	 * @param Time               $time
	 */
	public function __construct( Login_Token_Config $login_token_config, Hash_Generator $hash_generator, Time $time ) {
		$this->config         = $login_token_config;
		$this->hash_generator = $hash_generator;
		$this->time           = $time;
	}

	/**
	 * @param User   $user
	 * @param string $context
	 *
	 * @return Login_Token
	 */
	public function create( User $user, $context ) {
		$hash   = $this->hash_generator->generate_hash( $this->config->get_hash_length() );
		$expiry = $this->time->get_current_timestamp_plus_seconds( $this->config->get_expiration_in_seconds() );

		return new Login_Token( $user, $hash, $expiry, $context );
	}
}
