<?php

final class TwoFASLight_Requirements_Spec {
	
	/** @var string */
	private $minimum_php_version;
	
	/** @var string */
	private $minimum_wp_version;
	
	/** @var array */
	private $required_php_extensions;
	
	/**
	 * TwoFASLight_Requirements_Spec constructor.
	 *
	 * @param string $php_version
	 * @param string $wp_version
	 * @param array  $required_php_extensions
	 */
	public function __construct( $php_version, $wp_version, array $required_php_extensions ) {
		$this->minimum_php_version     = $php_version;
		$this->minimum_wp_version      = $wp_version;
		$this->required_php_extensions = $required_php_extensions;
	}
	
	/**
	 * @return string
	 */
	public function get_minimum_php_version() {
		return $this->minimum_php_version;
	}
	
	/**
	 * @return string
	 */
	public function get_minimum_wp_version() {
		return $this->minimum_wp_version;
	}
	
	/**
	 * @return array
	 */
	public function get_required_php_extensions() {
		return $this->required_php_extensions;
	}
}
