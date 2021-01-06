<?php
declare(strict_types=1);

namespace TwoFAS\Light\Events;

use TwoFAS\Light\Http\View_Response;

class View_Response_Created implements Event_Interface {

	/**
	 * @var View_Response
	 */
	private $response;

	/**
	 * @param View_Response $response
	 */
	public function __construct( View_Response $response ) {
		$this->response = $response;
	}

	/**
	 * @return View_Response
	 */
	public function get_response() {
		return $this->response;
	}
}
