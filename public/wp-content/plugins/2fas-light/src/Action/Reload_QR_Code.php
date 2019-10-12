<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\App;

class Reload_QR_Code extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return Result_JSON
	 */
	public function handle( App $app ) {
		$totp_secret_generator = $app->get_totp_secret_generator();
		$totp_qr_generator     = $app->get_totp_qr_generator();
		$totp_secret           = $totp_secret_generator->generate_totp_secret();
		$qr_code               = $totp_qr_generator->generate_qr_code( $totp_secret );
		
		return new Result_JSON( array(
			'twofas_light_totp_secret' => $totp_secret,
			'twofas_light_qr_code'     => $qr_code
		) );
	}
}
