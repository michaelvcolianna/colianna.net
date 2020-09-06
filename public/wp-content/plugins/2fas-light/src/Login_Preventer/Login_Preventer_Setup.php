<?php

namespace TwoFAS\Light\Login_Preventer;

use TwoFAS\Light\Error_Factory;
use WP_Error;
use WP_User;

class Login_Preventer_Setup {
	
	public function bind_to_hooks() {
		add_filter( 'authenticate', [ $this, 'prevent_logins_of_twofactor_users' ], 9000, 1 );
	}
	
	/**
	 * @param WP_User|WP_Error|null $authenticating_user
	 *
	 * @return WP_User|WP_Error|null
	 */
	public function prevent_logins_of_twofactor_users( $authenticating_user ) {
		$authentication_configuration_checker = new User_Authentication_Configuration_Checker();
		$error_factory                        = new Error_Factory();
		$login_preventer                      = new Login_Preventer(
			$authenticating_user,
			$authentication_configuration_checker,
			$error_factory
		);
		
		return $login_preventer->prevent_login_if_user_uses_twofactor_authentication();
	}
}
