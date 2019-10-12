<?php

namespace TwoFAS\Light\Result;

interface Request_Not_Handled_Consumer {
	
	/**
	 * @return mixed
	 */
	public function consume_request_not_handled();
}
