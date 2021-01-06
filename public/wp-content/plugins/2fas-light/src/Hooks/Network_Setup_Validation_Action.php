<?php
declare(strict_types=1);

namespace TwoFAS\Light\Hooks;

use TwoFAS\Light\Exceptions\Plugin_Not_Active_Network_Wide_Exception;
use TwoFAS\Light\Templates\Twig;

class Network_Setup_Validation_Action implements Hook_Interface {
	
	const CAPABILITY_REQUIRED_TO_SEE_NOTIFICATION = 'activate_plugins';
	
	/**
	 * @var Twig
	 */
	private $twig;
	
	/**
	 * @param Twig $twig
	 */
	public function __construct( Twig $twig ) {
		$this->twig = $twig;
	}
	
	public function register_hook() {
		add_action( 'admin_init', [ $this, 'validate' ] );
	}
	
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
	
	public function render_multinetwork_activation_warning() {
		echo $this->twig->render_view( 'local_activation_on_multinetwork_error.html.twig' );
	}
	
	public function render_multisite_activation_warning() {
		echo $this->twig->render_view( 'local_activation_on_multisite_error.html.twig' );
	}
	
	private function is_multinetwork_installation(): bool {
		$network_count = get_networks( [ 'count' => true ] );
		
		return $network_count > 1;
	}
	
	private function validate_multinetwork_setup() {
		try {
			foreach ( get_networks() as $network ) {
				$this->validate_plugin_is_active_network_wide_on_network( $network->id );
			}
		} catch ( Plugin_Not_Active_Network_Wide_Exception $e ) {
			$this->render_warning( [ $this, 'render_multinetwork_activation_warning' ] );
		}
	}
	
	private function validate_multisite_setup() {
		try {
			$this->validate_plugin_is_active_network_wide_on_network();
		} catch ( Plugin_Not_Active_Network_Wide_Exception $e ) {
			$this->render_warning( [ $this, 'render_multisite_activation_warning' ] );
		}
	}
	
	/**
	 * @param int|null $network_id
	 *
	 * @throws Plugin_Not_Active_Network_Wide_Exception
	 */
	private function validate_plugin_is_active_network_wide_on_network( $network_id = null ) {
		$network_activated_plugins = array_keys( get_network_option( $network_id, 'active_sitewide_plugins' ) );
		if ( ! in_array( TWOFAS_LIGHT_PLUGIN_BASENAME, $network_activated_plugins, true ) ) {
			throw new Plugin_Not_Active_Network_Wide_Exception();
		}
	}
	
	private function render_warning( callable $callback ) {
		add_action( 'admin_notices', $callback );
		add_action( 'network_admin_notices', $callback );
	}
}
