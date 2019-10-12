<?php

namespace TwoFAS\Light\Cookie;

class Cookie_Config_Factory {
	
	/**
	 * @return Cookie_Config
	 */
	public function create() {
		return new Cookie_Config( COOKIE_DOMAIN, COOKIEPATH, SITECOOKIEPATH );
	}
}
