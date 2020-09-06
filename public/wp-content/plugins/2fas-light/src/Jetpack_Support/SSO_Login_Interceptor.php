<?php

namespace TwoFAS\Light\Jetpack_Support;

use TwoFAS\Light\Action\Authenticate\Authenticate_First_Step;
use TwoFAS\Light\Action\Authenticate\Authentication_Input;
use TwoFAS\Light\Exception\Login_Token_Invalid_Exception;
use TwoFAS\Light\Login_Token\Login_Token_Manager;
use TwoFAS\Light\Result\HTML_Consumer;
use TwoFAS\Light\Result\Request_Not_Handled_Consumer;

class SSO_Login_Interceptor implements HTML_Consumer, Request_Not_Handled_Consumer {
	
	/** @var Authenticate_First_Step */
	private $first_step;
	
	/** @var Login_Token_Manager */
	private $jetpack_token_manager;
	
	/** @var Authentication_Input */
	private $authentication_input;
	
	/** @var Jetpack_User_Data */
	private $jetpack_user_data;
	
	/**
	 * @param Authenticate_First_Step $first_step
	 * @param Login_Token_Manager     $jetpack_token_manager
	 * @param Authentication_Input    $authentication_input
	 * @param Jetpack_User_Data       $jetpack_user_data
	 */
	public function __construct(
		Authenticate_First_Step $first_step,
		Login_Token_Manager $jetpack_token_manager,
		Authentication_Input $authentication_input,
		Jetpack_User_Data $jetpack_user_data
	) {
		$this->first_step            = $first_step;
		$this->jetpack_token_manager = $jetpack_token_manager;
		$this->authentication_input  = $authentication_input;
		$this->jetpack_user_data     = $jetpack_user_data;
	}
	
	public function intercept_if_necessary() {
		if ( $this->has_user_authenticated_with_jetpack_and_2fas_light_second_step() ) {
			$this->delete_token();
			
			return;
		}
		
		if ( $this->jetpack_user_data->has_two_factor_enabled() ) {
			return;
		}
		
		$this->first_step->authenticate()->feed_consumer( $this );
	}
	
	/**
	 * @param string $html
	 */
	public function consume_html( $html ) {
		echo $html;
		exit;
	}
	
	public function consume_request_not_handled() {
	}
	
	/**
	 * @return bool
	 */
	private function has_user_authenticated_with_jetpack_and_2fas_light_second_step() {
		try {
			$token = $this->jetpack_token_manager->get_token_by_cookie();
			
			return $token->get_user()->get_id() === $this->authentication_input->get()->ID;
		} catch ( Login_Token_Invalid_Exception $e ) {
			return false;
		}
	}
	
	private function delete_token() {
		try {
			$token = $this->jetpack_token_manager->get_token_by_cookie();
			$this->jetpack_token_manager->delete_meta_and_cookie_for_user( $token->get_user() );
		} catch ( Login_Token_Invalid_Exception $e ) {
			return;
		}
	}
}
