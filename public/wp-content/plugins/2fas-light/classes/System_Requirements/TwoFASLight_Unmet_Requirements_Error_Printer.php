<?php

class TwoFASLight_Unmet_Requirements_Error_Printer {
	
	/** @var TwoFASLight_Unmet_System_Requirements_Exception */
	private $exception;
	
	/**
	 * TwoFASLight_Unmet_Requirements_Error_Printer constructor.
	 *
	 * @param TwoFASLight_Unmet_System_Requirements_Exception $exception
	 */
	public function __construct( TwoFASLight_Unmet_System_Requirements_Exception $exception ) {
		$this->exception = $exception;
	}
	
	public function print_error() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		
		$error_messages = $this->exception->get_error_messages();
		require plugin_dir_path( __FILE__ ) . '../../includes/view/system_requirements_error.php';
	}
}
