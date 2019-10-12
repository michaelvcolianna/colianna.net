<?php

namespace TwoFAS\Light\Result;

interface Error_Consumer {
	
	/**
	 * @param $error
	 *
	 * @return mixed
	 */
	public function consume_error( $error );
}
