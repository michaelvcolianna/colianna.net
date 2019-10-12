<?php

namespace TwoFAS\Light\Result;

interface User_Consumer {
	
	/**
	 * @param $user_id
	 */
	public function consume_user( $user_id );
}
