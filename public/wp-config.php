<?php

require dirname( __DIR__ ) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create( dirname( __DIR__ ) );
$dotenv->load();

require dirname( __DIR__ ) . '/wp-config.php';
