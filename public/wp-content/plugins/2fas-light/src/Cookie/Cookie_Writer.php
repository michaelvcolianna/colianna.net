<?php

namespace TwoFAS\Light\Cookie;

class Cookie_Writer {
	
	/**
	 * @param string $name
	 * @param string $value
	 * @param int    $expire
	 * @param string $path
	 * @param string $domain
	 * @param bool   $httponly
	 *
	 * @return bool
	 */
	public function set_cookie( $name, $value = '', $expire = 0, $path = '', $domain = '', $httponly = false ) {
		return setcookie( $name, $value, $expire, $path, $domain, false, $httponly );
	}
}
