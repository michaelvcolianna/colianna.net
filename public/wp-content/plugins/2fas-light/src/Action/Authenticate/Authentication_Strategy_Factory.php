<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\App;
use WP_Error;
use WP_User;

class Authentication_Strategy_Factory {
	
	/** @var App */
	private $app;
	
	/** @var Authentication_Input */
	private $authentication_input;
	
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
	 */
	public function create_strategy( App $app ) {
		$this->app                = $app;
		$step_token_error_factory = new Step_Token_Error_Result_Factory( $app->get_error_factory() );
		
		if ( $this->is_username_login_attempt() ) {
			return new Authenticate_First_Step( $this->app, $this->authentication_input );
		}
		
		if ( $this->is_step_token_login_attempt() ) {
			return new Authenticate_Second_Step( $this->app, $step_token_error_factory );
		}
		
		return new Authenticate_No_Username_Nor_Step_Token( $this->app, $step_token_error_factory );
	}
	
	/**
	 * @return bool
	 */
	private function is_username_login_attempt() {
		return $this->is_username_login_attempted_and_successful() || $this->is_username_login_attempted_and_failed();
	}
	
	/**
	 * @return bool
	 */
	private function is_username_login_attempted_and_successful() {
		return $this->authentication_input->get() instanceof WP_User;
	}
	
	/**
	 * @return bool
	 */
	private function is_username_login_attempted_and_failed() {
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
	private function is_step_token_login_attempt() {
		$step_token        = $this->app->get_step_token();
		$request           = $this->app->get_request();
		$is_login_redirect = $this->app->get_login_redirector()->was_redirected_to_login_page();
		
		return $step_token->get_token_cookie() && ( $request->is_post_request() || $is_login_redirect );
	}
}
