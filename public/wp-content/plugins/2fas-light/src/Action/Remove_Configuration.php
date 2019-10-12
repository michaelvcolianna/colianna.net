<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Result\Result_Redirect;
use TwoFAS\Light\App;

class Remove_Configuration extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return Result_Redirect
	 */
	public function handle( App $app ) {
		if ( ! $this->is_nonce_valid( $app ) ) {
			return new Result_Redirect( $this->get_main_page_url() );
		}
		
		$user = $app->get_user();
		$user->remove_totp_status();
		$user->remove_totp_secret();
		$app->get_trusted_device_manager( $user )->delete_all();
		
		return new Result_Redirect( $this->get_main_page_url() );
	}
	
	/**
	 * @param App $app
	 *
	 * @return bool
	 */
	private function is_nonce_valid( App $app ) {
		$request = $app->get_request();
		
		return false !== wp_verify_nonce( $request->get_nonce(), $request->get_action() );
	}
	
	/**
	 * @todo move to url helper? router?
	 * @todo - instead of _, inconsistent
	 *
	 * @return string
	 */
	private function get_main_page_url() {
		$url = admin_url( 'admin.php' );
		$url = add_query_arg( 'page', 'twofas-light-menu', $url );
		
		return $url;
	}
}
