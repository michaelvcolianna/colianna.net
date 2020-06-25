<?php

namespace TwoFAS\Light\Result;

class Result_HTML {
	
	/** @var string */
	private $html;
	
	/**
	 * Result_HTML constructor.
	 *
	 * @param string $html
	 */
	public function __construct( $html ) {
		$this->html = $html;
	}
	
	/**
	 * @param HTML_Consumer $consumer
	 */
	public function feed_consumer( HTML_Consumer $consumer ) {
		$consumer->consume_html( $this->html );
	}
}
