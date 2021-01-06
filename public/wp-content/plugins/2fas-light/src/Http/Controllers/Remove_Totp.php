<?php
declare(strict_types=1);

namespace TwoFAS\Light\Http\Controllers;

use TwoFAS\Light\Http\{Controller, Request, Redirect_Response};
use TwoFAS\Light\Http\{Action_Index, Action_URL};
use TwoFAS\Light\Storage\User_Storage;

class Remove_Totp extends Controller {

	/**
	 * @var User_Storage
	 */
	private $user_storage;

	/**
	 * @param User_Storage $user_storage
	 */
	public function __construct( User_Storage $user_storage ) {
		$this->user_storage = $user_storage;
	}

	public function remove( Request $request ): Redirect_Response {
		$this->user_storage->delete_totp_secret();
		$this->user_storage->remove_totp();

		return new Redirect_Response( new Action_URL( Action_Index::TWOFAS_LIGHT_ADMIN_PAGE_SLUG ) );
	}
}
