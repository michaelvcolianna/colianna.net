<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


require dirname( __DIR__ ) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create( dirname( __DIR__ ) );
$dotenv->load();

require dirname( __DIR__ ) . '/wp-config.php';
