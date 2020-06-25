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
		$this->clear_jetpack_token_cookie_if_exists();
	}

	private function clear_step_token_cookie_if_exists() {
		$step_token_manager = $this->app->get_step_token_manager();
		$step_token_manager->delete_cookie();
	}

	private function clear_jetpack_token_cookie_if_exists() {
		$jetpack_login_token_manager = $this->app->get_jetpack_login_token_manager();
		$jetpack_login_token_manager->delete_cookie();
	}
}
