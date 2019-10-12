<?php

namespace TwoFAS\Light;

use TwoFAS\Light\Action\Login;
use TwoFAS\Light\Request\Regular_Request;

class Login_App extends App {
	
	public function run() {
		$this->request = new Regular_Request();
		$this->request->fill_with_context( $this->request_context );
		
		$action = new Login();
		$action->handle( $this );
	}
}
