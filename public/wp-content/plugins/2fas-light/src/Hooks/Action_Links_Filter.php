<?php

namespace TwoFAS\Light\Hooks;

class Action_Links_Filter {
	
	public function register_hook() {
		add_filter( 'plugin_action_links_' . TWOFAS_LIGHT_PLUGIN_BASENAME, array( $this, 'add_settings_link' ) );
	}
	
	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function add_settings_link( array $links ) {
		$link     = $this->create_link();
		$settings = array( 'settings' => $link );
		
		return array_merge( $settings, $links );
	}
	
	/**
	 * @return string
	 */
	private function create_link() {
		$url  = get_admin_url() . 'admin.php?page=twofas-light-menu';
		$link = '<a href="' . $url . '">Settings</a>';
		
		return $link;
	}
}
