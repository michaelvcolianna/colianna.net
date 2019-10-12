<?php

namespace TwoFAS\Light\Result;

interface Redirect_Consumer {
	
	/**
	 * @param string $url
	 */
	public function consume_redirect( $url );
}
