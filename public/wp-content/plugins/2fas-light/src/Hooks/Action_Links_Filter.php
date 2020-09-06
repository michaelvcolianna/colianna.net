<?php

namespace TwoFAS\Light\Hooks;

class Action_Links_Filter {
	
	public function register_hook() {
		add_filter( 'plugin_action_links_' . TWOFAS_LIGHT_PLUGIN_BASENAME, [ $this, 'add_settings_link' ] );
	}
	
	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function add_settings_link( array $links ) {
		$link     = $this->create_link();
		$settings = [ 'settings' => $link ];
		
		return array_merge( $settings, $links );
	}
	
	/**
	 * @return string
	 */
	private function create_link() {
		$url = get_admin_url() . 'admin.php?page=twofas-light-menu';
		
		return '<a href="' . $url . '">Settings</a>';
	}
}
