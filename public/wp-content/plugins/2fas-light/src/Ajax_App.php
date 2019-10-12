<?php

namespace TwoFAS\Light;

use TwoFAS\Light\Request\Ajax_Request;
use TwoFAS\Light\Result\JSON_Consumer;

class Ajax_App extends App implements JSON_Consumer {
	
	public function run() {
		$this->request = new Ajax_Request();
		$this->request->fill_with_context( $this->request_context );
		
		// Verify nonce
		check_ajax_referer( 'twofas_light_ajax', 'security' );
		
		//  Pass Request to Router
		$action = $this->router->get_action( $this->request );
		
		//  Execute Action
		$result = $action->handle( $this );
		$result->feed_consumer( $this );
	}
	
	/**
	 * @param $json
	 */
	public function consume_json( $json ) {
		wp_send_json( $json );
	}
}
