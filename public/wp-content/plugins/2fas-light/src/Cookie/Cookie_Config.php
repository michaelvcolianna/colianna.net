<?php

namespace TwoFAS\Light\Cookie;

class Cookie_Config {
	
	/** @var string */
	private $domain;
	
	/** @var string */
	private $cookie_path;
	
	/** @var string */
	private $site_cookie_path;
	
	/**
	 * @param string $cookie_domain
	 * @param string $cookie_path
	 * @param string $site_cookie_path
	 */
	public function __construct( $cookie_domain, $cookie_path, $site_cookie_path ) {
		$this->domain           = $cookie_domain;
		$this->cookie_path      = $cookie_path;
		$this->site_cookie_path = $site_cookie_path;
	}
	
	/**
	 * @return string
	 */
	public function get_domain() {
		return $this->domain;
	}
	
	/**
	 * @return string
	 */
	public function get_cookie_path() {
		return $this->cookie_path;
	}
	
	/**
	 * @return string
	 */
	public function get_site_cookie_path() {
		return $this->site_cookie_path;
	}
}
