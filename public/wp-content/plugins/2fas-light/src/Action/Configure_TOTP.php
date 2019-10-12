<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Exception\Invalid_TOTP_Secret;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Format;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Supplied;
use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\TOTP\Code_Validator;
use TwoFAS\Light\App;

class Configure_TOTP extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return Result_JSON
	 */
	public function handle( App $app ) {
		$user    = $app->get_user();
		$request = $app->get_request();
		
		$new_totp_secret     = $request->get_from_post( 'twofas_light_totp_secret' );
		$new_totp_token      = $request->get_from_post( 'twofas_light_totp_token' );
		$totp_code_validator = $app->get_totp_code_validator( $new_totp_secret );
		
		$result = 'error';
		
		if ( $this->is_code_valid( $totp_code_validator, $new_totp_token ) ) {
			$old_totp_secret = $user->get_totp_secret();
			$user->set_totp_secret( $new_totp_secret );
			$user->enable_totp();
			$result = 'success';
			
			if ( $new_totp_secret !== $old_totp_secret ) {
				$app->get_trusted_device_manager( $user )->delete_all();
			}
		}
		
		$trusted_devices_template = $app->get_view_renderer()->render( 'includes/trusted_devices.html.twig', array(
			'trusted_devices' => $app->get_user()->get_user_trusted_devices()
		) );
		
		return new Result_JSON( array(
			'twofas_light_totp_secret'     => $new_totp_secret,
			'twofas_light_totp_token'      => $new_totp_token,
			'twofas_light_result'          => $result,
			'twofas_light_trusted_devices' => $trusted_devices_template
		) );
	}
	
	private function is_code_valid( Code_Validator $totp_code_validator, $totp_token ) {
		try {
			$totp_code_validator->validate_code( $totp_token );
		} catch ( Invalid_TOTP_Token_Format $e ) {
			return false;
		} catch ( Invalid_TOTP_Secret $e ) {
			return false;
		} catch ( Invalid_TOTP_Token_Supplied $e ) {
			return false;
		}
		
		return true;
	}
}
