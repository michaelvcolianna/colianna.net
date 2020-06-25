<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\App;
use TwoFAS\Light\Login\Login_Redirector;
use TwoFAS\Light\Login_Token\Login_Token;
use TwoFAS\Light\Login_Token\Login_Token_Manager;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_Request_Not_Handled;
use TwoFAS\Light\User\User;
use WP_User;

class Authenticate_First_Step implements Authentication_Strategy {
	
	/** @var App */
	private $app;
	
	/** @var Login_Redirector */
	private $login_redirector;
	
	/** @var Authentication_Input */
	private $authentication_input;
	
	/** @var Login_Token_Manager */
	private $step_token_manager;
	
	/** @var Login_Token */
	private $step_token;
	
	/**
	 * @param App                  $app
	 * @param Authentication_Input $authentication_input
	 * @param Login_Token          $step_token
	 */
	public function __construct( App $app, Authentication_Input $authentication_input, Login_Token $step_token ) {
		$this->app                  = $app;
		$this->authentication_input = $authentication_input;
		$this->login_redirector     = $this->app->get_login_redirector();
		$this->step_token_manager   = $this->app->get_step_token_manager();
		$this->step_token           = $step_token;
	}
	
	/**
	 * @return Result_HTML|Result_Request_Not_Handled
	 */
	public function authenticate() {
		if ( ! $this->is_step_successful() || ! $this->should_authenticate_user_using_2fa() ) {
			return new Result_Request_Not_Handled();
		}
		
		$this->step_token_manager->store( $this->step_token );
		
		if ( ! $this->login_redirector->is_current_page_standard_wp_login_page() ) {
			$this->login_redirector->redirect_to_wp_login_page();
		}
		
		return $this->app->get_second_step_renderer()->render();
	}
	
	/**
	 * @return bool
	 */
	private function is_step_successful() {
		return $this->authentication_input->get() instanceof WP_User;
	}
	
	/**
	 * @return bool
	 */
	private function should_authenticate_user_using_2fa() {
		$user              = new User( $this->authentication_input->get()->ID );
		$is_device_trusted = $this->app->get_trusted_device_manager( $user )->get_from_cookie() !== null;
		
		return $user->is_totp_configured() && $user->is_totp_enabled() && ! $is_device_trusted;
	}
}
