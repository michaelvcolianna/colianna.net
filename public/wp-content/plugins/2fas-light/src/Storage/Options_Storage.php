<?php
declare(strict_types=1);

namespace TwoFAS\Light\Storage;

class Options_Storage {
	
	const TWOFAS_PLUGIN_VERSION = 'twofas_light_plugin_version';
	
	/**
	 * @var array
	 */
	private $wp_options = [
		'twofas_light_plugin_version',
	];
	
	/**
	 * @return string|false
	 */
	public function get_twofas_light_plugin_version() {
		return get_option( self::TWOFAS_PLUGIN_VERSION );
	}
	
	public function set_twofas_light_plugin_version( string $version ) {
		update_option( self::TWOFAS_PLUGIN_VERSION, $version );
	}
	
	public function delete_wp_options() {
		foreach ( $this->wp_options as $option_name ) {
			delete_option( $option_name );
		}
	}
}
