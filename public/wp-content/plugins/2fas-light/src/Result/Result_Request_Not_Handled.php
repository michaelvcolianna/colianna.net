<?php

namespace TwoFAS\Light\Result;

class Result_Request_Not_Handled {
	
	/**
	 * @param Request_Not_Handled_Consumer $consumer
	 *
	 * @return mixed
	 */
	public function feed_consumer( Request_Not_Handled_Consumer $consumer ) {
		return $consumer->consume_request_not_handled();
	}
}
