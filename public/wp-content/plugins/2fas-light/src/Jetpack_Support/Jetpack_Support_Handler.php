<?php

namespace TwoFAS\Light\Jetpack_Support;

use TwoFAS\Light\Action\Authenticate\Authenticate_First_Step;
use TwoFAS\Light\Action\Authenticate\Authentication_Input;
use TwoFAS\Light\App;
use TwoFAS\Light\Login_Token\Login_Context;
use TwoFAS\Light\User\User;
use WP_User;

class Jetpack_Support_Handler {
	
	/** @var App */
	private $app;
	
	/** @var Script_Conflict_Resolver */
	private $script_conflict_resolver;
	
	/**
	 * @param App                      $app
	 * @param Script_Conflict_Resolver $script_conflict_resolver
	 */
	public function __construct( App $app, Script_Conflict_Resolver $script_conflict_resolver ) {
		$this->app                      = $app;
		$this->script_conflict_resolver = $script_conflict_resolver;
	}
	
	public function handle_jetpack_features() {
		$this->intercept_sso_logins();
		$this->script_conflict_resolver->resolve();
	}
	
	private function intercept_sso_logins() {
		add_action( 'jetpack_sso_handle_login', [ $this, 'intercept_jetpack_sso_login_if_necessary' ], 100, 2 );
	}
	
	/**
	 * @param WP_User|null|bool $wp_user
	 * @param object            $jetpack_user_data
	 */
	public function intercept_jetpack_sso_login_if_necessary( $wp_user, $jetpack_user_data ) {
		if ( ! ( $wp_user instanceof WP_User ) ) {
			return;
		}
		
		$wrapped_jetpack_user_data = new Jetpack_User_Data( $jetpack_user_data );
		$authentication_input      = new Authentication_Input( $wp_user );
		$user                      = new User( $authentication_input->get()->ID );
		$step_token_manager        = $this->app->get_step_token_manager();
		$step_token                = $step_token_manager->create( $user, Login_Context::JETPACK );
		$authenticate_strategy     = new Authenticate_First_Step( $this->app, $authentication_input, $step_token );
		
		$login_interceptor = $this->create_jetpack_login_interceptor(
			$authenticate_strategy,
			$authentication_input,
			$wrapped_jetpack_user_data
		);
		
		$login_interceptor->intercept_if_necessary();
	}
	
	/**
	 * @param Authenticate_First_Step $authentication_strategy
	 * @param Authentication_Input    $authentication_input
	 * @param Jetpack_User_Data       $jetpack_user_data
	 *
	 * @return SSO_Login_Interceptor
	 */
	private function create_jetpack_login_interceptor(
		Authenticate_First_Step $authentication_strategy,
		Authentication_Input $authentication_input,
		Jetpack_User_Data $jetpack_user_data
	) {
		return new SSO_Login_Interceptor(
			$authentication_strategy,
			$this->app->get_jetpack_login_token_manager(),
			$authentication_input,
			$jetpack_user_data
		);
	}
}
