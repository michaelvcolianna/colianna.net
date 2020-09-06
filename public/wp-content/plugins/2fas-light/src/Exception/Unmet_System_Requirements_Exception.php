<?php

namespace TwoFAS\Light\Exception;

class Unmet_System_Requirements_Exception extends TwoFAS_Light_Exception {
	
	/** @var array */
	private $error_messages;
	
	/**
	 * @param array $error_messages
	 */
	public function __construct( array $error_messages ) {
		parent::__construct( implode( ' ', $error_messages ) );
		
		$this->error_messages = $error_messages;
	}
	
	/**
	 * @return array
	 */
	public function get_error_messages() {
		return $this->error_messages;
	}
}
