<?php

namespace TwoFAS\Light\Device;

class Trusted_Device {
	
	/**
	 * @var string|null
	 */
	private $device_id;
	
	/**
	 * @var string|null
	 */
	private $device_key;
	
	/**
	 * @var string|null
	 */
	private $ip;
	
	/**
	 * @var string|null
	 */
	private $user_agent;
	
	/**
	 * @var int|null
	 */
	private $timestamp;
	
	/**
	 * @param string $device_id
	 * @param array  $device_data
	 *
	 * @return Trusted_Device
	 */
	public static function create_from_user_meta( $device_id, $device_data ) {
		$device_key = $device_data['device_key'];
		$ip         = $device_data['ip'];
		$user_agent = $device_data['user_agent'];
		$timestamp  = $device_data['timestamp'];
		
		return new self( $device_id, $device_key, $ip, $user_agent, $timestamp );
	}
	
	/**
	 * Trusted_Device constructor.
	 *
	 * @param string $device_id
	 * @param string $device_key
	 * @param string $ip
	 * @param string $user_agent
	 * @param int    $timestamp
	 */
	public function __construct( $device_id, $device_key, $ip, $user_agent, $timestamp ) {
		$this->device_id  = $device_id;
		$this->device_key = $device_key;
		$this->ip         = $ip;
		$this->user_agent = $user_agent;
		$this->timestamp  = $timestamp;
	}
	
	/**
	 * @return string|null
	 */
	public function get_device_id() {
		return $this->device_id;
	}
	
	/**
	 * @return string|null
	 */
	public function get_device_key() {
		return $this->device_key;
	}
	
	/**
	 * @return string|null
	 */
	public function get_ip() {
		return $this->ip;
	}
	
	/**
	 * @return string|null
	 */
	public function get_user_agent() {
		return $this->user_agent;
	}
	
	/**
	 * @return int|null
	 */
	public function get_timestamp() {
		return $this->timestamp;
	}
}
