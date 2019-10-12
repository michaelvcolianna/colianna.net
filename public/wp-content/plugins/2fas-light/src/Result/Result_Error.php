<?php

namespace TwoFAS\Light\Result;

class Result_Error {
	
	/**
	 * @var
	 */
	private $error;
	
	/**
	 * Result_Error constructor.
	 *
	 * @param $error
	 */
	public function __construct( $error ) {
		$this->error = $error;
	}
	
	/**
	 * @param Error_Consumer $consumer
	 *
	 * @return mixed
	 */
	public function feed_consumer( Error_Consumer $consumer ) {
		return $consumer->consume_error( $this->error );
	}
	
	/**
	 * @return mixed
	 */
	public function get_error() {
		return $this->error;
	}
}
