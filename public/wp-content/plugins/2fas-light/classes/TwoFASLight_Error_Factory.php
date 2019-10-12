<?php

class TwoFASLight_Error_Factory {
	
	/**
	 * @param string $error_code
	 * @param string $error_message
	 * @param mixed  $error_data
	 *
	 * @return WP_Error
	 */
	public function create_wp_error( $error_code = '', $error_message = '', $error_data = '' ) {
		return new WP_Error( $error_code, $error_message, $error_data );
	}
}
