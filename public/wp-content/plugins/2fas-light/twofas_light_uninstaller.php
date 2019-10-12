<?php

class TwoFASLight_Uninstaller {
	
	public function uninstall() {
		$this->clear_wp_usermeta();
		$this->clear_wp_options();
		$this->clear_trusted_device_cookies();
	}
	
	private function clear_wp_usermeta() {
		$user_meta = array(
			'twofas_light_totp_secret',
			'twofas_light_totp_secret_update_date',
			'twofas_light_step_token',
			'twofas_light_totp_status',
			'twofas_light_trusted_devices',
			'twofas_light_failed_logins_count',
			'twofas_light_user_blocked_until',
			'twofas_light_hid_rate_plugin_prompt',
			'twofas_light_rate_prompt_countdown_start',
		);
		
		$users = get_users();
		
		foreach ( $users as $user ) {
			foreach ( $user_meta as $meta_key ) {
				delete_user_meta( $user->ID, $meta_key );
			}
		}
	}
	
	private function clear_wp_options() {
		if ( is_multisite() ) {
			$this->clear_wp_options_on_multisite_install();
		} else {
			$this->clear_wp_options_on_single_site_install();
		}
	}
	
	private function clear_wp_options_on_multisite_install() {
		foreach ( get_sites( array( 'number' => '' ) ) as $site ) {
			delete_blog_option( $site->blog_id, 'twofas_light_plugin_version' );
		}
	}
	
	private function clear_wp_options_on_single_site_install() {
		delete_option( 'twofas_light_plugin_version' );
	}
	
	private function clear_trusted_device_cookies() {
		global $_COOKIE;
		$cookies = isset( $_COOKIE ) && is_array( $_COOKIE ) ? $_COOKIE : array();
		foreach ( array_keys( $cookies ) as $cookie_name ) {
			if ( $this->is_cookie_for_trusted_device( $cookie_name ) ) {
				$this->delete_cookie( $cookie_name );
			}
		}
	}
	
	/**
	 * @param string $cookie_name
	 *
	 * @return bool
	 */
	private function is_cookie_for_trusted_device( $cookie_name ) {
		return preg_match( '/^TWOFAS_LIGHT_TRUSTED_DEVICE_.*/', $cookie_name ) === 1;
	}
	
	private function delete_cookie( $cookie_name ) {
		$time = time() - 3600;
		setcookie( $cookie_name, '', $time, '/', '', false, true );
	}
}
