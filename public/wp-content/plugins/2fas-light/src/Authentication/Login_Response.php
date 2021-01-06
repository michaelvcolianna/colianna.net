<?php
declare(strict_types=1);

namespace TwoFAS\Light\Authentication;

use TwoFAS\Light\Http\Request;
use TwoFAS\Light\Exceptions\User_Not_Found_Exception;
use TwoFAS\Light\Storage\Storage;

class Login_Response {

	const WP_LOGIN_REDIRECT_TO         = 'redirect_to';
	const WP_LOGIN_REMEMBER_ME         = 'rememberme';
	const WP_LOGIN_TEST_COOKIE         = 'testcookie';
	const WP_LOGIN_INTERIM_LOGIN       = 'interim-login';
	const WP_LOGIN_CUSTOMIZE_LOGIN     = 'customize-login';
	const TWOFAS_LOGIN_REMEMBER_DEVICE = 'twofas_light_remember_device';

	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set( string $key, $value ) {
		$this->data[ $key ] = $value;
	}

	/**
	 * @param Request $request
	 */
	public function set_from_request( Request $request ) {
		$redirect_to = $request->request( self::WP_LOGIN_REDIRECT_TO );
		$remember_me = $request->post( self::WP_LOGIN_REMEMBER_ME );

		if ( empty( $remember_me ) ) {
			$remember_me = $request->get( self::WP_LOGIN_REMEMBER_ME );
		}

		$test_cookie     = $request->post( self::WP_LOGIN_TEST_COOKIE );
		$interim_login   = $request->request( self::WP_LOGIN_INTERIM_LOGIN );
		$customize_login = $request->request( self::WP_LOGIN_CUSTOMIZE_LOGIN );
		$remember_device = $request->post( self::TWOFAS_LOGIN_REMEMBER_DEVICE );

		if ( ! empty( $redirect_to ) ) {
			$this->set( 'redirect_to', $redirect_to );
		}

		if ( ! empty( $remember_me ) ) {
			$this->set( 'rememberme', $remember_me );
		}

		if ( ! empty( $test_cookie ) ) {
			$this->set( 'testcookie', $test_cookie );
		}

		if ( ! empty( $interim_login ) ) {
			$this->set( 'interim_login', $interim_login );
		}

		if ( ! empty( $customize_login ) ) {
			$this->set( 'customize_login', $customize_login );
		}

		if ( ! empty( $remember_device ) ) {
			$this->set( 'remember_device', $remember_device );
		}
	}

	/**
	 * @param Storage $storage
	 *
	 * @throws User_Not_Found_Exception
	 */
	public function set_from_storage( Storage $storage ) {
		$user_storage = $storage->get_user_storage();

		$this->set( 'is_totp_enabled', $user_storage->is_totp_enabled() );
	}

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get( string $key ) {
		if ( ! array_key_exists( $key, $this->data ) ) {
			return null;
		}

		return $this->data[ $key ];
	}

	public function get_all(): array {
		return $this->data;
	}
}
