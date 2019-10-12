<?php

namespace TwoFAS\Light;

use Exception;
use TwoFAS\Light\Action\Authenticate;
use TwoFAS\Light\Action\Authenticate\Authentication_Input;
use TwoFAS\Light\Exception\TwoFASLight_Exception;
use TwoFAS\Light\Request\Regular_Request;
use TwoFAS\Light\Result\Error_Consumer;
use TwoFAS\Light\Result\HTML_Consumer;
use TwoFAS\Light\Result\Request_Not_Handled_Consumer;
use TwoFAS\Light\Result\User_Consumer;
use WP_Error;
use WP_User;

class Authenticate_App extends App implements HTML_Consumer, User_Consumer, Error_Consumer, Request_Not_Handled_Consumer {
	
	/** @var Authenticate */
	private $action;
	
	/** @var Authentication_Input */
	private $authentication_input;
	
	/**
	 * Authenticate_App constructor.
	 *
	 * @param Authenticate         $action
	 * @param Authentication_Input $authentication_input
	 */
	public function __construct( Authenticate $action, Authentication_Input $authentication_input ) {
		parent::__construct();
		$this->action = $action;
		$this->authentication_input = $authentication_input;
	}
	
	/**
	 * @return WP_User|WP_Error|null
	 */
	public function run() {
		$this->request = new Regular_Request();
		$this->request->fill_with_context( $this->request_context );
		
		$result = $this->action->handle( $this );
		return $result->feed_consumer( $this );
	}
	
	/**
	 * @param $user_id
	 *
	 * @return WP_User
	 */
	public function consume_user( $user_id ) {
		return new WP_User( $user_id );
	}
	
	/**
	 * @param $html
	 */
	public function consume_html( $html ) {
		echo $html;
		exit();
	}
	
	/**
	 * @param $error
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function consume_error( $error ) {
		if ( ! ( $error instanceof WP_Error ) ) {
			throw new TwoFASLight_Exception( 'Unexpected response type from request handler' );
		}
		
		return $error;
	}
	
	/**
	 * @return WP_User|WP_Error|null
	 */
	public function consume_request_not_handled() {
		return $this->authentication_input->get();
	}
}
