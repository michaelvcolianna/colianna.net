<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Action\Authenticate\Authentication_Strategy_Factory;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\Result\Result_Error;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\Result\Result_Request_Not_Handled;
use TwoFAS\Light\Result\Result_User;
use TwoFAS\Light\App;

class Authenticate extends Action {
	
	/** @var Authentication_Strategy_Factory */
	private $strategy_factory;
	
	/**
	 * @param Authentication_Strategy_Factory $authentication_strategy_factory
	 */
	public function __construct( Authentication_Strategy_Factory $authentication_strategy_factory ) {
		$this->strategy_factory = $authentication_strategy_factory;
	}
	
	/**
	 * @param App $app
	 *
	 * @return Result_HTML|Result_User|Result_Error|Result_Request_Not_Handled
	 */
	public function handle( App $app ) {
		$request    = $app->get_request();
		$step_token = $app->get_step_token();
		
		if ( $this->is_reauth_requested( $request ) ) {
			$step_token->delete_token_cookie();
			return new Result_Request_Not_Handled();
		}
		
		$authentication_strategy = $this->strategy_factory->create_strategy( $app );
		return $authentication_strategy->authenticate();
	}
	
	/**
	 * @param Request $request
	 *
	 * @return bool
	 */
	private function is_reauth_requested( Request $request ) {
		return ! empty( $request->get_from_request( 'reauth' ) );
	}
}
