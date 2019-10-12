<?php

namespace TwoFAS\Light\Time;

use DateTime;
use DateTimeZone;

class Time {
	
	/**
	 * @return int UNIX timestamp since UNIX epoch (in GMT).
	 */
	public function get_current_time() {
		return time();
	}
	
	/**
	 * @return DateTime A DateTime object for current time with timezone set to the timezone value in WP options.
	 */
	public function get_current_datetime() {
		return new DateTime( 'now', $this->create_datetimezone_from_wp_timezone_option() );
	}
	
	/**
	 * @param int $timestamp
	 *
	 * @return DateTime A DateTime object for a given timestamp with timezone set to the timezone value in WP options.
	 */
	public function get_datetime_for_timestamp( $timestamp ) {
		$datetime = new DateTime( '@' . $timestamp );
		$datetime->setTimezone( $this->create_datetimezone_from_wp_timezone_option() );
		return $datetime;
	}
	
	/**
	 * @param int $timestamp
	 *
	 * @return string Returns date and time as string formatted according to WP configuration.
	 */
	public function format_to_string_using_wp_settings( $timestamp ) {
		$format = sprintf( '%s %s', get_option( 'date_format' ), get_option( 'time_format' ) );
		$datetime = $this->get_datetime_for_timestamp( $timestamp );
		return $datetime->format( $format );
	}
	
	/**
	 * @return DateTimeZone
	 */
	private function create_datetimezone_from_wp_timezone_option() {
		$timezone_string = get_option( 'timezone_string' );
		
		if ( empty( $timezone_string ) ) {
			$timezone_string = 'UTC';
		}
		
		return new DateTimeZone( $timezone_string );
	}
}
