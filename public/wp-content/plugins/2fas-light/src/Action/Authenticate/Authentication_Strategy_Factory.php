<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\App;
use TwoFAS\Light\Exception\Authenticate_No_Username_Nor_Step_Token_Exception;
use TwoFAS\Light\Exception\Login_Token_Invalid_Exception;
use TwoFAS\Light\Login_Token\Login_Context;
use TwoFAS\Light\Login_Token\Login_Token_Manager;
use TwoFAS\Light\User\User;
use TwoFAS\Light\Login_Token\Login_Token;
use WP_Error;
use WP_User;

class Authentication_Strategy_Factory {
	
	const SPAMMER_WP_ERROR_CODE = 'spammer_account';
	
	/** @var App */
	private $app;
	
	/** @var Authentication_Input */
	private $authentication_input;
	
	/** @var Login_Token_Manager */
	private $step_token_manager;
	
	/**
	 * @param Authentication_Input $authentication_input
	 */
	public function __construct( Authentication_Input $authentication_input ) {
		$this->authentication_input = $authentication_input;
	}
	
	/**
	 * @param App $app
	 *
	 * @return Authentication_Strategy
	 *
	 * @throws Login_Token_Invalid_Exception
	 * @throws Authenticate_No_Username_Nor_Step_Token_Exception
	 */
	public function create_strategy( App $app ) {
		$this->app                = $app;
		$this->step_token_manager = $this->app->get_step_token_manager();
		
		if ( $this->is_reauth_requested() ) {
			return new Authenticate_Reauth_Request( $this->step_token_manager );
		}
		
		if ( $this->is_spammer_login() ) {
			return new Authenticate_Spammer_Login();
		}
		
		if ( $this->is_username_login_failed() ) {
			return new Authenticate_Username_Failed_Login();
		}
		
		if ( $this->is_username_login_attempted() ) {
			return new Authenticate_First_Step( $this->app, $this->authentication_input, $this->create_step_token() );
		}
		
		if ( $this->is_step_token_login_attempt() ) {
			return new Authenticate_Second_Step( $this->app, $this->get_step_token() );
		}
		
		throw new Authenticate_No_Username_Nor_Step_Token_Exception();
	}
	
	/**
	 * @return bool
	 */
	private function is_username_login_failed() {
		$wp_user = $this->authentication_input->get();
		if ( ! ( $wp_user instanceof WP_Error ) ) {
			return false;
		}

		$error_codes          = $wp_user->get_error_codes();
		$expected_error_codes = array( 'empty_username', 'empty_password' );
		$matched_error_codes  = array_intersect( $error_codes, $expected_error_codes );
		
		return count( $matched_error_codes ) < 2;
	}
	
	/**
	 * @return bool
	 */
	private function is_reauth_requested() {
		$reauth = $this->app->get_request()->get_from_request( 'reauth' );
		
		return ! empty( $reauth );
	}
	
	/**
	 * @return bool
	 */
	private function is_spammer_login() {
		$wp_user = $this->authentication_input->get();
		
		return $wp_user instanceof WP_Error && self::SPAMMER_WP_ERROR_CODE === $wp_user->get_error_code();
	}
	
	/**
	 * @return bool
	 */
	private function is_username_login_attempted() {
		return $this->authentication_input->get() instanceof WP_User;
	}
	
	/**
	 * @return bool
	 */
	private function is_step_token_login_attempt() {
		$request           = $this->app->get_request();
		$is_login_redirect = $this->app->get_login_redirector()->was_redirected_to_login_page();
		
		return $this->step_token_manager->is_cookie_in_valid_format() && ( $request->is_post_request() || $is_login_redirect );
	}
	
	/**
	 * @return Login_Token
	 */
	private function create_step_token() {
		$user = new User( $this->authentication_input->get()->ID );
		
		return $this->step_token_manager->create( $user, Login_Context::USERNAME );
	}
	
	/**
	 * @return Login_Token
	 *
	 * @throws Login_Token_Invalid_Exception
	 */
	private function get_step_token() {
		return $this->step_token_manager->get_token_by_cookie();
	}
}
