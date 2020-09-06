<?php

namespace TwoFAS\Light\Exception;

use Exception;

class DateTime_Creation_Exception extends Exception {
	
	/**
	 * @param TwoFAS_Light_Exception $previous
	 */
	public function __construct( Exception $previous ) {
		parent::__construct( '', 0, $previous );
	}
}
