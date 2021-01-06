<?php
declare( strict_types=1 );

namespace TwoFAS\Light\Authentication\Middleware;

use Exception;
use TwoFAS\Light\Exceptions\Handler\Error_Handler_Interface;
use TwoFAS\Light\Http\{JSON_Response, View_Response};
use TwoFAS\Light\Exceptions\{
	Authentication_Expired_Exception,
	Login_Attempts_Reached_Exception,
	Totp_Disabled_Exception
};
use TwoFAS\Light\Http\Code;
use TwoFAS\Light\Notifications\Notification;
use TwoFAS\Light\Storage\{Authentication_Storage, Storage, User_Storage};

class Authentication_Opener extends Middleware {

	/**
	 * @var Authentication_Storage
	 */
	private $authentication_storage;

	/**
	 * @var User_Storage
	 */
	private $user_storage;

	/**
	 * @var Error_Handler_Interface
	 */
	private $error_handler;

	/**
	 * @param Storage                 $storage
	 * @param Error_Handler_Interface $error_handler
	 */
	public function __construct( Storage $storage, Error_Handler_Interface $error_handler ) {
		$this->authentication_storage = $storage->get_authentication_storage();
		$this->user_storage           = $storage->get_user_storage();
		$this->error_handler          = $error_handler;
	}

	/**
	 * @inheritDoc
	 */
	public function handle( $user, $response = null ) {
		if ( $response instanceof JSON_Response || $response instanceof View_Response || ! $this->user_storage->is_wp_user_set() ) {
			return $this->run_next( $user, $response );
		}
		try {
			$authentication = $this->authentication_storage->get_authentication( $this->user_storage->get_user_id() );

			try {
				if ( ! $this->user_storage->is_totp_enabled() ) {
					throw new Totp_Disabled_Exception();
				}

				if ( is_null( $authentication ) ) {
					$authentication = $this->authentication_storage->open_authentication(
						$this->user_storage->get_user_id() );
				}

				if ( $authentication->is_expired() ) {
					throw new Authentication_Expired_Exception();
				}

				if ( $authentication->is_rejected() ) {
					throw new Login_Attempts_Reached_Exception();
				}

			} catch ( Login_Attempts_Reached_Exception $e ) {
				$this->authentication_storage->close_authentication( $authentication );

				$response = $this->json_error( Notification::get( 'authentication-limit' ), Code::FORBIDDEN );
			} catch ( Authentication_Expired_Exception $e ) {
				$this->authentication_storage->close_authentication( $authentication );

				$response = $this->json_error( Notification::get( 'authentication-expired' ), Code::FORBIDDEN );
			}
		} catch ( Exception $e ) {
			$response = $this->error_handler->capture_exception( $e )->to_json( $e );
		}

		return $this->run_next( $user, $response );
	}
}
