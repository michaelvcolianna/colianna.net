<?php

namespace TwoFAS\Light\Step_Token;

use TwoFAS\Light\Login_Token\Login_Token_Config;

class Step_Token_Config extends Login_Token_Config {

	const USER_META_NAME = 'twofas_light_step_token';
	const COOKIE_NAME = 'twofas_light_step_token';
	const EXPIRATION_IN_SECONDS = 300;
	const HASH_LENGTH = 128;


	public function __construct() {
		parent::__construct(
			self::USER_META_NAME,
			self::COOKIE_NAME,
			self::EXPIRATION_IN_SECONDS,
			self::HASH_LENGTH
		);
	}
}
