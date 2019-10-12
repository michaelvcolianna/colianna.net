<?php

namespace TwoFAS\Light\Request;

abstract class Request {
	
	/**
	 * @var Request_Context
	 */
	protected $request_context;
	
	/**
	 * @var bool
	 */
	protected $is_ajax_request;
	
	/**
	 * @var string
	 */
	const TWOFAS_LIGHT_REQUEST_METHOD = 'REQUEST_METHOD';
	
	/**
	 * @var string
	 */
	const TWOFAS_LIGHT_POST_REQUEST = 'POST';
	
	/**
	 * @var string
	 */
	const TWOFAS_LIGHT_GET_REQUEST = 'GET';
	
	/**
	 * @return mixed
	 */
	abstract public function get_page();
	
	/**
	 * @return mixed
	 */
	abstract public function get_action();
	
	/**
	 * @param Request_Context $request_context
	 */
	public function fill_with_context( Request_Context $request_context ) {
		$this->request_context = $request_context;
	}
	
	/**
	 * @return bool
	 */
	public function is_ajax_request() {
		return ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] )
		       && 'xmlhttprequest' === strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] )
		       && $this->is_ajax_request;
	}
	
	/**
	 * @return array|null|string
	 */
	public function get_nonce() {
		if ( $this->is_post_request() ) {
			return $this->get_from_post( '_wpnonce' );
		}
		
		return $this->get_from_get( '_wpnonce' );
	}
	
	/**
	 * @return string|null
	 */
	public function get_ip() {
		$headers = array(
			'X-Forwarded-For',
			'HTTP_X_FORWARDED_FOR',
			'REMOTE_ADDR'
		);
		
		foreach ( $headers as $header ) {
			$ip = explode( ',', $this->get_if_isset( $this->request_context->get_server(), $header ) );
			$ip = array_shift( $ip );
			
			if ( $this->validate_ip( $ip ) ) {
				return $ip;
			}
		}
		
		return null;
	}
	
	/**
	 * @return string
	 */
	public function get_user_agent() {
		return $this->get_if_isset( $this->request_context->get_server(), 'HTTP_USER_AGENT' );
	}
	
	/**
	 * @return int
	 */
	public function get_timestamp() {
		return current_time( 'timestamp', true );
	}
	
	/**
	 * @return bool
	 */
	public function is_post_request() {
		$request_method = $this->get_if_isset( $this->request_context->get_server(),
			self::TWOFAS_LIGHT_REQUEST_METHOD );
		
		return self::TWOFAS_LIGHT_POST_REQUEST === $request_method;
	}
	
	/**
	 * @return bool
	 */
	public function is_get_request() {
		$request_method = $this->get_if_isset( $this->request_context->get_server(),
			self::TWOFAS_LIGHT_REQUEST_METHOD );
		
		return self::TWOFAS_LIGHT_GET_REQUEST === $request_method;
	}
	
	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get_from_get( $key ) {
		return $this->get_if_isset( $this->request_context->get_get(), $key );
	}
	
	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get_from_post( $key ) {
		return $this->get_if_isset( $this->request_context->get_post(), $key );
	}
	
	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get_from_server( $key ) {
		return $this->get_if_isset( $this->request_context->get_server(), $key );
	}
	
	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get_from_cookie( $key ) {
		return $this->get_if_isset( $this->request_context->get_cookie(), $key );
	}
	
	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get_from_request( $key ) {
		return $this->get_if_isset( $this->request_context->get_request(), $key );
	}
	
	/**
	 * @param      $array
	 * @param      $key
	 * @param null $default
	 *
	 * @return mixed
	 */
	protected function get_if_isset( $array, $key, $default = null ) {
		if ( ! is_string( $key ) || ! isset( $array[ $key ] ) ) {
			return $default;
		}
		
		return $array[ $key ];
	}
	
	/**
	 * @param string $ip
	 *
	 * @return bool
	 */
	protected function validate_ip( $ip ) {
		return null !== $ip && filter_var( $ip, FILTER_VALIDATE_IP );
	}
}
