<?php

namespace TwoFAS\Light\Result;

interface HTML_Consumer {
	
	/**
	 * @param $html
	 */
	public function consume_html( $html );
}
