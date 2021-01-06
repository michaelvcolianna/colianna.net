<?php
declare( strict_types=1 );

namespace TwoFAS\Light\Hooks;

use Exception;
use TwoFAS\Light\Authentication\Login_Process;
use TwoFAS\Light\Core\Plugin;
use TwoFAS\Light\Exceptions\Handler\Error_Handler_Interface;
use TwoFAS\Light\Helpers\Flash;
use TwoFAS\Light\Http\Code;
use TwoFAS\Light\Http\Direct_URL;
use TwoFAS\Light\Http\JSON_Response;
use TwoFAS\Light\Http\Not_Handled_Response;
use TwoFAS\Light\Http\Redirect_Response;
use TwoFAS\Light\Http\Request;
use TwoFAS\Light\Http\Safe_Redirect_Response;
use TwoFAS\Light\Http\View_Response;
use TwoFAS\Light\Templates\Twig;
use WP_Error;
use WP_User;

class Authenticate_Filter implements Hook_Interface {
	
	const LOGIN_ACTION_KEY = 'twofas_light_action';
	
	/**
	 * @var Login_Process
	 */
	private $login_process;
	
	/**
	 * @var Error_Handler_Interface
	 */
	private $error_handler;
	
	/**
	 * @var Request
	 */
	private $request;
	
	/**
	 * @var Flash
	 */
	private $flash;
	
	/**
	 * @var Twig
	 */
	private $twig;
	
	public function __construct(
		Login_Process $login_process,
		Error_Handler_Interface $error_handler,
		Request $request,
		Flash $flash,
		Twig $twig
	) {
		$this->login_process = $login_process;
		$this->error_handler = $error_handler;
		$this->request       = $request;
		$this->flash         = $flash;
		$this->twig          = $twig;
	}
	
	public function register_hook() {
		add_filter( 'authenticate', [ $this, 'authenticate' ], 100 );
		add_action( 'jetpack_sso_handle_login', [ $this, 'authenticate' ], 100 );
	}
	
	/**
	 * @param null|WP_User|WP_Error $user
	 *
	 * @return null|WP_User|WP_Error
	 */
	public function authenticate( $user ) {
		if ( is_null( $user ) ) {
			return null;
		}
		
		$response = $this->login_process->authenticate( $user );
		
		if ( $this->should_response_be_changed( $response ) ) {
			$this->flash->add_message( 'error', $response->get_body()['error'] );
			$response = $this->safe_redirect();
		}
		
		if ( $this->is_not_handled( $response ) ) {
			return $user;
		}
		
		if ( $response instanceof JSON_Response ) {
			$status_code = $response->get_status_code();
			$body        = $response->get_body();
			
			if ( Code::OK === $status_code ) {
				return new WP_User( $body['user_id'] );
			}
			
			return $this->error( $body['error'] );
		}
		
		if ( $response instanceof Redirect_Response ) {
			$response->redirect();
		}
		
		if ( $response instanceof View_Response ) {
			try {
				echo $this->twig->try_render( $response->get_template(), $response->get_data() );
				Plugin::terminate();
			} catch ( Exception $e ) {
				return $this->error_handler->capture_exception( $e )->to_wp_error( $e );
			}
		}
	}
	
	/**
	 * @param null|View_Response|JSON_Response|Redirect_Response|Not_Handled_Response $response
	 *
	 * @return bool
	 */
	private function is_not_handled( $response ): bool {
		return is_null( $response ) || $response instanceof Not_Handled_Response;
	}
	
	private function should_response_be_changed( $response ): bool {
		return $this->is_jetpack_sso_login()
		       && $response instanceof JSON_Response
		       && Code::OK !== $response->get_status_code();
	}
	
	private function is_jetpack_sso_login(): bool {
		return did_action( 'jetpack_sso_handle_login' ) > 0;
	}
	
	private function safe_redirect(): Safe_Redirect_Response {
		$login_url     = wp_login_url();
		$interim_login = $this->request->request( 'interim-login' );
		
		if ( $interim_login ) {
			$login_url = add_query_arg( 'interim-login', '1', $login_url );
		}
		
		return new Safe_Redirect_Response( new Direct_URL ( $login_url ) );
	}
	
	/**
	 * @param string $message
	 *
	 * @return WP_Error
	 */
	private function error( $message ): WP_Error {
		return new WP_Error( 'twofas_light_login_error', $message );
	}
}
