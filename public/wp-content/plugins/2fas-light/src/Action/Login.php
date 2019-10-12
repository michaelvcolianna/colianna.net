<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\App;

class Login extends Action {
	
	/** @var App */
	private $app;
	
	/**
	 * @param App $app
	 */
	public function handle( App $app ) {
		$this->app = $app;
		$this->clear_step_token_cookie_if_exists();
	}
	
	private function clear_step_token_cookie_if_exists() {
		$step_token = $this->app->get_step_token();
		
		if ( $step_token->get_token_cookie() ) {
			$step_token->delete_token_cookie();
		}
	}
}
