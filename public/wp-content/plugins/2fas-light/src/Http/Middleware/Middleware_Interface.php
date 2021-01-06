<?php

namespace TwoFAS\Light\Http\Middleware;

use TwoFAS\Light\Http\JSON_Response;
use TwoFAS\Light\Http\Redirect_Response;
use TwoFAS\Light\Http\View_Response;

interface Middleware_Interface {

	/**
	 * @param Middleware_Interface $next
	 */
	public function add_next( Middleware_Interface $next );

	/**
	 * @return View_Response|Redirect_Response|JSON_Response
	 */
	public function handle();
}
