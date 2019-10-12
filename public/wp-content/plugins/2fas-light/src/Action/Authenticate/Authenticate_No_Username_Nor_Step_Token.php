<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\App;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\Result\Result_Error;
use TwoFAS\Light\Result\Result_Request_Not_Handled;

class Authenticate_No_Username_Nor_Step_Token implements Authentication_Strategy {
	
	/** @var Request */
	private $request;
	
	/** @var Step_Token_Error_Result_Factory */
	private $step_token_error_result_factory;
	
	/**
	 * @param App                             $app
	 * @param Step_Token_Error_Result_Factory $step_token_error_result_factory
	 */
	public function __construct( App $app, Step_Token_Error_Result_Factory $step_token_error_result_factory ) {
		$this->request                         = $app->get_request();
		$this->step_token_error_result_factory = $step_token_error_result_factory;
	}
	
	/**
	 * @return Result_Error|Result_Request_Not_Handled
	 */
	public function authenticate() {
		if ( $this->is_totp_token_submitted() ) {
			return $this->step_token_error_result_factory->create_invalid_step_token_result();
		}
		
		return new Result_Request_Not_Handled();
	}
	
	/**
	 * @return bool
	 */
	private function is_totp_token_submitted() {
		return $this->request->get_from_post( 'twofas_light_totp_token' ) !== null;
	}
}
