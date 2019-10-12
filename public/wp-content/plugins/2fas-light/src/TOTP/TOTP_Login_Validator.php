<?php

namespace TwoFAS\Light\TOTP;

use TwoFAS\Light\Exception\Empty_TOTP_Token_Exception;
use TwoFAS\Light\Exception\Invalid_TOTP_Secret;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Format;
use TwoFAS\Light\Exception\Invalid_TOTP_Token_Supplied;
use TwoFAS\Light\Exception\Non_String_TOTP_Token_Exception;
use TwoFAS\Light\Exception\Validation_Exception;
use TwoFAS\Light\App;
use TwoFAS\Light\User\User;
use TwoFAS\Light\User\User_Blocker;

class TOTP_Login_Validator {
	
	/**
	 * @param App  $app
	 * @param User $authenticating_user
	 *
	 * @throws Validation_Exception
	 */
	public function validate( App $app, User $authenticating_user ) {
		$request        = $app->get_request();
		$user_blocker   = new User_Blocker( $app->get_time(), $authenticating_user );
		$code_validator = $app->get_totp_code_validator( $authenticating_user->get_totp_secret() );
		
		//  If valid step and totp token are supplied,
		$totp_token = $request->get_from_post( 'twofas_light_totp_token' );
		
		try {
			$code_validator->validate_code( $totp_token );
		} catch ( Non_String_TOTP_Token_Exception $e ) {
			throw new Validation_Exception();
		} catch ( Empty_TOTP_Token_Exception $e ) {
			throw new Validation_Exception( 'Token cannot be empty' );
		} catch ( Invalid_TOTP_Token_Format $e ) {
			throw new Validation_Exception( 'Token is not in a valid format' );
		} catch ( Invalid_TOTP_Secret $e ) {
			$this->handle_invalid_token( $user_blocker );
		} catch ( Invalid_TOTP_Token_Supplied $e ) {
			$this->handle_invalid_token( $user_blocker );
		}
		
		if ( $user_blocker->is_blocked() ) {
			throw new Validation_Exception( 'Your account is temporarily blocked' );
		}
		
		$user_blocker->handle_successful_login();
	}
	
	/**
	 * @param User_Blocker $user_blocker
	 *
	 * @throws Validation_Exception
	 */
	private function handle_invalid_token( User_Blocker $user_blocker ) {
		$user_blocker->handle_failed_login();
		throw new Validation_Exception( 'Token is invalid' );
	}
}
