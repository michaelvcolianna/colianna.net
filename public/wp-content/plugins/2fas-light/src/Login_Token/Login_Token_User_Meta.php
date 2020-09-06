<?php

namespace TwoFAS\Light\Login_Token;

use InvalidArgumentException;
use TwoFAS\Light\Exception\Invalid_Or_Empty_User_Meta_Value_Exception;
use TwoFAS\Light\User\User;

class Login_Token_User_Meta {
	
	/** @var Login_Token_Config */
	private $config;
	
	/**
	 * @param Login_Token_Config $config
	 */
	public function __construct( Login_Token_Config $config ) {
		$this->config = $config;
	}
	
	/**
	 * @param User   $user
	 * @param string $hash
	 * @param int    $expiration_timestamp
	 * @param string $context
	 */
	public function store( User $user, $hash, $expiration_timestamp, $context ) {
		$meta_value = [
			'hash'    => $hash,
			'expiry'  => $expiration_timestamp,
			'context' => $context,
		];
		
		$user->save_user_field( $this->config->get_user_meta_name(), $meta_value );
	}
	
	/**
	 * @param User $user
	 */
	public function delete( User $user ) {
		$user->remove_user_field( $this->config->get_user_meta_name() );
	}
	
	/**
	 * @param User $user
	 *
	 * @return Login_Token
	 * @throws Invalid_Or_Empty_User_Meta_Value_Exception
	 */
	public function get_token( User $user ) {
		return new Login_Token(
			$user,
			$this->get_hash( $user ),
			$this->get_expiry( $user ),
			$this->get_context( $user )
		);
	}
	
	/**
	 * @param User $user
	 *
	 * @return string
	 * @throws Invalid_Or_Empty_User_Meta_Value_Exception
	 */
	private function get_hash( User $user ) {
		return $this->get_meta_component( $user, 'hash' );
	}
	
	/**
	 * @param User $user
	 *
	 * @return int
	 * @throws Invalid_Or_Empty_User_Meta_Value_Exception
	 */
	private function get_expiry( User $user ) {
		return $this->get_meta_component( $user, 'expiry' );
	}
	
	/**
	 * @param User $user
	 *
	 * @return string
	 * @throws Invalid_Or_Empty_User_Meta_Value_Exception
	 */
	private function get_context( User $user ) {
		return $this->get_meta_component( $user, 'context' );
	}
	
	/**
	 * @param User   $user
	 * @param string $component_key
	 *
	 * @return string
	 * @throws Invalid_Or_Empty_User_Meta_Value_Exception
	 * @throws InvalidArgumentException
	 */
	private function get_meta_component( User $user, $component_key ) {
		$expected_component_keys = [ 'hash', 'expiry', 'context' ];
		
		if ( ! in_array( $component_key, $expected_component_keys, true ) ) {
			throw new InvalidArgumentException(
				sprintf( 'Component key must be either "%s"', implode( '", "', $expected_component_keys ) )
			);
		}
		
		$user_meta = $user->get_user_field( $this->config->get_user_meta_name() );
		
		if ( empty( $user_meta ) ) {
			throw new Invalid_Or_Empty_User_Meta_Value_Exception();
		}
		
		foreach ( $expected_component_keys as $expected_key ) {
			if ( ! isset( $user_meta[ $expected_key ] ) ) {
				throw new Invalid_Or_Empty_User_Meta_Value_Exception();
			}
		}
		
		return $user_meta[ $component_key ];
	}
}
