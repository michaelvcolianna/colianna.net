<?php

namespace TwoFAS\Light\Rate_Plugin_Prompt;

use TwoFAS\Light\Time\Time;
use TwoFAS\Light\User\User;

class Rate_Plugin_Prompt {
	
	const DAYS_BEFORE_DISPLAYING_PROMPT = 14;
	const REQUIRED_CAPABILITY = 'install_plugins';
	
	/** @var Time */
	private $time;
	
	/** @var User */
	private $user;
	
	/**
	 * Rate_Plugin_Prompt constructor.
	 *
	 * @param Time   $time
	 * @param User   $user
	 */
	public function __construct( Time $time, User $user ) {
		$this->time   = $time;
		$this->user   = $user;
	}
	
	/**
	 * @return bool
	 */
	public function should_display() {
		return current_user_can( self::REQUIRED_CAPABILITY ) && $this->has_enough_time_passed() && ! $this->user->is_rate_plugin_prompt_hidden();
	}
	
	/**
	 * Restart the countdown to when to start displaying the prompt again.
	 */
	public function restart_countdown() {
		$current_date = $this->time->get_current_datetime();
		$this->user->update_rate_prompt_countdown_start_date( $current_date );
	}
	
	/**
	 * @return bool
	 */
	private function has_enough_time_passed() {
		$prompt_countdown_start = $this->user->get_rate_prompt_countdown_start();
		
		if ( ! $prompt_countdown_start ) {
			$this->restart_countdown();
			return false;
		}
		
		$current_date = $this->time->get_current_datetime();
		
		return $current_date->diff( $prompt_countdown_start )->days >= self::DAYS_BEFORE_DISPLAYING_PROMPT;
	}
}
