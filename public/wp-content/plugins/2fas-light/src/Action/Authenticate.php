<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Action\Authenticate\Authentication_Strategy_Factory;
use TwoFAS\Light\App;
use TwoFAS\Light\Exception\Authenticate_No_Username_Nor_Step_Token_Exception;
use TwoFAS\Light\Exception\Login_Token_Invalid_Exception;
use TwoFAS\Light\Result\Result_Error;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_Request_Not_Handled;
use TwoFAS\Light\Result\Result_User;

class Authenticate extends Action {
	
	/** @var Authentication_Strategy_Factory */
	private $strategy_factory;
	
	/**
	 * @param Authentication_Strategy_Factory $strategy_factory
	 */
	public function __construct( Authentication_Strategy_Factory $strategy_factory ) {
		$this->strategy_factory = $strategy_factory;
	}
	
	/**
	 * @param App $app
	 *
	 * @return Result_HTML|Result_User|Result_Error|Result_Request_Not_Handled
	 *
	 * @throws Authenticate_No_Username_Nor_Step_Token_Exception
	 * @throws Login_Token_Invalid_Exception
	 */
	public function handle( App $app ) {
		return $this->strategy_factory->create_strategy( $app )->authenticate();
	}
}
