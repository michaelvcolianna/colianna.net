<?php

namespace TwoFAS\Light\Action\Authenticate;

use TwoFAS\Light\Result\Result_Error;
use TwoFASLight_Error_Factory;

class Step_Token_Error_Result_Factory {
	
	/** @var TwoFASLight_Error_Factory */
	private $error_factory;
	
	/**
	 * @param TwoFASLight_Error_Factory $error_factory
	 */
	public function __construct( TwoFASLight_Error_Factory $error_factory ) {
		$this->error_factory = $error_factory;
	}
	
	/**
	 * @return Result_Error
	 */
	public function create_invalid_step_token_result() {
		$wp_error = $this->error_factory->create_wp_error(
			'twofas-invalid-step-token',
			'2FAS Light session expired or is invalid, please log in again.'
		);
		
		return new Result_Error( $wp_error );
	}
}
