<?php
declare(strict_types=1);

namespace TwoFAS\Light\Helpers;

use TwoFAS\Light\Events\Event_Interface;

class Dispatcher {

	/**
	 * @param Event_Interface $event
	 */
	public static function dispatch( Event_Interface $event ) {
		do_action( get_class( $event ), $event );
	}
}
