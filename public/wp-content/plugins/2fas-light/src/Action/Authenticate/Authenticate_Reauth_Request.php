<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\Login_Token\Login_Token_Manager;
use TwoFAS\Light\Result\Result_Request_Not_Handled;

class Authenticate_Reauth_Request implements Authentication_Strategy {
	
	/** @var Login_Token_Manager */
	private $step_token_manager;
	
	/**
	 * @param Login_Token_Manager $step_token_manager
	 */
	public function __construct( Login_Token_Manager $step_token_manager ) {
		$this->step_token_manager = $step_token_manager;
	}
	
	/**
	 * @return Result_Request_Not_Handled
	 */
	public function authenticate() {
		$this->step_token_manager->delete_cookie();
		
		return new Result_Request_Not_Handled();
	}
}
