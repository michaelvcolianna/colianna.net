<?php

namespace TwoFAS\Light\Request;

class Regular_Request extends Request {
	
	/**
	 * @var bool
	 */
	protected $is_ajax_request = false;
	
	/**
	 * @return mixed
	 */
	public function get_page() {
		return $this->get_from_get( 'page' );
	}
	
	/**
	 * @return mixed
	 */
	public function get_action() {
		return $this->get_from_get( 'twofas_light_action' );
	}
}
