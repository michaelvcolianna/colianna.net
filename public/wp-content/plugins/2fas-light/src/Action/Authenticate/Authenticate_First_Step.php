<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\App;
use TwoFAS\Light\Login\Login_Params_Mapper;
use TwoFAS\Light\Login\Login_Redirector;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_Request_Not_Handled;
use TwoFAS\Light\Step_Token\Step_Token;
use TwoFAS\Light\User\User;
use WP_User;

class Authenticate_First_Step implements Authentication_Strategy {
	
	/** @var App */
	private $app;
	
	/** @var Request */
	private $request;
	
	/** @var Login_Params_Mapper */
	private $login_params;
	
	/** @var Login_Redirector */
	private $login_redirector;
	
	/** @var Authentication_Input */
	private $authentication_input;
	
	/** @var Step_Token */
	private $step_token;
	
	/**
	 * @param App                  $app
	 * @param Authentication_Input $authentication_input
	 */
	public function __construct( App $app, Authentication_Input $authentication_input ) {
		$this->app                  = $app;
		$this->authentication_input = $authentication_input;
		$this->request              = $this->app->get_request();
		$this->login_params         = $this->app->get_login_params_mapper();
		$this->login_redirector     = $this->app->get_login_redirector();
		$this->step_token           = $this->app->get_step_token();
	}
	
	/**
	 * @return Result_HTML|Result_Request_Not_Handled
	 */
	public function authenticate() {
		if ( ! $this->is_step_successful() || ! $this->should_authenticate_user_using_2fa() ) {
			return new Result_Request_Not_Handled();
		}
		
		$this->init_totp_login_session();

		if ( ! $this->login_redirector->is_current_page_standard_wp_login_page() ) {
			$this->login_redirector->redirect_to_wp_login_page();
		}
		
		return $this->app->get_second_step_renderer()->render();
	}
	
	/**
	 * @return bool
	 */
	public function is_step_successful() {
		return $this->authentication_input->get() instanceof WP_User;
	}
	
	/**
	 * @return bool
	 */
	public function should_authenticate_user_using_2fa() {
		$user              = new User( $this->authentication_input->get()->ID );
		$is_device_trusted = $this->app->get_trusted_device_manager( $user )->get_from_cookie() !== null;
		
		return $user->is_totp_configured() && $user->is_totp_enabled() && ! $is_device_trusted;
	}
	
	private function init_totp_login_session() {
		$user = new User( $this->authentication_input->get()->ID );
		
		$hash = $this->step_token->generate_hash();
		$this->step_token->store_token_in_user_meta( $user, $hash );
		$this->step_token->store_token_cookie( $user, $hash );
	}
}
