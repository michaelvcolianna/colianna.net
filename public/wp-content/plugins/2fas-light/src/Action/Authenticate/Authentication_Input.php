<?php

namespace TwoFAS\Light\Action\Authenticate;

use WP_Error;
use WP_User;

class Authentication_Input {
	
	/** @var WP_User|WP_Error|null */
	private $authenticate_input;
	
	/**
	 * @param WP_User|WP_Error|null $authenticate_filter_input Variable passed to the "authenticate" filter by WP.
	 */
	public function __construct( $authenticate_filter_input ) {
		$this->authenticate_input = $authenticate_filter_input;
	}
	
	/**
	 * @return WP_User|WP_Error|null
	 */
	public function get() {
		return $this->authenticate_input;
	}
}
