<?php

class TwoFASLight_User_Authentication_Configuration_Checker {
	
	const TWOFAS_LIGHT_TOTP_SECRET = 'twofas_light_totp_secret';
	const TWOFAS_LIGHT_TOTP_STATUS = 'twofas_light_totp_status';
	const TWOFAS_LIGHT_TOTP_STATUS_ENABLED = 'totp_enabled';
	
	/**
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function is_user_using_twofactor_authentication( $user_id ) {
		return $this->is_totp_configured( $user_id ) && $this->is_totp_enabled( $user_id );
	}
	
	/**
	 * @param int $user_id
	 *
	 * @return bool
	 */
	private function is_totp_configured( $user_id ) {
		return (bool) get_user_meta( $user_id, self::TWOFAS_LIGHT_TOTP_SECRET, true );
	}
	
	/**
	 * @param int $user_id
	 *
	 * @return bool
	 */
	private function is_totp_enabled( $user_id ) {
		return get_user_meta( $user_id, self::TWOFAS_LIGHT_TOTP_STATUS, true ) === self::TWOFAS_LIGHT_TOTP_STATUS_ENABLED;
	}
}
