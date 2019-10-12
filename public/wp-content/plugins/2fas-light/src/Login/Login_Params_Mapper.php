<?php

namespace TwoFAS\Light\Login;

use TwoFAS\Light\Request\Request;

class Login_Params_Mapper {
	
	const STANDARD_WP_POST_LOGIN_PARAMS = array(
		'rememberme',
		'redirect_to',
		'testcookie',
		'interim-login',
		'customize-login',
	);
	
	const CUSTOM_WP_POST_LOGIN_PARAMS = array(
		Login_Redirector::LOGIN_REDIRECT_FLAG,
	);
	
	/** @var Request */
	private $request;
	
	/**
	 * @param Request $request
	 */
	public function __construct( Request $request ) {
		$this->request = $request;
	}
	
	/**
	 * @return (string|null)[]
	 */
	public function map_from_request_for_view() {
		$params_for_view = array();
		$param_names_to_map = array_merge( self::STANDARD_WP_POST_LOGIN_PARAMS, self::CUSTOM_WP_POST_LOGIN_PARAMS );
		foreach ( $param_names_to_map as $param_name ) {
			$param_name_for_view = str_replace( '-', '_', $param_name );
			$params_for_view[ $param_name_for_view ] = $this->get_login_param( $param_name );
		}
		return $params_for_view;
	}
	
	/**
	 * @return string[]
	 */
	public function map_from_post_for_query_string() {
		$query_args = $this->get_post_data_for_param_names( self::STANDARD_WP_POST_LOGIN_PARAMS );
		$query_args = array_filter( $query_args, array( $this, 'filter_query_arg' ) );
		return array_map( 'rawurlencode', $query_args );
	}
	
	/**
	 * @param string[] $param_names
	 *
	 * @return (string|null)[]
	 */
	private function get_post_data_for_param_names( array $param_names ) {
		$post_data = array();
		foreach ( $param_names as $param_name ) {
			$post_data[ $param_name ] = $this->request->get_from_post( $param_name );
		}
		return $post_data;
	}
	
	/**
	 * @param string|null $query_arg
	 *
	 * @return bool
	 */
	public function filter_query_arg( $query_arg ) {
		return null !== $query_arg;
	}
	
	/**
	 * @param string $param_name
	 *
	 * @return string|null
	 */
	private function get_login_param( $param_name ) {
		return $this->request->is_post_request() ? $this->request->get_from_post( $param_name ) : $this->request->get_from_get( $param_name );
	}
}
