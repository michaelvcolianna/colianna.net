<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\Result\Result_Error;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_Request_Not_Handled;
use TwoFAS\Light\Result\Result_User;

interface Authentication_Strategy {
	
	/**
	 * @return Result_User|Result_HTML|Result_Error|Result_Request_Not_Handled
	 */
	public function authenticate();
}
