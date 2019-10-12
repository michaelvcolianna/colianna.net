<?php

namespace TwoFAS\Light\Result;

interface JSON_Consumer {
	
	/**
	 * @param $json
	 */
	public function consume_json( $json );
}
