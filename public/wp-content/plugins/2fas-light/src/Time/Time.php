<?php

namespace TwoFAS\Light\Time;

use DateTime;
use DateTimeZone;
use Exception;
use TwoFAS\Light\Exception\DateTime_Creation_Exception;

class Time {

	/**
	 * @return int UNIX timestamp since UNIX epoch (in GMT).
	 */
	public function get_current_timestamp() {
		return time();
	}

	/**
	 * @return DateTime A DateTime object for current time with timezone set to the timezone value in WP options.
	 * @throws DateTime_Creation_Exception
	 */
	public function get_current_datetime() {
		try {
			return new DateTime( 'now', $this->create_datetimezone_from_wp_timezone_setting() );
		} catch ( Exception $e ) {
			throw new DateTime_Creation_Exception( $e );
		}
	}

	/**
	 * @param int $timestamp
	 *
	 * @return DateTime A DateTime object for a given timestamp with timezone set to the timezone value in WP options.
	 * @throws DateTime_Creation_Exception
	 */
	public function get_datetime_for_timestamp( $timestamp ) {
		try {
			$datetime = new DateTime( '@' . $timestamp );
			$datetime->setTimezone( $this->create_datetimezone_from_wp_timezone_setting() );
		} catch ( Exception $e ) {
			throw new DateTime_Creation_Exception( $e );
		}

		return $datetime;
	}

	/**
	 * @param int $timestamp
	 *
	 * @return string Returns date and time as string formatted according to WP configuration.
	 * @throws DateTime_Creation_Exception
	 */
	public function format_to_string_using_wp_settings( $timestamp ) {
		$format   = sprintf( '%s %s', get_option( 'date_format' ), get_option( 'time_format' ) );
		$datetime = $this->get_datetime_for_timestamp( $timestamp );

		return $datetime->format( $format );
	}

	/**
	 * @param int $seconds
	 *
	 * @return int
	 */
	public function get_current_timestamp_plus_seconds( $seconds ) {
		return $this->get_current_timestamp() + $seconds;
	}

	/**
	 * @param int $seconds
	 *
	 * @return int
	 */
	public function get_current_timestamp_minus_seconds( $seconds ) {
		return $this->get_current_timestamp() - $seconds;
	}

	/**
	 * Adapted from https://github.com/Rarst/wpdatetime
	 *
	 * @return DateTimeZone
	 * @throws Exception
	 */
	private function create_datetimezone_from_wp_timezone_setting() {
		$timezone_string = get_option( 'timezone_string' );
		
		if ( ! empty( $timezone_string ) ) {
			return new DateTimeZone( $timezone_string );
		}
		
		$offset  = get_option( 'gmt_offset' );
		$hours   = (int) $offset;
		$minutes = ( $offset - floor( $offset ) ) * 60;
		$offset  = sprintf( '%+03d:%02d', $hours, $minutes );
		
		return new DateTimeZone( $offset );
	}
}
