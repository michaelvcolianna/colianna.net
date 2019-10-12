<?php

namespace TwoFAS\Light\Device;

use TwoFAS\Light\Exception\Device_ID_Is_Not_Trusted_Exception;
use TwoFAS\Light\Hash\Hash_Generator;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\App;
use TwoFAS\Light\User\User;

class Trusted_Device_Manager {
	
	const DEVICE_ID_PREFIX = 'TWOFAS_LIGHT_TRUSTED_DEVICE_';
	const HASH_LENGTH = 128;
	
	/** @var Trusted_Device_Cookie_Manager */
	private $cookie_manager;
	
	/** @var Hash_Generator */
	private $hash_generator;
	
	/** @var Request */
	private $request;
	
	/** @var User */
	private $user;
	
	/**
	 * @param App  $app
	 * @param User $user
	 */
	public function __construct( App $app, User $user ) {
		$this->cookie_manager = $app->get_trusted_device_cookie_manager( $user );
		$this->hash_generator = $app->get_hash_generator();
		$this->request        = $app->get_request();
		$this->user           = $user;
	}
	
	/**
	 * @return Trusted_Device
	 */
	public function create() {
		$device_id_hash  = $this->hash_generator->generate_alphanumeric_hash( self::HASH_LENGTH );
		$device_key_hash = $this->hash_generator->generate_hash( self::HASH_LENGTH );
		$trusted_device  = new Trusted_Device(
			self::DEVICE_ID_PREFIX . $device_id_hash,
			$device_key_hash,
			$this->request->get_ip(),
			$this->request->get_user_agent(),
			$this->request->get_timestamp()
		);
		$this->user->save_user_trusted_device( $trusted_device );
		$this->cookie_manager->set( $trusted_device );
		
		return $trusted_device;
	}
	
	/**
	 * @return null|Trusted_Device
	 */
	public function get_from_cookie() {
		$trusted_devices = $this->user->get_user_trusted_devices();
		
		foreach ( $trusted_devices as $device_id => $device_data ) {
			$cookie_device_key = $this->request->get_from_cookie( $device_id );
			if ( $cookie_device_key === $device_data['device_key'] ) {
				return Trusted_Device::create_from_user_meta( $device_id, $device_data );
			}
		}
		
		return null;
	}
	
	public function delete_all() {
		$this->cookie_manager->delete_all_set();
		$this->user->remove_trusted_devices();
	}
	
	/**
	 * @param string $device_id
	 *
	 * @throws Device_ID_Is_Not_Trusted_Exception
	 */
	public function delete( $device_id ) {
		$this->cookie_manager->delete_if_set( $device_id );
		if ( ! $this->user->remove_trusted_device( $device_id ) ) {
			throw new Device_ID_Is_Not_Trusted_Exception();
		}
	}
}
