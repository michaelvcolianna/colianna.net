<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements\Checks;

use TwoFAS\Light\Requirements\Requirement;

class Full_Plugin_Active extends Requirement {
	
	/**
	 * @inheritDoc
	 */
	public function is_satisfied(): bool {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		
		$active_plugins = get_option( 'active_plugins' );
		$result         = false;

		foreach ( $active_plugins as $data ) {
			$result |= ( preg_match( '/\/twofas\.php/', $data ) === 1 );
		}
		
		return ! $result;
	}
	
	/**
	 * @inheritDoc
	 */
	public function get_message(): string {
		return '2FAS plugin has been found as active, therefore light version of the plugin is disabled.';
	}
}
