<?php

namespace TwoFAS\Light\Network;

use TwoFAS\Light\Exception\Plugin_Not_Active_Network_Wide_Exception;
use TwoFAS\Light\Exception\Plugin_Not_Active_On_All_Multinetwork_Sites_Exception;
use TwoFAS\Light\Exception\Plugin_Not_Active_On_All_Multisite_Sites_Exception;

class Network_Setup_Validator {
	
	const CAPABILITY_REQUIRED_TO_SEE_NOTIFICATION = 'activate_plugins';
	
	/**
	 * @throws Plugin_Not_Active_On_All_Multinetwork_Sites_Exception
	 * @throws Plugin_Not_Active_On_All_Multisite_Sites_Exception
	 */
	public function validate() {
		if ( ! is_multisite() || ! current_user_can( self::CAPABILITY_REQUIRED_TO_SEE_NOTIFICATION ) ) {
			return;
		}
		
		if ( $this->is_multinetwork_installation() ) {
			$this->validate_multinetwork_setup();
		} else {
			$this->validate_multisite_setup();
		}
	}
	
	/**
	 * @return bool
	 */
	private function is_multinetwork_installation() {
		$network_count = get_networks( array( 'count' => true ) );
		return $network_count > 1;
	}
	
	/**
	 * @throws Plugin_Not_Active_On_All_Multinetwork_Sites_Exception
	 */
	private function validate_multinetwork_setup() {
		try {
			$this->validate_plugin_is_active_network_wide_on_all_networks();
		} catch ( Plugin_Not_Active_Network_Wide_Exception $e ) {
			throw new Plugin_Not_Active_On_All_Multinetwork_Sites_Exception();
		}
	}
	
	/**
	 * @throws Plugin_Not_Active_On_All_Multisite_Sites_Exception
	 */
	private function validate_multisite_setup() {
		try {
			$this->validate_plugin_is_active_network_wide_on_current_network();
		} catch ( Plugin_Not_Active_Network_Wide_Exception $e ) {
			throw new Plugin_Not_Active_On_All_Multisite_Sites_Exception();
		}
	}
	
	/**
	 * @throws Plugin_Not_Active_Network_Wide_Exception
	 */
	private function validate_plugin_is_active_network_wide_on_all_networks() {
		foreach ( get_networks() as $network ) {
			$this->validate_plugin_is_active_network_wide_on_network( $network->id );
		}
	}
	
	/**
	 * @throws Plugin_Not_Active_Network_Wide_Exception
	 */
	private function validate_plugin_is_active_network_wide_on_current_network() {
		$this->validate_plugin_is_active_network_wide_on_network( null );
	}
	
	/**
	 * @param int|null $network_id
	 *
	 * @throws Plugin_Not_Active_Network_Wide_Exception
	 */
	private function validate_plugin_is_active_network_wide_on_network( $network_id = null ) {
		$network_activated_plugins = array_keys( get_network_option( $network_id, 'active_sitewide_plugins' ) );
		$plugin_file_path = plugin_basename( TWOFAS_LIGHT_PLUGIN_FILE );
		if ( ! in_array( $plugin_file_path, $network_activated_plugins, true ) ) {
			throw new Plugin_Not_Active_Network_Wide_Exception();
		}
	}
}
