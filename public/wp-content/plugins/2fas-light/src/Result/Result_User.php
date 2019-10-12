<?php

namespace TwoFAS\Light\Result;

use TwoFAS\Light\User\User;

class Result_User {
	
	/**
	 * @var mixed
	 */
	private $user_id;
	
	/**
	 * Result_User constructor.
	 *
	 * @param User $user
	 */
	public function __construct( User $user ) {
		$this->user_id = $user->get_id();
	}
	
	/**
	 * @param User_Consumer $consumer
	 *
	 * @return mixed
	 */
	public function feed_consumer( User_Consumer $consumer ) {
		return $consumer->consume_user( $this->user_id );
	}
}
