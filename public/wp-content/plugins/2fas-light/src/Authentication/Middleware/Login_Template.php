<?php
declare(strict_types=1);

namespace TwoFAS\Light\Authentication\Middleware;

use TwoFAS\Light\Exceptions\Handler\Error_Handler_Interface;
use TwoFAS\Light\Helpers\Dispatcher;
use TwoFAS\Light\Http\{Request, JSON_Response, View_Response};
use TwoFAS\Light\Authentication\{Login_Action, Login_Response};
use TwoFAS\Light\Events\Second_Step_Rendered;
use TwoFAS\Light\Http\Session;
use TwoFAS\Light\Storage\Storage;

/**
 * This class sets a login template as a final response.
 */
final class Login_Template extends Middleware {

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var Session
	 */
	private $session;

	/**
	 * @var Login_Response
	 */
	private $login_response;

	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * @var Error_Handler_Interface
	 */
	private $error_handler;

	/**
	 * @var array
	 */
	private $login_actions = [
		'stop_login_process'    => Login_Action::STOP_LOGIN_PROCESS,
		'log_in_with_totp_code' => Login_Action::LOG_IN_WITH_TOTP_CODE,
		'verify_totp_code'      => Login_Action::VERIFY_TOTP_CODE
	];

	/**
	 * @param Request                 $request
	 * @param Login_Response          $login_response
	 * @param Storage                 $storage
	 * @param Session                 $session
	 * @param Error_Handler_Interface $error_handler
	 */
	public function __construct(
		Request $request,
		Login_Response $login_response,
		Storage $storage,
		Session $session,
		Error_Handler_Interface $error_handler
	) {
		$this->request        = $request;
		$this->login_response = $login_response;
		$this->storage        = $storage;
		$this->session        = $session;
		$this->error_handler  = $error_handler;
	}

	/**
	 * @inheritDoc
	 */
	public function handle( $user, $response = null ) {
		$user_storage = $this->storage->get_user_storage();

		if ( $response instanceof JSON_Response || ! $user_storage->is_wp_user_set() ) {
			return $this->run_next( $user, $response );
		}

		if ( ! $response instanceof View_Response ) {
			$response = new View_Response( 'login_second_step.html.twig' );
		}

		$this->login_response->set_from_request( $this->request );
		$this->login_response->set_from_storage( $this->storage );
		$this->login_response->set( 'actions', $this->login_actions );

		$data = $this->login_response->get_all();

		if ( array_key_exists( 'redirect_to', $data ) ) {
			$redirect_to = $data['redirect_to'];

			if ( force_ssl_admin() && false !== strpos( $redirect_to, 'wp-admin' ) ) {
				$redirect_to         = preg_replace( '|^http://|', 'https://', $redirect_to );
				$data['redirect_to'] = $redirect_to;
			}
		}

		$current_data = $response->get_data();

		foreach ( $data as $variable_name => $variable_value ) {
			$current_data[ $variable_name ] = $variable_value;
		}

		$view_response = new View_Response( $response->get_template(), $current_data );

		Dispatcher::dispatch( new Second_Step_Rendered( $view_response ) );

		return $view_response;
	}
}
