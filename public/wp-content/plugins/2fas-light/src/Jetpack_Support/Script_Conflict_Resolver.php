<?php

namespace TwoFAS\Light\Jetpack_Support;

use TwoFAS\Light\Login\Second_Step_Renderer;

class Script_Conflict_Resolver {
	
	const JETPACK_SSO_LOGIN_SCRIPT_HANDLE = 'jetpack-sso-login';
	const DEQUEUE_ACTION_PRIORITY         = 50;
	
	public function resolve() {
		add_action(
			Second_Step_Renderer::RENDERING_ACTION,
			[ $this, 'dequeue_conflicting_scripts_on_second_step_page' ]
		);
	}
	
	public function dequeue_conflicting_scripts_on_second_step_page() {
		add_action(
			'login_enqueue_scripts',
			[ $this, 'dequeue_sso_login_script' ],
			self::DEQUEUE_ACTION_PRIORITY
		);
	}
	
	public function dequeue_sso_login_script() {
		wp_dequeue_script( self::JETPACK_SSO_LOGIN_SCRIPT_HANDLE );
	}
}
