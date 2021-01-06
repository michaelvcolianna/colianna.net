<?php
declare( strict_types=1 );

use Psr\Container\ContainerInterface;
use TwoFAS\Light\Events\{
	Second_Step_Rendered,
	Totp_Configuration_Completed,
	View_Response_Created,
	Standard_Login_Completed,
	Trusted_Device_Login_Completed
};
use TwoFAS\Light\Listeners\{
	Add_View_Response,
	Delete_Trusted_Devices,
	Enable_Totp_For_User,
	Listener_Provider,
	Resolve_Conflicting_Scripts,
	Update_Secret_Date,
	Authenticate_User_Fully,
	Update_Trusted_Device_Login_Time
};

return [
	'events'                 => [
		Totp_Configuration_Completed::class => [
			Delete_Trusted_Devices::class,
			Enable_Totp_For_User::class,
			Update_Secret_Date::class,
		],
		View_Response_Created::class        => [
			Add_View_Response::class
		],
		Second_Step_Rendered::class         => [
			Resolve_Conflicting_Scripts::class
		],
		Standard_Login_Completed::class => [
			Authenticate_User_Fully::class
		],
		Trusted_Device_Login_Completed::class => [
			Authenticate_User_Fully::class,
			Update_Trusted_Device_Login_Time::class
		]
	],
	Listener_Provider::class => DI\factory(
		function ( ContainerInterface $c ) {
			$listener_provider = new Listener_Provider( $c );
			$listener_provider->add_events( $c->get( 'events' ) );
			
			return $listener_provider;
		} )
];
