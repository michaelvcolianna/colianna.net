<?php

class TwoFASLight_System_Versions_Provider {
	
	/**
	 * @return string
	 */
	public function get_php_version() {
		return phpversion();
	}
	
	/**
	 * @return string
	 */
	public function get_wp_version() {
		return get_bloginfo( 'version' );
	}
	
	/**
	 * @param string $extension
	 *
	 * @return bool
	 */
	public function is_php_extension_loaded( $extension ) {
		return extension_loaded( $extension );
	}
}
