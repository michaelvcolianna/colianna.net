<?php

namespace TwoFAS\Light\Step_Token;

use TwoFAS\Encryption\Random\RandomGenerator;
use TwoFAS\Light\Cookie\Cookie;
use TwoFAS\Light\Cookie\Cookie_Config_Factory;
use TwoFAS\Light\Cookie\Cookie_Writer;
use TwoFAS\Light\Hash\Hash_Generator;
use TwoFAS\Light\Time\Time;
use TwoFAS\Light\User\User;

class Step_Token {
	
	const COOKIE_NAME = 'twofas_light_step_token';
	const COOKIE_VALUE_DELIMITER = '|';
	const COOKIE_EXPIRATION_SECONDS = 300;
	
	const USER_META_NAME = 'twofas_light_step_token';
	
	const HASH_LENGTH = 128;
	
	/** @var Hash_Generator */
	private $hash_generator;
	
	/** @var Cookie */
	private $cookie;
	
	/** @var Time */
	private $time;
	
	/** @var Step_Token_Validator */
	private $token_validator;
	
	/**
	 * @return Step_Token
	 */
	public static function create() {
		$hash_generator        = new Hash_Generator( new RandomGenerator() );
		$time                  = new Time();
		$cookie_config_factory = new Cookie_Config_Factory();
		$cookie                = new Cookie( $cookie_config_factory->create(), new Cookie_Writer(), $time );
		$token_validator       = new Step_Token_Validator( $time );
		
		return new self( $hash_generator, $cookie, $time, $token_validator );
	}
	
	/**
	 * Step_Token constructor.
	 *
	 * @param Hash_Generator       $hash_generator
	 * @param Cookie               $cookie
	 * @param Time                 $time
	 * @param Step_Token_Validator $token_validator
	 */
	public function __construct(
		Hash_Generator $hash_generator,
		Cookie $cookie,
		Time $time,
		Step_Token_Validator $token_validator
	) {
		$this->hash_generator  = $hash_generator;
		$this->cookie          = $cookie;
		$this->time            = $time;
		$this->token_validator = $token_validator;
	}
	
	/**
	 * @return string
	 */
	public function generate_hash() {
		return $this->hash_generator->generate_hash( self::HASH_LENGTH );
	}
	
	/**
	 * @param User   $user
	 * @param string $hash
	 */
	public function store_token_cookie( User $user, $hash ) {
		$encoded_hash = base64_encode( $hash );
		$cookie_value = implode( self::COOKIE_VALUE_DELIMITER, array( $user->get_login(), $encoded_hash ) );
		
		$expiration_time = $this->cookie->get_expiration_time_from_now( self::COOKIE_EXPIRATION_SECONDS );
		$this->cookie->set_cookie( self::COOKIE_NAME, $cookie_value, $expiration_time, true );
	}
	
	/**
	 * @param User   $user
	 * @param string $hash
	 */
	public function store_token_in_user_meta( User $user, $hash ) {
		$expiry = $this->cookie->get_expiration_time_from_now( self::COOKIE_EXPIRATION_SECONDS );
		
		$meta_value = array(
			'hash'   => $hash,
			'expiry' => $expiry,
		);
		
		$user->save_user_field( self::USER_META_NAME, $meta_value );
	}
	
	/**
	 * @param User $user
	 */
	public function delete_token_from_user_meta( User $user ) {
		$user->remove_user_field( self::USER_META_NAME );
	}
	
	public function delete_token_cookie() {
		$this->cookie->delete_cookie( self::COOKIE_NAME );
	}
	
	/**
	 * @return null|Step_Token_Cookie
	 */
	public function get_token_cookie() {
		$cookie_value = $this->cookie->get_cookie_value( self::COOKIE_NAME );
		
		return Step_Token_Cookie::create_from_cookie_value( $cookie_value );
	}
	
	/**
	 * @param User $user
	 *
	 * @return null|Step_Token_User_Meta
	 */
	public function get_token_from_user_meta( User $user ) {
		$token_in_user_meta = $user->get_user_field( self::USER_META_NAME );
		
		return Step_Token_User_Meta::create_from_user_meta( $token_in_user_meta );
	}
	
	/**
	 * @param User $user
	 *
	 * @return bool
	 */
	public function validate_user_token( User $user ) {
		$token_in_cookie = $this->get_token_cookie();
		$token_in_meta   = $this->get_token_from_user_meta( $user );
		
		if ( ! $token_in_meta ) {
			return false;
		}
		
		return $this->token_validator->validate_token( $token_in_cookie, $token_in_meta );
	}
}
