<?php
/**
 * Plugin Name:       2FAS Light — Google Authenticator
 * Plugin URI:        https://wordpress.org/plugins/2fas-light/
 * Description:       Free, simple, token-based authentication (Google Authenticator) for your WordPress. No registration needed.
 * Version:           3.0.1
 * Requires PHP:      7.0
 * Requires at least: 4.9
 * Author:            Two Factor Authentication Service Inc.
 * Author URI:        https://2fas.com
 * License:           GPL2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Network:           true
 */

defined( 'ABSPATH' ) or die();

function twofas_light_start() {
	require_once 'constants.php';
	require_once 'start.php';
}

function twofas_light_delete_cron_jobs() {
	wp_clear_scheduled_hook( 'twofas_light_delete_expired_sessions' );
}

register_deactivation_hook( __FILE__, 'twofas_light_delete_cron_jobs' );

add_action( 'init', 'twofas_light_start' );
