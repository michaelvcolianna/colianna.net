<?php

namespace TwoFAS\Light\Rate_Plugin_Prompt;

use DateTime;
use TwoFAS\Light\Exception\Rate_Plugin_Countdown_Never_Started_Exception;
use TwoFAS\Light\Exception\DateTime_Creation_Exception;
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
	 * @param Time $time
	 * @param User $user
	 */
	public function __construct( Time $time, User $user ) {
		$this->time = $time;
		$this->user = $user;
	}
	
	/**
	 * @return bool
	 */
	public function should_display() {
		try {
			return $this->are_display_conditions_satisfied();
		} catch ( Rate_Plugin_Countdown_Never_Started_Exception $e ) {
			return $this->handle_countdown_never_started();
		} catch ( DateTime_Creation_Exception $e ) {
			return false;
		}
	}
	
	/**
	 * Restart the countdown to when to start displaying the prompt again.
	 * @throws DateTime_Creation_Exception
	 */
	public function restart_countdown() {
		$current_date = $this->time->get_current_datetime();
		$this->user->update_rate_prompt_countdown_start_date( $current_date );
	}
	
	/**
	 * @return bool
	 * @throws Rate_Plugin_Countdown_Never_Started_Exception
	 * @throws DateTime_Creation_Exception
	 */
	private function are_display_conditions_satisfied() {
		return current_user_can( self::REQUIRED_CAPABILITY ) &&
		       $this->has_enough_time_passed() &&
		       ! $this->user->is_rate_plugin_prompt_hidden();
	}
	
	/**
	 * @return bool
	 * @throws Rate_Plugin_Countdown_Never_Started_Exception
	 * @throws DateTime_Creation_Exception
	 */
	private function has_enough_time_passed() {
		$prompt_countdown_start = $this->get_countdown_start_datetime();
		$current_date           = $this->time->get_current_datetime();
		
		return $current_date->diff( $prompt_countdown_start )->days >= self::DAYS_BEFORE_DISPLAYING_PROMPT;
	}
	
	/**
	 * @return bool
	 */
	private function handle_countdown_never_started() {
		try {
			$this->restart_countdown();
		} catch ( DateTime_Creation_Exception $e ) {
			// Pass.
		}
		return false;
	}
	
	/**
	 * @return DateTime
	 * @throws Rate_Plugin_Countdown_Never_Started_Exception
	 * @throws DateTime_Creation_Exception
	 */
	private function get_countdown_start_datetime() {
		$prompt_countdown_start_timestamp = $this->user->get_rate_prompt_countdown_start_timestamp();
		return $this->time->get_datetime_for_timestamp( $prompt_countdown_start_timestamp );
	}
}
