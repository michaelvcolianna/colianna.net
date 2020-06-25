<?php

namespace TwoFAS\Light\Result;

interface HTML_Consumer {
	
	/**
	 * @param string $html
	 */
	public function consume_html( $html );
}
