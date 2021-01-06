<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use TwoFAS\Light\Http\Middleware\Middleware_Bag;
use TwoFAS\Light\Http\{Cookie, Route, Request};
use TwoFAS\Light\Http\Middleware\{Check_Ajax, Check_Nonce, Check_Totp_Enabled, Check_Totp_Configured};
use WhichBrowser\Parser;

return [
	Cookie::class         => DI\create()
		->constructor( $_COOKIE ),
	Request::class        => DI\create( TwoFAS\Light\Http\Request::class )
		->constructor(
			$_GET,
			$_POST,
			$_SERVER,
			DI\get( Cookie::class )
		),
	Route::class          => DI\create()
		->constructor(
			DI\get( Request::class ),
			DI\get( 'routes' )
		),
	Parser::class         => DI\factory( function ( ContainerInterface $c ) {
		return new Parser( $c->get( Request::class )->header( 'HTTP_USER_AGENT' ) );
	} ),
	Middleware_Bag::class => DI\factory( function ( ContainerInterface $c ) {
		$middleware_bag = new Middleware_Bag();

		$middleware_bag->add_middleware( 'ajax', $c->get( Check_Ajax::class ) );
		$middleware_bag->add_middleware( 'nonce', $c->get( Check_Nonce::class ) );
		$middleware_bag->add_middleware( 'totp_enabled', $c->get( Check_Totp_Enabled::class ) );
		$middleware_bag->add_middleware( 'totp_configured', $c->get( Check_Totp_Configured::class ) );

		return $middleware_bag;
	} )
];
