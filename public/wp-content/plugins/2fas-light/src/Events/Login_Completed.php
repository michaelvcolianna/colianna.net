<?php
declare(strict_types=1);

namespace TwoFAS\Light\Events;

abstract class Login_Completed implements Event_Interface {
	/**
	 * @var int
	 */
	protected $user_id;
	
	public function __construct( int $user_id ) {
		$this->user_id = $user_id;
	}
	
	public function get_user_id(): int {
		return $this->user_id;
	}
}
