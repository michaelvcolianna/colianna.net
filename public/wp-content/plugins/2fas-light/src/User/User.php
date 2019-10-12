<?php

namespace TwoFAS\Light\User;

use DateTime;
use TwoFAS\Light\Device\Trusted_Device;
use TwoFAS\Light\Exception\Rate_Plugin_Countdown_Never_Started_Exception;

class User {
	
	const TOTP_SECRET = 'twofas_light_totp_secret';
	const TOTP_SECRET_UPDATE_DATE = 'twofas_light_totp_secret_update_date';
	const STEP_TOKEN = 'twofas_light_step_token';
	const TOTP_STATUS = 'twofas_light_totp_status';
	const TOTP_STATUS_ENABLED = 'totp_enabled';
	const TOTP_STATUS_DISABLED = 'totp_disabled';
	const TRUSTED_DEVICES = 'twofas_light_trusted_devices';
	const FAILED_LOGINS_COUNT = 'twofas_light_failed_logins_count';
	const USER_BLOCKED_UNTIL = 'twofas_light_user_blocked_until';
	const USER_HID_RATE_PLUGIN_PROMPT = 'twofas_light_hid_rate_plugin_prompt';
	const RATE_PROMPT_COUNTDOWN_START_FIELD_NAME = 'twofas_light_rate_prompt_countdown_start';
	
	/**
	 * @var
	 */
	private $id;
	
	/**
	 * @param string $user_login
	 *
	 * @return null|User
	 */
	public static function get_user_by_login( $user_login ) {
		$wp_user = get_user_by( 'login', $user_login );
		
		if ( ! $wp_user ) {
			return null;
		}
		
		return new self( $wp_user->ID );
	}
	
	/**
	 * User constructor.
	 *
	 * @param $wp_user_id
	 */
	public function __construct( $wp_user_id ) {
		$this->id = $wp_user_id;
	}
	
	/**
	 * @param $id
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}
	
	/**
	 * @return mixed
	 */
	public function get_id() {
		return $this->id;
	}
	
	/**
	 * @return array
	 */
	public function get_user_trusted_devices() {
		return $this->get_user_field( self::TRUSTED_DEVICES, array() );
	}
	
	/**
	 * @return bool
	 */
	public function has_trusted_device() {
		return count( $this->get_user_trusted_devices() ) > 0;
	}
	
	public function remove_trusted_devices() {
		$this->save_user_field( self::TRUSTED_DEVICES, array() );
	}
	
	/**
	 * @param string $device_id
	 *
	 * @return bool
	 */
	public function remove_trusted_device( $device_id ) {
		$devices = $this->get_user_trusted_devices();
		
		if ( array_key_exists( $device_id, $devices ) ) {
			unset( $devices[ $device_id ] );
			$this->save_user_field( self::TRUSTED_DEVICES, $devices );
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * @param Trusted_Device $trusted_device
	 */
	public function save_user_trusted_device( Trusted_Device $trusted_device ) {
		$devices = $this->get_user_trusted_devices();
		
		$device = array(
			'device_key' => $trusted_device->get_device_key(),
			'ip'         => $trusted_device->get_ip(),
			'user_agent' => $trusted_device->get_user_agent(),
			'timestamp'  => $trusted_device->get_timestamp()
		);
		
		$devices[ $trusted_device->get_device_id() ] = $device;
		
		$this->save_user_field( self::TRUSTED_DEVICES, $devices );
	}
	
	/**
	 * @param      $field_name
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	public function get_user_field( $field_name, $default = null ) {
		$result = get_user_meta( $this->id, $field_name, true );
		
		return $result ? $result : $default;
	}
	
	/**
	 * @param $field_name
	 * @param $field_value
	 */
	public function save_user_field( $field_name, $field_value ) {
		update_user_meta( $this->id, $field_name, $field_value );
	}
	
	/**
	 * @param $field_name
	 */
	public function remove_user_field( $field_name ) {
		delete_user_meta( $this->id, $field_name );
	}
	
	/**
	 * @return string|null
	 */
	public function get_email() {
		$userdata = get_userdata( $this->id );
		
		return $userdata ? $userdata->user_email : null;
	}
	
	/**
	 * @return string|null
	 */
	public function get_login() {
		$userdata = get_userdata( $this->id );
		
		return $userdata ? $userdata->user_login : null;
	}
	
	/**
	 * @param $step_token
	 */
	public function set_step_token( $step_token ) {
		update_user_meta( $this->id, self::STEP_TOKEN, $step_token );
	}
	
	public function enable_totp() {
		update_user_meta( $this->id, self::TOTP_STATUS, self::TOTP_STATUS_ENABLED );
	}
	
	/**
	 * @return bool
	 */
	public function is_totp_configured() {
		return get_user_meta( $this->id, self::TOTP_SECRET, true ) && true;
	}
	
	/**
	 * @return bool
	 */
	public function is_totp_enabled() {
		return $this->get_totp_status() === self::TOTP_STATUS_ENABLED;
	}
	
	/**
	 * @return mixed
	 */
	public function get_totp_status() {
		return get_user_meta( $this->id, self::TOTP_STATUS, true );
	}
	
	public function disable_totp() {
		update_user_meta( $this->id, self::TOTP_STATUS, self::TOTP_STATUS_DISABLED );
	}
	
	public function remove_totp_status() {
		$this->remove_user_field( self::TOTP_STATUS );
	}
	
	/**
	 * @return mixed
	 */
	public function get_totp_secret() {
		return get_user_meta( $this->id, self::TOTP_SECRET, true );
	}
	
	/**
	 * @return DateTime|null
	 */
	public function get_totp_secret_update_date() {
		$date = get_user_meta( $this->id, self::TOTP_SECRET_UPDATE_DATE, true );
		if ( empty( $date ) ) {
			return null;
		}
		$datetime = DateTime::createFromFormat( DateTime::ISO8601, $date );
		return ( $datetime instanceof DateTime ) ? $datetime : null;
	}
	
	/**
	 * @param string   $totp_secret
	 * @param DateTime $date_time
	 */
	public function set_totp_secret( $totp_secret, DateTime $date_time ) {
		$date = $date_time->format( DateTime::ISO8601 );
		update_user_meta( $this->id, self::TOTP_SECRET, $totp_secret );
		update_user_meta( $this->id, self::TOTP_SECRET_UPDATE_DATE, $date );
	}
	
	public function remove_totp_secret() {
		$this->remove_user_field( self::TOTP_SECRET );
		$this->remove_user_field( self::TOTP_SECRET_UPDATE_DATE );
	}
	
	/**
	 * @return bool
	 */
	public function is_rate_plugin_prompt_hidden() {
		return (bool) $this->get_user_field( self::USER_HID_RATE_PLUGIN_PROMPT, 0 );
	}
	
	public function set_rate_plugin_prompt_hidden() {
		$this->save_user_field( self::USER_HID_RATE_PLUGIN_PROMPT, 1 );
	}
	
	/**
	 * @return int
	 * @throws Rate_Plugin_Countdown_Never_Started_Exception
	 */
	public function get_rate_prompt_countdown_start_timestamp() {
		$countdown_start_timestamp = $this->get_user_field( self::RATE_PROMPT_COUNTDOWN_START_FIELD_NAME );
		
		if ( null === $countdown_start_timestamp || ! ctype_digit( $countdown_start_timestamp ) ) {
			throw new Rate_Plugin_Countdown_Never_Started_Exception();
		}
		
		return $countdown_start_timestamp;
	}
	
	/**
	 * @param DateTime $date
	 */
	public function update_rate_prompt_countdown_start_date( DateTime $date ) {
		$this->save_user_field( self::RATE_PROMPT_COUNTDOWN_START_FIELD_NAME, $date->getTimestamp() );
	}
}
