<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Device\Trusted_Device_Manager;
use TwoFAS\Light\Exception\Invalid_TOTP_Secret;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Format;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Supplied;
use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\Exception\DateTime_Creation_Exception;
use TwoFAS\Light\Time\Time;
use TwoFAS\Light\TOTP\Code_Validator;
use TwoFAS\Light\App;
use TwoFAS\Light\User\User;

class Configure_TOTP extends Action {
	
	/** @var User */
	private $user;
	
	/** @var Time */
	private $time;
	
	/** @var Trusted_Device_Manager */
	private $trusted_device_manager;
	
	/**
	 * @param App $app
	 *
	 * @return Result_JSON
	 */
	public function handle( App $app ) {
		$this->user                   = $app->get_user();
		$this->time                   = $app->get_time();
		$this->trusted_device_manager = $app->get_trusted_device_manager( $this->user );
		$request                      = $app->get_request();
		
		$new_totp_secret     = $request->get_from_post( 'twofas_light_totp_secret' );
		$new_totp_token      = $request->get_from_post( 'twofas_light_totp_token' );
		$totp_code_validator = $app->get_totp_code_validator( $new_totp_secret );
		
		$result = 'error';
		
		if ( $this->is_code_valid( $totp_code_validator, $new_totp_token ) ) {
			try {
				$this->configure_totp_for_user( $new_totp_secret );
				$result = 'success';
			} catch ( DateTime_Creation_Exception $e ) {
				$result = 'error';
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
	
	/**
	 * @param Code_Validator $totp_code_validator
	 * @param string         $totp_token
	 *
	 * @return bool
	 */
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
	
	/**
	 * @param string $new_totp_secret
	 *
	 * @throws DateTime_Creation_Exception
	 */
	private function configure_totp_for_user( $new_totp_secret ) {
		$old_totp_secret = $this->user->get_totp_secret();
		$this->user->set_totp_secret( $new_totp_secret, $this->time->get_current_datetime() );
		$this->user->enable_totp();
		
		if ( $new_totp_secret !== $old_totp_secret ) {
			$this->trusted_device_manager->delete_all();
		}
	}
}
