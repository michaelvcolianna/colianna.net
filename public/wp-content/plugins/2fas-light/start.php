<?php

use TwoFAS\Light\Core\Plugin;
use TwoFAS\Light\Listeners\Listener_Provider;
use TwoFAS\Light\Requirements\Requirement_Checker;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param array $messages
 *
 * @return string
 */
function twofas_light_admin_notices( array $messages ) {
	$requirements = '';
	foreach ( $messages as $message ) {
		$requirements .= '<li>' . wp_kses( $message, [ 'strong' => [] ] ) . '</li>';
	}
	
	return '
		<div class="error notice twofas-light-error-message">
		    <p><strong>2FAS Light plugin requirements error</strong></p>
		    <ul class="twofas-light-error-list">
		        ' . $requirements . '
		    </ul>
		    <p>
		        Plugin functionality cannot be enabled until this problem is solved.
		        Please ask your hosting provider to support 2FAS Light plugin\'s requirements.
		    </p>
		</div>
		';
}

if ( PHP_MAJOR_VERSION < 7 ) {
	add_action( 'admin_notices', function () {
		$messages = [ sprintf(
			/* translators: %s: Minimum PHP version */
			__( '2FAS plugin does not support your PHP version. Minimum required version is %s.', '2fas-light' ),
			'7.0' )
		];
		
		echo twofas_light_admin_notices( $messages );
	} );
	
	return;
}

require_once TWOFAS_LIGHT_PLUGIN_PATH . 'vendor/autoload.php';
require_once TWOFAS_LIGHT_PLUGIN_PATH . 'dependencies.php';

/** @var Requirement_Checker $requirement_checker */
$requirement_checker = $twofas_container->get( Requirement_Checker::class );

if ( $requirement_checker->are_satisfied() ) {
	
	/** @var Listener_Provider $listener */
	$listener = $twofas_container->get( Listener_Provider::class );
	$listener->listen();
	
	/** @var Plugin $plugin */
	$plugin = $twofas_container->get( Plugin::class );
	$plugin->run();
} else {
	$is_admin = current_user_can( 'manage_options' );
	
	if ( ! $is_admin ) {
		return;
	}
	
	add_action( 'admin_notices', function () use ( $requirement_checker ) {
		echo twofas_light_admin_notices( $requirement_checker->get_not_satisfied() );
	} );
}
