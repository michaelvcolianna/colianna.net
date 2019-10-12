<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\App;
use TwoFAS\Light\Exception\User_Not_Found_By_Step_Token_Cookie_Exception;
use TwoFAS\Light\Exception\Validation_Exception;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\Result\Result_Error;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_User;
use TwoFAS\Light\Step_Token\Step_Token;
use TwoFAS\Light\User\User;

class Authenticate_Second_Step implements Authentication_Strategy {
	
	/** @var App */
	private $app;
	
	/** @var Request */
	private $request;
	
	/** @var Step_Token */
	private $step_token;
	
	/** @var Step_Token_Error_Result_Factory */
	private $step_token_error_result_factory;
	
	/**
	 * @param App                             $app
	 * @param Step_Token_Error_Result_Factory $step_token_error_result_factory
	 */
	public function __construct( App $app, Step_Token_Error_Result_Factory $step_token_error_result_factory ) {
		$this->app                             = $app;
		$this->request                         = $app->get_request();
		$this->step_token                      = $app->get_step_token();
		$this->step_token_error_result_factory = $step_token_error_result_factory;
	}
	
	/**
	 * @return Result_Error|Result_HTML|Result_User
	 */
	public function authenticate() {
		$login_redirector = $this->app->get_login_redirector();
		if ( ! $login_redirector->is_current_page_standard_wp_login_page() && ! $login_redirector->was_redirected_to_login_page() ) {
			$login_redirector->redirect_to_wp_login_page();
		}
		
		try {
			$user = $this->app->get_step_token_cookie_to_user_mapper()->get_user();
		} catch ( User_Not_Found_By_Step_Token_Cookie_Exception $e ) {
			return $this->handle_user_not_found_by_step_token_cookie();
		}
		
		try {
			$this->validate_totp_token( $user );
		} catch ( Validation_Exception $e ) {
			return $this->app->get_second_step_renderer()->render( $e->getMessage() );
		}
		
		$this->delete_step_token( $user );
		
		if ( $this->request->get_from_post( 'twofas_light_save_device_as_trusted' ) ) {
			$this->app->get_trusted_device_manager( $user )->create();
		}
		
		return new Result_User( $user );
	}
	
	/**
	 * @return Result_Error
	 */
	private function handle_user_not_found_by_step_token_cookie() {
		$this->step_token->delete_token_cookie();
		return $this->step_token_error_result_factory->create_invalid_step_token_result();
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
	 * @param User $user
	 */
	private function delete_step_token( User $user ) {
		$this->step_token->delete_token_from_user_meta( $user );
		$this->step_token->delete_token_cookie();
	}
}
