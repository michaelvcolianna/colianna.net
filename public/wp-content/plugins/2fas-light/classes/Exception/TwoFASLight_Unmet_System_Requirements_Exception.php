<?php

class TwoFASLight_Unmet_System_Requirements_Exception extends TwoFASLight_Exception {
	
	/** @var array */
	private $error_messages;
	
	/**
	 * TwoFASLight_Unmet_System_Requirements_Exception constructor.
	 *
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
