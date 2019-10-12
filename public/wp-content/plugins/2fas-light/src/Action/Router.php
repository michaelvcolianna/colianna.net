<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Request\Request;

class Router {
	
	const TWOFASLIGHT_ADMIN_PAGE_SLUG = 'twofas-light-menu';
	
	const TWOFAS_ACTION_DEFAULT = 'twofas-light-menu-display';
	const TWOFAS_ACTION_RELOAD_QR_CODE = 'twofas-light-reload-qr-code';
	const TWOFAS_ACTION_CONFIGURE_TOTP = 'twofas-light-configure-totp';
	const TWOFAS_ACTION_REMOVE_CONFIGURATION = 'twofas-light-remove-configuration';
	const TWOFAS_ACTION_TOTP_ENABLE_DISABLE = 'twofas-light-totp-enable-disable';
	const TWOFAS_ACTION_REMOVE_TRUSTED_DEVICE = 'twofas-light-remove-trusted-device';
	const TWOFAS_ACTION_HIDE_RATE_PLUGIN_PROMPT = 'twofas-light-hide-notice';
	const TWOFAS_ACTION_POSTPONE_RATE_PLUGIN_PROMPT = 'twofas-light-postpone-notice';
	
	/**
	 * @var array
	 */
	private $regular_actions = array(
		self::TWOFAS_ACTION_DEFAULT              => 'TwoFAS\Light\Action\Menu_Action',
		self::TWOFAS_ACTION_REMOVE_CONFIGURATION => 'TwoFAS\Light\Action\Remove_Configuration',
	);
	
	/**
	 * @var array
	 */
	private $ajax_actions = array(
		self::TWOFAS_ACTION_RELOAD_QR_CODE              => 'TwoFAS\Light\Action\Reload_QR_Code',
		self::TWOFAS_ACTION_CONFIGURE_TOTP              => 'TwoFAS\Light\Action\Configure_TOTP',
		self::TWOFAS_ACTION_TOTP_ENABLE_DISABLE         => 'TwoFAS\Light\Action\TOTP_Enable_Disable',
		self::TWOFAS_ACTION_REMOVE_TRUSTED_DEVICE       => 'TwoFAS\Light\Action\Remove_Trusted_Device',
		self::TWOFAS_ACTION_HIDE_RATE_PLUGIN_PROMPT     => 'TwoFAS\Light\Action\Hide_Rate_Plugin_Prompt',
		self::TWOFAS_ACTION_POSTPONE_RATE_PLUGIN_PROMPT => 'TwoFAS\Light\Action\Postpone_Rate_Plugin_Prompt',
	);
	
	/**
	 * @param Request $request
	 *
	 * @return Action
	 */
	public function get_action( Request $request ) {
		if ( ! $this->is_twofas_light_page_request( $request ) ) {
			return new Menu_Action();
		}
		
		return $this->create_action_from_action_slug( $request );
	}
	
	/**
	 * @param Request $request
	 *
	 * @return bool
	 */
	private function is_twofas_light_page_request( Request $request ) {
		return $request->get_page() === self::TWOFASLIGHT_ADMIN_PAGE_SLUG;
	}
	
	/**
	 * @param Request $request
	 *
	 * @return Menu_Action
	 */
	private function create_action_from_action_slug( Request $request ) {
		$action_map = $request->is_ajax_request() ? $this->ajax_actions : $this->regular_actions;
		$action_slug = $request->get_action();
		
		if ( isset( $action_map[ $action_slug ] ) ) {
			return new $action_map[ $action_slug ];
		}
		
		return new Menu_Action();
	}
	
	/**
	 * @param string $action
	 *
	 * @return string
	 */
	public static function get_action_url( $action ) {
		$url = admin_url( 'admin.php' );
		$url = add_query_arg( 'page', Router::TWOFASLIGHT_ADMIN_PAGE_SLUG, $url );
		$url = add_query_arg( 'twofas_light_action', $action, $url );
		
		return $url;
	}
}
