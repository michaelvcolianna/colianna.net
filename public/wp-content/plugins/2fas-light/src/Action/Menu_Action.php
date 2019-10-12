<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\App;
use TwoFAS\Light\User\User;

class Menu_Action extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return Result_HTML
	 */
	public function handle( App $app ) {
		$totp_qr_generator     = $app->get_totp_qr_generator();
		$totp_secret_generator = $app->get_totp_secret_generator();
		$user                  = $app->get_user();
		$rate_plugin_prompt    = $app->get_rate_plugin_prompt();
		
		if ( ! $user->is_totp_configured() ) {
			$totp_secret = $totp_secret_generator->generate_totp_secret();
		} else {
			$totp_secret = $user->get_totp_secret();
		}
		
		$qr_code = $totp_qr_generator->generate_qr_code( $totp_secret );
		
		$html = $app->get_view_renderer()->render( 'plugin_main_page.html.twig', array(
			'qr_code'                              => $qr_code,
			'totp_secret'                          => $totp_secret,
			'twofas_light_user_is_configured'      => $user->is_totp_configured(),
			'twofas_light_user_configuration_date' => $this->get_totp_secret_update_timestamp( $user ),
			'twofas_light_menu_page'               => Router::TWOFASLIGHT_ADMIN_PAGE_SLUG,
			User::TOTP_STATUS                      => $user->get_totp_status(),
			'trusted_devices'                      => $user->get_user_trusted_devices(),
			'remove_configuration_url'             => $this->get_remove_configuration_url(),
			'remove_configuration_nonce'           => $this->get_remove_configuration_nonce(),
			'display_rate_plugin_prompt'           => $rate_plugin_prompt->should_display(),
		) );
		
		return new Result_HTML( $html );
	}
	
	/**
	 * @param User $user
	 *
	 * @return int|null
	 */
	private function get_totp_secret_update_timestamp( User $user ) {
		$totp_secret_update_date = $user->get_totp_secret_update_date();
		if ( null !== $totp_secret_update_date ) {
			return $totp_secret_update_date->getTimestamp();
		}
		return null;
	}
	
	/**
	 * @return string
	 */
	private function get_remove_configuration_url() {
		return Router::get_action_url( Router::TWOFAS_ACTION_REMOVE_CONFIGURATION );
	}
	
	/**
	 * @return string
	 */
	private function get_remove_configuration_nonce() {
		return wp_nonce_field( Router::TWOFAS_ACTION_REMOVE_CONFIGURATION, '_wpnonce', true, false );
	}
}
