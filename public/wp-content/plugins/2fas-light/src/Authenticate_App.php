<?php

namespace TwoFAS\Light;

use TwoFAS\Light\Action\Authenticate;
use TwoFAS\Light\Action\Authenticate\Authentication_Input;
use TwoFAS\Light\Exception\Authenticate_No_Username_Nor_Step_Token_Exception;
use TwoFAS\Light\Exception\TwoFAS_Light_Exception;
use TwoFAS\Light\Exception\Login_Token_Invalid_Exception;
use TwoFAS\Light\Request\Regular_Request;
use TwoFAS\Light\Result\Error_Consumer;
use TwoFAS\Light\Result\HTML_Consumer;
use TwoFAS\Light\Result\Request_Not_Handled_Consumer;
use TwoFAS\Light\Result\Result_Error;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_Request_Not_Handled;
use TwoFAS\Light\Result\Result_User;
use TwoFAS\Light\Result\User_Consumer;
use WP_Error;
use WP_User;

class Authenticate_App extends App implements HTML_Consumer, User_Consumer, Error_Consumer, Request_Not_Handled_Consumer {
	
	/** @var Authenticate */
	private $action;
	
	/** @var Authentication_Input */
	private $authentication_input;
	
	/**
	 * Authenticate_App constructor.
	 *
	 * @param Authenticate         $action
	 * @param Authentication_Input $authentication_input
	 */
	public function __construct( Authenticate $action, Authentication_Input $authentication_input ) {
		parent::__construct();
		$this->action               = $action;
		$this->authentication_input = $authentication_input;
	}
	
	/**
	 * @return WP_User|WP_Error|null
	 */
	public function run() {
		$this->request = new Regular_Request();
		$this->request->fill_with_context( $this->request_context );
		
		$result = $this->authenticate();
		
		return $result->feed_consumer( $this );
	}
	
	/**
	 * @param $user_id
	 *
	 * @return WP_User
	 */
	public function consume_user( $user_id ) {
		return new WP_User( $user_id );
	}
	
	/**
	 * @param string $html
	 */
	public function consume_html( $html ) {
		echo $html;
		exit();
	}
	
	/**
	 * @param $error
	 *
	 * @return mixed
	 * @throws TwoFAS_Light_Exception
	 */
	public function consume_error( $error ) {
		if ( ! ( $error instanceof WP_Error ) ) {
			throw new TwoFAS_Light_Exception( 'Unexpected response type from request handler' );
		}
		
		return $error;
	}
	
	/**
	 * @return WP_User|WP_Error|null
	 */
	public function consume_request_not_handled() {
		return $this->authentication_input->get();
	}
	
	/**
	 * @return Result_HTML|Result_User|Result_Error|Result_Request_Not_Handled
	 */
	private function authenticate() {
		$step_token_manager = $this->get_step_token_manager();
		try {
			return $this->action->handle( $this );
			
		} catch ( Authenticate_No_Username_Nor_Step_Token_Exception $e ) {
			if ( $this->request->get_from_post( 'twofas_light_totp_token' ) !== null ) {
				return $this->create_invalid_step_token_result();
			}
			
			return new Result_Request_Not_Handled();
			
		} catch ( Login_Token_Invalid_Exception $e ) {
			$step_token_manager->delete_cookie();
			
			return $this->create_invalid_step_token_result();
		}
	}
	
	/**
	 * @return Result_Error
	 */
	private function create_invalid_step_token_result() {
		$wp_error = $this->error_factory->create_wp_error(
			'twofas-invalid-step-token',
			'2FAS Light session expired or is invalid, please log in again.'
		);
		
		return new Result_Error( $wp_error );
	}
}
