<?php

namespace TwoFAS\Light\Result;

class Result_JSON {
	
	/**
	 * @var string
	 */
	private $json;
	
	/**
	 * Result_JSON constructor.
	 *
	 * @param array $array
	 */
	public function __construct( array $array ) {
		$this->json = json_encode( $array );
	}
	
	/**
	 * @param JSON_Consumer $consumer
	 */
	public function feed_consumer( JSON_Consumer $consumer ) {
		$consumer->consume_json( $this->json );
	}
	
	/**
	 * @return string
	 */
	public function get_json() {
		return $this->json;
	}
}
