<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\App;

class TOTP_Enable_Disable extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return Result_JSON
	 */
	public function handle( App $app ) {
		$user               = $app->get_user();
		$is_totp_configured = $user->is_totp_configured();
		
		$result = 'error';
		
		if ( $is_totp_configured && $user->is_totp_enabled() ) {
			$user->disable_totp();
			$result = 'success';
		} elseif ( $is_totp_configured && ! $user->is_totp_enabled() ) {
			$user->enable_totp();
			$result = 'success';
		}
		
		return new Result_JSON( array(
			'twofas_light_result'      => $result,
			'twofas_light_totp_status' => $user->get_totp_status()
		) );
	}
}
