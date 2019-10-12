<?php

namespace TwoFAS\Light\Option;

class Option {
	
	const PLUGIN_VERSION_FIELD_NAME = 'twofas_light_plugin_version';
	
	/**
	 * @return string
	 */
	public function get_blog_name() {
		$blogname = $this->get_option( 'blogname', 'WordPress Account' );
		return wp_specialchars_decode( $blogname, ENT_QUOTES );
	}
	
	/**
	 * @return string
	 */
	public function get_network_name() {
		return get_current_site()->site_name;
	}
	
	/**
	 * @return string|null
	 */
	public function get_plugin_version() {
		return $this->get_option( self::PLUGIN_VERSION_FIELD_NAME );
	}
	
	/**
	 * @param string $new_version
	 *
	 * @return bool
	 */
	public function update_plugin_version( $new_version ) {
		return $this->set_option( self::PLUGIN_VERSION_FIELD_NAME, $new_version );
	}
	
	/**
	 * @param string $name
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	private function get_option( $name, $default = null ) {
		return get_option( $name, $default );
	}
	
	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return bool
	 */
	private function set_option( $name, $value ) {
		return update_option( $name, $value );
	}
}
