<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\App;
use TwoFAS\Light\Exception\Validation_Exception;
use TwoFAS\Light\Login_Token\Login_Context;
use TwoFAS\Light\Login_Token\Login_Token;
use TwoFAS\Light\Login_Token\Login_Token_Manager;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\Result\Result_Error;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_User;
use TwoFAS\Light\User\User;

class Authenticate_Second_Step implements Authentication_Strategy {
	
	/** @var App */
	private $app;
	
	/** @var Request */
	private $request;
	
	/** @var Login_Token_Manager */
	private $step_token_manager;
	
	/** @var Login_Token_Manager */
	private $jetpack_login_token_manager;
	
	/** @var Login_Token */
	private $step_token;
	
	/**
	 * @param App         $app
	 * @param Login_Token $step_token
	 */
	public function __construct( App $app, Login_Token $step_token ) {
		$this->app                         = $app;
		$this->request                     = $app->get_request();
		$this->step_token_manager          = $app->get_step_token_manager();
		$this->jetpack_login_token_manager = $app->get_jetpack_login_token_manager();
		$this->step_token                  = $step_token;
	}
	
	/**
	 * @return Result_Error|Result_HTML|Result_User
	 */
	public function authenticate() {
		$login_redirector = $this->app->get_login_redirector();
		if ( ! $login_redirector->is_current_page_standard_wp_login_page() && ! $login_redirector->was_redirected_to_login_page() ) {
			$login_redirector->redirect_to_wp_login_page();
		}
		
		$user = $this->step_token->get_user();
		
		try {
			$this->validate_totp_token( $user );
		} catch ( Validation_Exception $e ) {
			return $this->app->get_second_step_renderer()->render( $e->getMessage() );
		}
		
		$this->step_token_manager->delete_meta_and_cookie_for_user( $user );
		
		if ( $this->request->get_from_post( 'twofas_light_save_device_as_trusted' ) ) {
			$this->app->get_trusted_device_manager( $user )->create();
		}
		
		if ( $this->is_jetpack_login_session() ) {
			$token = $this->jetpack_login_token_manager->create( $user, '' );
			$this->jetpack_login_token_manager->store( $token );
			$login_redirector->redirect_to_jetpack_login_page();
		}
		
		return new Result_User( $user );
	}
	
	/**
	 * @param User $user
	 *
	 * @throws Validation_Exception
	 */
	private function validate_totp_token( User $user ) {
		$this->app->get_totp_login_validator()->validate( $this->app, $user );
	}
	
	/**
	 * @return bool
	 */
	private function is_jetpack_login_session() {
		return Login_Context::JETPACK === $this->step_token->get_context();
	}
}
