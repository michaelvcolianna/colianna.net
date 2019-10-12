<?php

namespace TwoFAS\Light\Exception;

use Exception;

class DateTime_Creation_Exception extends TwoFASLight_Exception {
	
	/**
	 * @param Exception $previous
	 */
	public function __construct( Exception $previous ) {
		parent::__construct( '', 0, $previous );
	}
}
