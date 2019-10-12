<?php

class TwoFASLight_Login_Preventer {
	
	const LOGIN_ERROR_CODE = 'twofas-light-twofactor-authentication-impossible';
	
	/** @var WP_User|WP_Error|null */
	private $authenticating_user;
	
	/** @var TwoFASLight_User_Authentication_Configuration_Checker */
	private $authentication_configuration_checker;
	
	/** @var TwoFASLight_Error_Factory */
	private $error_factory;
	
	/**
	 * TwoFASLight_Login_Preventer constructor.
	 *
	 * @param WP_User|WP_Error|null                                 $authenticating_user
	 * @param TwoFASLight_User_Authentication_Configuration_Checker $authentication_configuration_checker
	 * @param TwoFASLight_Error_Factory                             $error_factory
	 */
	public function __construct( $authenticating_user, $authentication_configuration_checker, $error_factory ) {
		$this->authenticating_user                  = $authenticating_user;
		$this->authentication_configuration_checker = $authentication_configuration_checker;
		$this->error_factory                        = $error_factory;
	}
	
	/**
	 * @return WP_User|WP_Error|null
	 */
	public function prevent_login_if_user_uses_twofactor_authentication() {
		if ( ! $this->is_authentication_successful_so_far() || ! $this->is_user_using_twofactor_authentication() ) {
			return $this->authenticating_user;
		}
		
		return $this->error_factory->create_wp_error( self::LOGIN_ERROR_CODE,
			'<strong>ERROR</strong>: It looks like you are using 2FAS Light authentication' .
			' but your server configuration has changed and does not allow to process your login request anymore.' .
			' Please adjust your server configuration to match the plugin\'s system requirements.' );
	}
	
	/**
	 * @return bool
	 */
	private function is_authentication_successful_so_far() {
		return $this->authenticating_user instanceof WP_User;
	}
	
	/**
	 * @return bool
	 */
	private function is_user_using_twofactor_authentication() {
		return $this->authentication_configuration_checker->is_user_using_twofactor_authentication( $this->authenticating_user->ID );
	}
}
