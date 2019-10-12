<?php

namespace TwoFAS\Light\Login;

use TwoFAS\Light\Request\Request;

class Login_Redirector {
	
	const LOGIN_REDIRECT_FLAG = 'twofas_light_login_redirect';
	
	/** @var Current_Path_Checker */
	private $current_path_checker;
	
	/** @var Login_Params_Mapper */
	private $login_params_mapper;
	
	/** @var Request */
	private $request;
	
	/**
	 * @param Current_Path_Checker $current_path_checker
	 * @param Login_Params_Mapper  $login_params
	 * @param Request              $request
	 */
	public function __construct( Current_Path_Checker $current_path_checker, Login_Params_Mapper $login_params, Request $request ) {
		$this->current_path_checker = $current_path_checker;
		$this->login_params_mapper  = $login_params;
		$this->request              = $request;
	}
	
	/**
	 * @return bool
	 */
	public function is_current_page_standard_wp_login_page() {
		return $this->current_path_checker->is_current_path( 'wp-login.php' );
	}
	
	/**
	 * @return bool
	 */
	public function was_redirected_to_login_page() {
		if ( $this->request->is_post_request() ) {
			$was_redirected = $this->request->get_from_post( self::LOGIN_REDIRECT_FLAG );
		} else {
			$was_redirected = $this->request->get_from_get( self::LOGIN_REDIRECT_FLAG );
		}
		
		return '1' === $was_redirected;
	}
	
	public function redirect_to_wp_login_page() {
		$query_args = array_merge(
			array( 'redirect_to' => rawurlencode( site_url( $this->request->get_from_server( 'REQUEST_URI' ) ) ) ),
			$this->login_params_mapper->map_from_post_for_query_string(),
			array( self::LOGIN_REDIRECT_FLAG => 1 )
		);
		$login_form_action_url = esc_url( site_url( 'wp-login.php', 'login_post' ) );
		wp_safe_redirect( add_query_arg( $query_args, $login_form_action_url ) );
		exit;
	}
}
