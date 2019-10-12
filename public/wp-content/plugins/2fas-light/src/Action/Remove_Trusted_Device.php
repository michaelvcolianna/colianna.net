<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Exception\Device_ID_Is_Not_Trusted_Exception;
use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\App;

class Remove_Trusted_Device extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return null|Result_JSON
	 */
	public function handle( App $app ) {
		$device_id              = $app->get_request()->get_from_post( 'device_id' );
		$trusted_device_manager = $app->get_trusted_device_manager( $app->get_user() );
		
		if ( ! $device_id ) {
			return null;
		}
		
		try {
			$trusted_device_manager->delete( $device_id );
		} catch ( Device_ID_Is_Not_Trusted_Exception $e ) {
			return null;
		}
		
		$trusted_devices = $app->get_view_renderer()->render( 'includes/trusted_devices.html.twig', array(
			'trusted_devices' => $app->get_user()->get_user_trusted_devices()
		) );
		
		return new Result_JSON( array(
			'twofas_light_result'          => 'success',
			'device_id'                    => $device_id,
			'twofas_light_trusted_devices' => $trusted_devices
		) );
	}
}
