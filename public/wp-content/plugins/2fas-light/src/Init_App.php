<?php

namespace TwoFAS\Light;

use TwoFAS\Light\Menu\Menu;
use TwoFAS\Light\Request\Regular_Request;
use TwoFAS\Light\Result\HTML_Consumer;
use TwoFAS\Light\Result\Redirect_Consumer;

class Init_App extends App implements HTML_Consumer, Redirect_Consumer {
	
	public function run() {
		$this->request = new Regular_Request();
		$this->request->fill_with_context( $this->request_context );
		
		//  Pass Request to Router
		$action = $this->router->get_action( $this->request );
		
		//  Execute Action
		$result = $action->handle( $this );
		$result->feed_consumer( $this );
	}
	
	/**
	 * @param $html
	 */
	public function consume_html( $html ) {
		$menu = new Menu();
		$menu->run( $html );
	}
	
	/**
	 * @param string $url
	 */
	public function consume_redirect( $url ) {
		header( "Location: {$url}" );
		exit;
	}
}
