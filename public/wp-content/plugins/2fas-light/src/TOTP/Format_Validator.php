<?php

namespace TwoFAS\Light\TOTP;

use TwoFAS\Light\Exception\Invalid_TOTP_Secret;

class Format_Validator {
	
	/**
	 * @param string $secret
	 *
	 * @throws Invalid_TOTP_Secret
	 */
	public function validate_secret_format( $secret ) {
		if ( ! is_string( $secret ) || preg_match( '/^[A-Z0-9]{16}$/', $secret ) !== 1 ) {
			throw new Invalid_TOTP_Secret();
		}
	}
}
