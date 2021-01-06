<?php

use TwoFAS\Light\Core\Uninstaller;

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

require_once 'vendor/autoload.php';
require_once 'constants.php';
require_once 'dependencies.php';

/** @var Uninstaller $uninstaller */
$uninstaller = $twofas_container->get( Uninstaller::class );
$uninstaller->uninstall();
