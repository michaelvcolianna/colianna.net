<?php

namespace TwoFAS\Light\Device;

use TwoFAS\Light\Cookie\Cookie;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\App;
use TwoFAS\Light\User\User;

class Trusted_Device_Cookie_Manager {
	
	/** @var int */
	const COOKIE_LIFESPAN = 2147483647;
	
	/** @var Cookie */
	private $cookie;
	
	/** @var Request */
	private $request;
	
	/** @var User */
	private $user;
	
	/**
	 * @param App  $app
	 * @param User $user
	 */
	public function __construct( App $app, User $user ) {
		$this->cookie  = $app->get_cookie();
		$this->request = $app->get_request();
		$this->user    = $user;
	}
	
	/**
	 * @param Trusted_Device $device
	 */
	public function set( Trusted_Device $device ) {
		$this->cookie->set_cookie( $device->get_device_id(), $device->get_device_key(), self::COOKIE_LIFESPAN,
			true );
	}
	
	public function delete_all_set() {
		foreach ( array_keys( $this->user->get_user_trusted_devices() ) as $device_id ) {
			$this->delete_if_set( $device_id );
		}
	}
	
	/**
	 * @param string $device_id
	 */
	public function delete_if_set( $device_id ) {
		if ( $this->request->get_from_cookie( $device_id ) ) {
			$this->delete( $device_id );
		}
	}
	
	/**
	 * @param string $device_id
	 */
	private function delete( $device_id ) {
		$this->cookie->delete_cookie( $device_id );
		$this->cookie->delete_hostonly_cookie( $device_id );
	}
}
