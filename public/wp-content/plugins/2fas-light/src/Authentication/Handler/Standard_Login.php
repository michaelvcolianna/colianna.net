<?php
declare( strict_types=1 );

namespace TwoFAS\Light\Authentication\Handler;

use TwoFAS\Light\Events\Standard_Login_Completed;
use TwoFAS\Light\Exceptions\{Authentication_Expired_Exception,
	Authentication_Not_Found_Exception,
	DateTime_Creation_Exception,
	Invalid_Totp_Token_Exception,
	Login_Attempts_Reached_Exception,
	User_Not_Found_Exception
};
use TwoFAS\Light\Helpers\Dispatcher;
use TwoFAS\Light\Http\{JSON_Response, Redirect_Response, Request, View_Response};
use TwoFAS\Light\Http\Code;
use TwoFAS\Light\Http\Not_Handled_Response;
use TwoFAS\Light\Notifications\Notification;
use TwoFAS\Light\Storage\{Authentication_Storage, Storage};
use TwoFAS\Light\Templates\Views;
use TwoFAS\Light\Totp\{Token, Token_Checker};
use WP_Error;
use WP_User;

/**
 * This class handles logging in if user manually enters a 2FA code.
 */
final class Standard_Login extends Login_Handler {
	
	/**
	 * @var Request
	 */
	private $request;
	
	/**
	 * @var Token_Checker
	 */
	private $token_checker;
	
	/**
	 * @var Authentication_Storage
	 */
	private $authentication_storage;
	
	/**
	 * @param Request       $request
	 * @param Token_Checker $token_checker
	 * @param Storage       $storage
	 */
	public function __construct( Request $request, Token_Checker $token_checker, Storage $storage ) {
		parent::__construct( $storage );
		$this->request                = $request;
		$this->token_checker          = $token_checker;
		$this->authentication_storage = $storage->get_authentication_storage();
	}
	
	/**
	 * @param WP_Error|WP_User $user
	 *
	 * @return bool
	 */
	public function supports( $user ): bool {
		if ( $this->is_wp_user( $user ) ) {
			return false;
		}
		
		return ! empty( $this->request->post( 'twofas_light_totp_token' ) );
	}
	
	/**
	 * @param WP_Error|WP_User $user
	 *
	 * @return JSON_Response|Redirect_Response|View_Response|Not_Handled_Response
	 *
	 * @throws Authentication_Not_Found_Exception
	 * @throws User_Not_Found_Exception
	 * @throws DateTime_Creation_Exception
	 */
	protected function handle( $user ) {
		$authentication = $this->authentication_storage->get_authentication( $this->get_user_id() );
		
		if ( is_null( $authentication ) ) {
			throw new Authentication_Not_Found_Exception();
		}
		
		try {
			if ( $authentication->is_expired() ) {
				throw new Authentication_Expired_Exception();
			}
			
			if ( $authentication->is_rejected() ) {
				throw new Login_Attempts_Reached_Exception();
			}
			
			$totp_token = new Token( $this->request->post( 'twofas_light_totp_token' ) );
			$this->token_checker->check( $totp_token );
			
			if ( ! $totp_token->accepted() ) {
				$this->authentication_storage->reduce_authentications_attempts( $authentication );
				
				return $this->view_error( Views::TOTP_AUTHENTICATION_PAGE, Notification::get( 'token-invalid' ) );
			}
			
			Dispatcher::dispatch( new Standard_Login_Completed( $this->get_user_id() ) );
			
			return $this->json( [ 'user_id' => $this->get_user_id() ], Code::OK );
		} catch ( Login_Attempts_Reached_Exception $e ) {
			$this->user_storage->block_user();
			$this->authentication_storage->close_authentication( $authentication );
			
			return $this->json_error( Notification::get( 'authentication-limit' ), Code::FORBIDDEN );
		} catch ( Authentication_Expired_Exception $e ) {
			$this->authentication_storage->close_authentication( $authentication );
			
			return $this->json_error( Notification::get( 'authentication-expired' ), Code::FORBIDDEN );
		} catch ( Invalid_Totp_Token_Exception $e ) {
			$this->authentication_storage->reduce_authentications_attempts( $authentication );
			
			return $this->view_error( Views::TOTP_AUTHENTICATION_PAGE, Notification::get( 'token-invalid' ) );
		}
	}
}
