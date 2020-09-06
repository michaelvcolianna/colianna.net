<?php

namespace TwoFAS\Light\Cookie;

use TwoFAS\Light\Time\Time;

class Cookie {
	
	const TIME_DIFF_FOR_DELETION = 3600;
	
	/** @var Cookie_Config */
	private $config;
	
	/** @var Cookie_Writer */
	private $cookie_writer;
	
	/** @var Time */
	private $time;
	
	/**
	 * @return Cookie
	 */
	public static function create() {
		$config_factory = new Cookie_Config_Factory();
		$config         = $config_factory->create();
		$writer         = new Cookie_Writer();
		$time           = new Time();
		
		return new self( $config, $writer, $time );
	}
	
	/**
	 * @param Cookie_Config $config
	 * @param Cookie_Writer $cookie_writer
	 * @param Time          $time
	 */
	public function __construct( Cookie_Config $config, Cookie_Writer $cookie_writer, Time $time ) {
		$this->config        = $config;
		$this->cookie_writer = $cookie_writer;
		$this->time          = $time;
	}
	
	/**
	 * @param string $name
	 * @param string $value
	 * @param int    $expires
	 * @param bool   $httponly
	 */
	public function set_cookie( $name, $value = '', $expires = 0, $httponly = false ) {
		$this->set_cookie_path_cookie( $name, $value, $expires, $httponly );
		
		if ( $this->config->get_site_cookie_path() !== $this->config->get_cookie_path() ) {
			$this->set_site_cookie_path_cookie( $name, $value, $expires, $httponly );
		}
	}
	
	/**
	 * @param string $name
	 */
	public function delete_cookie( $name ) {
		$time = $this->time->get_current_timestamp_minus_seconds( self::TIME_DIFF_FOR_DELETION );
		
		$this->set_cookie( $name, '', $time );
	}
	
	/**
	 * @param string $name
	 */
	public function delete_hostonly_cookie( $name ) {
		$time = $this->time->get_current_timestamp_minus_seconds( self::TIME_DIFF_FOR_DELETION );
		
		$this->set_hostonly_cookie( $name, '', $time, false );
	}
	
	/**
	 * @param string $name
	 *
	 * @return string|null
	 */
	public function get_cookie_value( $name ) {
		return ! empty( $_COOKIE[ $name ] ) ? $_COOKIE[ $name ] : null;
	}
	
	/**
	 * @param string $name
	 * @param string $value
	 * @param int    $expires
	 * @param bool   $httponly
	 */
	private function set_cookie_path_cookie( $name, $value, $expires, $httponly ) {
		$this->cookie_writer->set_cookie(
			$name,
			$value,
			$expires,
			$this->config->get_cookie_path(),
			$this->config->get_domain(),
			$httponly
		);
	}
	
	/**
	 * @param string $name
	 * @param string $value
	 * @param int    $expires
	 * @param bool   $httponly
	 */
	private function set_site_cookie_path_cookie( $name, $value, $expires, $httponly ) {
		$this->cookie_writer->set_cookie(
			$name,
			$value,
			$expires,
			$this->config->get_site_cookie_path(),
			$this->config->get_domain(),
			$httponly
		);
	}
	
	/**
	 * @param string $name
	 * @param string $value
	 * @param int    $expires
	 * @param bool   $httponly
	 */
	private function set_hostonly_cookie( $name, $value, $expires, $httponly ) {
		$this->cookie_writer->set_cookie( $name, $value, $expires, '/', '', $httponly );
	}
}
