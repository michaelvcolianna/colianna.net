<?php

namespace TwoFAS\Light\Login_Token;

use TwoFAS\Light\Exception\Invalid_Or_Empty_Cookie_Value_Exception;
use TwoFAS\Light\Exception\Invalid_Or_Empty_User_Meta_Value_Exception;
use TwoFAS\Light\Exception\Login_Token_Invalid_Exception;
use TwoFAS\Light\Exception\Token_Validation_Failed_Exception;
use TwoFAS\Light\Exception\User_Not_Found_Exception;
use TwoFAS\Light\User\User;
use TwoFAS\Light\User\User_Repository;

class Login_Token_Manager {

	/** @var Login_Token_Factory */
	private $login_token_factory;

	/** @var Login_Token_Config */
	private $config;

	/** @var Login_Token_Cookie */
	private $cookie;

	/** @var Login_Token_User_Meta */
	private $user_meta;

	/** @var Login_Token_Validator */
	private $validator;

	/** @var User_Repository */
	private $user_repository;

	/**
	 * @param Login_Token_Config    $config
	 * @param Login_Token_Cookie    $cookie
	 * @param Login_Token_User_Meta $user_meta
	 * @param Login_Token_Validator $validator
	 * @param Login_Token_Factory   $login_token_factory
	 * @param User_Repository       $user_repository
	 */
	public function __construct(
		Login_Token_Config $config,
		Login_Token_Cookie $cookie,
		Login_Token_User_Meta $user_meta,
		Login_Token_Validator $validator,
		Login_Token_Factory $login_token_factory,
		User_Repository $user_repository
	) {
		$this->config              = $config;
		$this->cookie              = $cookie;
		$this->user_meta           = $user_meta;
		$this->validator           = $validator;
		$this->login_token_factory = $login_token_factory;
		$this->user_repository     = $user_repository;
	}

	/**
	 * @param User   $user
	 * @param string $context
	 *
	 * @return Login_Token
	 */
	public function create( User $user, $context ) {
		return $this->login_token_factory->create( $user, $context );
	}

	/**
	 * @param Login_Token $token
	 */
	public function store( Login_Token $token ) {
		$this->user_meta->store( $token->get_user(), $token->get_hash(), $token->get_expiry(), $token->get_context() );
		$this->cookie->store( $token->get_user(), $token->get_hash(), $token->get_expiry() );
	}

	/**
	 * @return Login_Token
	 * @throws Login_Token_Invalid_Exception
	 */
	public function get_token_by_cookie() {
		try {
			$cookie_login = $this->cookie->get_user_login();
			$cookie_hash  = $this->cookie->get_hash();
			$token        = $this->get_token_by_login( $cookie_login );
			$this->validator->validate( $token, $cookie_hash );

			return $token;
		} catch ( Invalid_Or_Empty_Cookie_Value_Exception $e ) {
			throw new Login_Token_Invalid_Exception();
		} catch ( User_Not_Found_Exception $e ) {
			throw new Login_Token_Invalid_Exception();
		} catch ( Token_Validation_Failed_Exception $e ) {
			throw new Login_Token_Invalid_Exception();
		} catch ( Invalid_Or_Empty_User_Meta_Value_Exception $e ) {
			throw new Login_Token_Invalid_Exception();
		}
	}

	/**
	 * @return bool
	 */
	public function is_cookie_in_valid_format() {
		try {
			$this->cookie->get_user_login();
			$this->cookie->get_hash();

			return true;
		} catch ( Invalid_Or_Empty_Cookie_Value_Exception $e ) {
			return false;
		}
	}

	/**
	 * @param User $user
	 */
	public function delete_meta_and_cookie_for_user( User $user ) {
		$this->user_meta->delete( $user );
		$this->cookie->delete();
	}

	public function delete_cookie() {
		$this->cookie->delete();
	}

	/**
	 * @param string $login
	 *
	 * @return Login_Token
	 * @throws Invalid_Or_Empty_User_Meta_Value_Exception
	 * @throws User_Not_Found_Exception
	 */
	private function get_token_by_login( $login ) {
		$user = $this->user_repository->get_by_login( $login );

		return $this->user_meta->get_token( $user );
	}
}
