<?php

namespace TwoFAS\Light\Result;

class Result_Redirect {
	
	/**
	 * @var string
	 */
	private $url;
	
	/**
	 * Result_Redirect constructor.
	 *
	 * @param string $url
	 */
	public function __construct( $url ) {
		$this->url = $url;
	}
	
	/**
	 * @param Redirect_Consumer $consumer
	 */
	public function feed_consumer( Redirect_Consumer $consumer ) {
		$consumer->consume_redirect( $this->url );
	}
}
