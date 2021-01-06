<?php

use Psr\Container\ContainerInterface;
use TwoFAS\Light\Requirements\Requirement_Checker;
use TwoFAS\Light\Requirements\Checks\Full_Plugin_Active;
use TwoFAS\Light\Requirements\Extensions\{Curl, Gd, Gettext, MbString};
use TwoFAS\Light\Requirements\Versions\{PHP_Version, WP_Version};

return [
	Requirement_Checker::class => DI\factory(
		function ( ContainerInterface $c ) {
			$requirement_checker = new Requirement_Checker();
			$requirement_checker
				->add_requirement( $c->get( Curl::class ) )
				->add_requirement( $c->get( Gd::class ) )
				->add_requirement( $c->get( Gettext::class ) )
				->add_requirement( $c->get( MbString::class ) )
				->add_requirement( $c->get( PHP_Version::class ) )
				->add_requirement( $c->get( WP_Version::class ) )
				->add_requirement( $c->get( Full_Plugin_Active::class ) );
			
			return $requirement_checker;
		} )
];
