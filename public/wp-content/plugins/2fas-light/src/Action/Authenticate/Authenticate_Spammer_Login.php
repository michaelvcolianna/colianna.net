<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\Result\Result_Request_Not_Handled;

class Authenticate_Spammer_Login implements Authentication_Strategy {
	
	/**
	 * @return Result_Request_Not_Handled
	 */
	public function authenticate() {
		return new Result_Request_Not_Handled();
	}
}
