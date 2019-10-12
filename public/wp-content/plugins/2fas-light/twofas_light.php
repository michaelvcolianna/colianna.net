<?php
/**
 * Plugin Name: 2FAS Light — Google Authenticator
 * Plugin URI:  https://wordpress.org/plugins/2fas-light/
 * Description: Free, simple, token-based authentication (Google Authenticator) for your WordPress. No registration needed.
 * Version:     1.2.0
 * Author:      Two Factor Authentication Service Inc.
 * Author URI:  https://2fas.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network:     true
 */

defined( 'ABSPATH' ) or die();

require_once plugin_dir_path( __FILE__ ) . 'global_class_loader.php';

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

$plugin_url     = plugins_url( '', __FILE__ );
$templates_path = plugin_dir_path( __FILE__ ) . 'includes/view';

define( 'TWOFAS_LIGHT_URL', $plugin_url );
define( 'TWOFAS_LIGHT_WP_ADMIN_PATH', get_admin_url() );
define( 'TWOFAS_LIGHT_TEMPLATES_PATH', $templates_path );
define( 'TWOFAS_LIGHT_PLUGIN_VERSION', '1.2.0' );
define( 'TWOFAS_LIGHT_PLUGIN_FILE', __FILE__ );

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
	$versions_provider   = new TwoFASLight_System_Versions_Provider();
	$requirements_spec   = new TwoFASLight_Requirements_Spec( '5.3', '3.6', array( 'gd', 'mbstring', 'openssl' ) );
	$system_requirements = new TwoFASLight_System_Requirements_Checker( $versions_provider, $requirements_spec );
	
	try {
		$system_requirements->check_system_requirements();
	} catch ( TwoFASLight_Unmet_System_Requirements_Exception $e ) {
		twofas_light_enqueue_unmet_requirements_error( $e );
		twofas_light_enqueue_unmet_requirements_login_prevention();
		
		return;
	}
	
	require 'twofas_light_init.php';
	twofas_light_bind_to_wp_hooks();
}

function twofas_light_enqueue_unmet_requirements_error( TwoFASLight_Unmet_System_Requirements_Exception $e ) {
	$error_printer = new TwoFASLight_Unmet_Requirements_Error_Printer( $e );
	add_action( 'admin_notices', array( $error_printer, 'print_error' ) );
}

function twofas_light_enqueue_unmet_requirements_login_prevention() {
	if ( defined( 'TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG' ) ) {
		return;
	}
	
	$login_preventer_setup = new TwoFASLight_Login_Preventer_Setup();
	$login_preventer_setup->bind_to_hooks();
}
