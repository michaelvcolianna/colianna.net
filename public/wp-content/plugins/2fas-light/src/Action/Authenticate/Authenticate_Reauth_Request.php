<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\Result\Result_Request_Not_Handled;
use TwoFAS\Light\Step_Token\Step_Token;

class Authenticate_Reauth_Request implements Authentication_Strategy {
	
	/** @var Step_Token */
	private $step_token;
	
	/**
	 * @param Step_Token $step_token
	 */
	public function __construct( Step_Token $step_token ) {
		$this->step_token = $step_token;
	}
	
	/**
	 * @return Result_Request_Not_Handled
	 */
	public function authenticate() {
		$this->step_token->delete_token_cookie();
		return new Result_Request_Not_Handled();
	}
}
