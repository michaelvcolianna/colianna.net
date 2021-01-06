<?php
declare(strict_types=1);

namespace TwoFAS\Light\Authentication\Middleware;

use TwoFAS\Light\Http\{Request, JSON_Response};
use TwoFAS\Light\Authentication\{Login_Action, Login_Response};
use TwoFAS\Light\Http\Code;
use TwoFAS\Light\Storage\Trusted_Devices_Storage;

/**
 * This class adds a new trusted device if a user checked a checkbox on a login page.
 */
final class New_Trusted_Device extends Middleware {

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var Trusted_Devices_Storage
	 */
	private $trusted_devices_storage;

	/**
	 * @param Request                 $request
	 * @param Trusted_Devices_Storage $trusted_devices_storage
	 */
	public function __construct( Request $request, Trusted_Devices_Storage $trusted_devices_storage ) {
		$this->request                 = $request;
		$this->trusted_devices_storage = $trusted_devices_storage;
	}

	/**
	 * @inheritDoc
	 */
	public function handle( $user, $response = null ) {
		$remember_device = $this->request->post( Login_Response::TWOFAS_LOGIN_REMEMBER_DEVICE );

		if ( ! $this->is_wp_user( $user )
			&& $response instanceof JSON_Response
			&& Code::OK === $response->get_status_code()
			&& ! empty( $remember_device )
			&& $this->request->is_login_action_equal_to( Login_Action::VERIFY_TOTP_CODE ) ) {
			$body    = $response->get_body();
			$user_id = $body['user_id'];

			$this->trusted_devices_storage->add_trusted_device( $user_id );
		}

		return $this->run_next( $user, $response );
	}
}
