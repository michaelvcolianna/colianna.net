<?php

namespace TwoFAS\Light\User;

use TwoFAS\Light\Time\Time;

class User_Blocker {
	
	const TWOFAS_LIGHT_FAILED_LOGINS_COUNT = 'twofas_light_failed_logins_count';
	const TWOFAS_LIGHT_USER_BLOCKED_UNTIL = 'twofas_light_user_blocked_until';
	
	const TWOFAS_LIGHT_MAX_LOGINS_FAILED = 10;
	const TWOFAS_LIGHT_USER_BLOCK_PERIOD = 300;
	
	/** @var Time */
	private $time;
	
	/** @var User */
	private $user;
	
	/**
	 * User_Blocker constructor.
	 *
	 * @param Time $time
	 * @param User $user
	 */
	public function __construct( Time $time, User $user ) {
		$this->time = $time;
		$this->user = $user;
	}
	
	public function handle_failed_login() {
		if ( $this->is_blocked() ) {
			return;
		}
		
		$failed_login_count = $this->get_failed_logins_count();
		
		if ( $failed_login_count >= self::TWOFAS_LIGHT_MAX_LOGINS_FAILED ) {
			$this->block_user();
			$this->reset_failed_logins_count();
		} else {
			$this->increment_failed_logins_count();
		}
	}
	
	public function handle_successful_login() {
		$this->reset_failed_logins_count();
	}
	
	/**
	 * @return bool
	 */
	public function is_blocked() {
		return $this->time->get_current_time() <= $this->get_blocked_until();
	}
	
	private function block_user() {
		$block_expiry_time = $this->time->get_current_time() + self::TWOFAS_LIGHT_USER_BLOCK_PERIOD;
		$this->set_blocked_until( $block_expiry_time );
	}
	
	private function increment_failed_logins_count() {
		$count = $this->get_failed_logins_count();
		$this->set_failed_logins_count( $count + 1 );
	}
	
	private function reset_failed_logins_count() {
		$this->set_failed_logins_count( 0 );
	}
	
	/**
	 * @return int
	 */
	private function get_failed_logins_count() {
		$failed_logins_count = $this->user->get_user_field( self::TWOFAS_LIGHT_FAILED_LOGINS_COUNT, 0 );
		
		return intval( $failed_logins_count );
	}
	
	/**
	 * @param int $count
	 */
	private function set_failed_logins_count( $count ) {
		$this->user->save_user_field( self::TWOFAS_LIGHT_FAILED_LOGINS_COUNT, $count );
	}
	
	/**
	 * @return int
	 */
	private function get_blocked_until() {
		$blocked_until = $this->user->get_user_field( self::TWOFAS_LIGHT_USER_BLOCKED_UNTIL, - 1 );
		
		return intval( $blocked_until );
	}
	
	/**
	 * @param int $block_expiry_time_in_ms
	 */
	private function set_blocked_until( $block_expiry_time_in_ms ) {
		$this->user->save_user_field( self::TWOFAS_LIGHT_USER_BLOCKED_UNTIL, $block_expiry_time_in_ms );
	}
}
