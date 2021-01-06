<?php
declare(strict_types=1);

namespace TwoFAS\Light\Http;

class Redirect_Response {

	/**
	 * @var URL_Interface
	 */
	protected $url;
	
	public function __construct( URL_Interface $url ) {
		$this->url = $url;
	}

	public function redirect() {
		header( 'Location: ' . $this->url->get() );
		exit;
	}
}
