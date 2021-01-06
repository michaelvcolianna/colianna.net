<?php

namespace TwoFAS\Light\Http\Middleware;

use TwoFAS\Light\Http\Controller;
use TwoFAS\Light\Http\JSON_Response;
use TwoFAS\Light\Http\Redirect_Response;
use TwoFAS\Light\Http\Request;
use TwoFAS\Light\Http\View_Response;

class Create_Response extends Middleware {

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var Controller
	 */
	private $controller;

	/**
	 * @var string
	 */
	private $method;

	/**
	 * @param Request    $request
	 * @param Controller $controller
	 * @param string     $method
	 */
	public function __construct( Request $request, Controller $controller, $method ) {
		$this->request    = $request;
		$this->controller = $controller;
		$this->method     = $method;
	}

	/**
	 * @return JSON_Response|Redirect_Response|View_Response
	 */
	public function handle() {
		return $this->controller->{$this->method}( $this->request );
	}
}
