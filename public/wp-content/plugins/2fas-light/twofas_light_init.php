<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function twofas_light_bind_to_wp_hooks() {
	//  Add actions and filters
	add_action( 'login_enqueue_scripts', 'twofas_light_enqueue_scripts' );
	add_action( 'admin_enqueue_scripts', 'twofas_light_enqueue_scripts' );
	add_action( 'init', 'twofas_light_update_plugin_if_needed', 5 );
	add_action( 'init', 'twofas_light_init' );
	add_action( 'admin_init', 'twofas_light_network_setup_validation' );
	
	//  Turn off critical functionalities when full plugin is installed
	if ( ! defined( 'TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG' ) ) {
		add_action( 'login_form', 'twofas_light_login' );
		add_action( 'login_footer', 'twofas_light_login_footer' );
		add_action( 'wp_ajax_twofas_light_ajax', 'twofas_light_ajax' );
		add_filter( 'authenticate', 'twofas_light_authenticate', 100, 1 );
	}
}

//  Import application contexts
require_once( __DIR__ . '/vendor/autoload.php' );

use TwoFAS\Light\Action\Authenticate;
use TwoFAS\Light\Action\Authenticate\Authentication_Input;
use TwoFAS\Light\Action\Authenticate\Authentication_Strategy_Factory;
use TwoFAS\Light\Action\Router;
use TwoFAS\Light\Ajax_App;
use TwoFAS\Light\Authenticate_App;
use TwoFAS\Light\Generic_App;
use TwoFAS\Light\Init_App;
use TwoFAS\Light\Login_App;
use TwoFAS\Light\Exception\Plugin_Not_Active_On_All_Multinetwork_Sites_Exception;
use TwoFAS\Light\Exception\Plugin_Not_Active_On_All_Multisite_Sites_Exception;
use TwoFAS\Light\Network\Network_Setup_Warning_Printer;
use TwoFAS\Light\Network\Network_Setup_Validator;
use TwoFAS\Light\View\Login_Footer_Renderer;

function twofas_light_update_plugin_if_needed() {
	$app = new Generic_App();
	$app->run();
	$app->get_updater()->update_if_needed( TWOFAS_LIGHT_PLUGIN_VERSION );
}

//  Different application contexts
//  Doing it that way, in order to separate WP functions from plugin logic
function twofas_light_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'twofas-light-js', TWOFAS_LIGHT_URL . '/includes/js/twofas_light.js', array( 'jquery' ),
		TWOFAS_LIGHT_PLUGIN_VERSION, true );
	
	wp_localize_script( 'twofas-light-js', 'twofas_light', array(
		'ajax_url'               => admin_url( 'admin-ajax.php' ),
		'twofas_light_menu_page' => Router::TWOFASLIGHT_ADMIN_PAGE_SLUG
	) );
}

function twofas_light_login_footer() {
	$app = new Generic_App();
	$app->run();
	
	$login_footer_renderer = new Login_Footer_Renderer( $app->get_view_renderer(), $app->get_request() );
	$login_footer_renderer->render_footer();
}

function twofas_light_login() {
	$app = new Login_App();
	$app->run();
}

function twofas_light_init() {
	$app = new Init_App();
	$app->run();
}

function twofas_light_ajax() {
	$app = new Ajax_App();
	$app->run();
}

function twofas_light_network_setup_validation() {
	$app = new Generic_App();
	$app->run();
	
	$validator       = new Network_Setup_Validator();
	$warning_printer = new Network_Setup_Warning_Printer( $app->get_view_renderer() );
	
	try {
		$validator->validate();
	} catch ( Plugin_Not_Active_On_All_Multinetwork_Sites_Exception $e ) {
		$warning_printer->print_multinetwork_activation_warning();
	} catch ( Plugin_Not_Active_On_All_Multisite_Sites_Exception $e ) {
		$warning_printer->print_multisite_activation_warning();
	}
}

/**
 * @param WP_User|WP_Error|null $wp_user
 *
 * @return WP_User|WP_Error|null
 */
function twofas_light_authenticate( $wp_user ) {
	$authentication_input = new Authentication_Input( $wp_user );
	$strategy_factory = new Authentication_Strategy_Factory( $authentication_input );
	$action = new Authenticate( $strategy_factory );
	$app = new Authenticate_App( $action, $authentication_input );
	
	return $app->run();
}
