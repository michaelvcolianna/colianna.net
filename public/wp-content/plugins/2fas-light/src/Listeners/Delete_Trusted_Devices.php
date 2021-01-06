<?php
declare(strict_types=1);

namespace TwoFAS\Light\Listeners;

use TwoFAS\Light\Events\Totp_Configuration_Completed;
use TwoFAS\Light\Http\Session;
use TwoFAS\Light\Storage\Storage;

class Delete_Trusted_Devices extends Listener {
	
	/**
	 * @var Storage
	 */
	private $storage;
	
	/**
	 * @var Session
	 */
	private $session;
	
	/**
	 * @param Storage $storage
	 * @param Session $session
	 */
	public function __construct( Storage $storage, Session $session ) {
		$this->storage = $storage;
		$this->session = $session;
	}
	
	/**
	 * @param Totp_Configuration_Completed $event
	 */
	public function handle( Totp_Configuration_Completed $event ) {
		$user_storage            = $this->storage->get_user_storage();
		$trusted_devices_storage = $this->storage->get_trusted_devices_storage();
		$old_secret              = $user_storage->get_totp_secret();
		
		if ( $old_secret !== $event->get_secret() ) {
			$this->session->log_out_on_other_devices( $user_storage->get_user_id() );
			$trusted_devices_storage->delete_trusted_devices( $user_storage->get_user_id() );
		}
	}
}
