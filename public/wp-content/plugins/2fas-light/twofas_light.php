<?php
/**
 * Plugin Name:       2FAS Light — Google Authenticator
 * Plugin URI:        https://wordpress.org/plugins/2fas-light/
 * Description:       Free, simple, token-based authentication (Google Authenticator) for your WordPress. No registration needed.
 * Version:           2.0
 * Requires PHP:      5.6
 * Requires at least: 4.2
 * Author:            Two Factor Authentication Service Inc.
 * Author URI:        https://2fas.com
 * License:           GPL2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Network:           true
 */

defined( 'ABSPATH' ) or die();

//  Import application contexts
require_once __DIR__ . '/vendor/autoload.php';

use TwoFAS\Light\Exception\Unmet_System_Requirements_Exception;
use TwoFAS\Light\Login_Preventer\Login_Preventer_Setup;
use TwoFAS\Light\System_Requirements\Requirements_Spec;
use TwoFAS\Light\System_Requirements\System_Requirements_Checker;
use TwoFAS\Light\System_Requirements\System_Versions_Provider;
use TwoFAS\Light\System_Requirements\Unmet_Requirements_Error_Printer;

function is_full_twofas_plugin_active() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	
	$active_plugins = get_option( 'active_plugins' );
	$result         = false;
	
	foreach ( $active_plugins as $data ) {
		$result |= ( preg_match( '/\/twofas\.php/', $data ) === 1 );
	}
	
	return $result;
}

if ( is_full_twofas_plugin_active() ) {
	define( 'TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG', true );
	add_action( 'admin_notices', 'full_twofas_plugin_active_notice' );
}

function full_twofas_plugin_active_notice() {
	echo '<div class="notice is-dismissible notice-error error">'
	     . '<p>2FAS plugin has been found as active, therefore light version of the plugin is disabled.</p>'
	     . '<button class="notice-dismiss" type="button"></button>'
	     . '</div>';
}

define( 'TWOFAS_LIGHT_PLUGIN_VERSION', '2.0' );
define( 'TWOFAS_LIGHT_PLUGIN_FILE', __FILE__ );
define( 'TWOFAS_LIGHT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

twofas_light_bind_enqueue_styles();
twofas_light_check_system_requirements_and_init();

function twofas_light_bind_enqueue_styles() {
	add_action( 'login_enqueue_scripts', 'twofas_light_enqueue_styles' );
	add_action( 'admin_enqueue_scripts', 'twofas_light_enqueue_styles' );
}

function twofas_light_enqueue_styles() {
	wp_enqueue_style( 'twofas-light', TWOFAS_LIGHT_URL . '/includes/css/twofas_light.css', array(),
		TWOFAS_LIGHT_PLUGIN_VERSION );
	wp_enqueue_style( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto' );
}

function twofas_light_check_system_requirements_and_init() {
	$versions_provider   = new System_Versions_Provider();
	$requirements_spec   = new Requirements_Spec( '5.6', '4.2', [ 'gd', 'mbstring', 'openssl', 'json' ] );
	$system_requirements = new System_Requirements_Checker( $versions_provider, $requirements_spec );
	
	try {
		$system_requirements->check_system_requirements();
	} catch ( Unmet_System_Requirements_Exception $e ) {
		twofas_light_enqueue_unmet_requirements_error( $e );
		twofas_light_enqueue_unmet_requirements_login_prevention();
		
		return;
	}
	
	require 'twofas_light_init.php';
	twofas_light_bind_to_wp_hooks();
}

function twofas_light_enqueue_unmet_requirements_error( Unmet_System_Requirements_Exception $e ) {
	$error_printer = new Unmet_Requirements_Error_Printer( $e );
	add_action( 'admin_notices', array( $error_printer, 'print_error' ) );
}

function twofas_light_enqueue_unmet_requirements_login_prevention() {
	if ( defined( 'TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG' ) ) {
		return;
	}
	
	$login_preventer_setup = new Login_Preventer_Setup();
	$login_preventer_setup->bind_to_hooks();
}
