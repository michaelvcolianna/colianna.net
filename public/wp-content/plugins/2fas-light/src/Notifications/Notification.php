<?php
declare( strict_types=1 );

namespace TwoFAS\Light\Notifications;

class Notification {
	
	/**
	 * @var array
	 */
	private static $notifications = [];
	
	/**
	 * @param string $key
	 *
	 * @return string
	 */
	public static function get( string $key ): string {
		if ( empty( self::$notifications ) ) {
			self::load_notifications();
		}
		
		if ( ! isset( self::$notifications[ $key ] ) ) {
			return self::$notifications['default'];
		}
		
		return self::$notifications[ $key ];
	}
	
	private static function load_notifications() {
		self::$notifications = [
			// Plugin overall notifications
			'logged-in'                     => __( 'You have been logged in to your 2FAS account.', '2fas-light' ),
			'logged-out'                    => __( 'You have been logged out from 2FAS account.', '2fas-light' ),
			'csrf'                          => __( 'CSRF token is invalid.', '2fas-light' ),
			'ajax'                          => __( 'Invalid AJAX request.', '2fas-light' ),
			'inconsistent-data'             => __( 'Plugin data is inconsistent.', '2fas-light' ),
			'session-tables'                => __( 'Session tables does not exists.', '2fas-light' ),
			
			// Validation
			'token-invalid'                 => __( 'Wrong token entered, please try again.', '2fas-light' ),
			
			// Trusted devices
			'trusted-device-removed'        => __( 'Trusted device has been removed.', '2fas-light' ),
			
			// User enables and disables authentication method
			'totp-enabled'                  => __( 'Two-factor authentication has been enabled.', '2fas-light' ),
			'totp-disabled'                 => __( 'Two-factor authentication has been disabled.', '2fas-light' ),
			'totp-not-configured'           => __( 'Totp is not configured.', '2fas-light' ),
			'configuration-removed'         => __( 'Configuration has been removed successfully.', '2fas-light' ),
			'configuration-remove-error'    => __( 'Error occurred during configuration removing.', '2fas-light' ),
			'totp-configured'               => __(
				'Two-factor authentication has been configured and enabled.',
				'2fas-light' ),
			// General errors
			'default'                       => __( 'Something went wrong. Please try again.', '2fas-light' ),
			'db-error'                      => __( 'Something went wrong with database.', '2fas-light' ),
			'user-not-found'                => __( 'User has not been found.', '2fas-light' ),
			'login-token-not-found'         => __( 'Login token has not been found.', '2fas-light' ),
			'login-token-validation-failed' => __( 'Login token validation failed.', '2fas-light' ),
			'template-not-found'            => __( '2FAS plugin could not find a template.', '2fas-light' ),
			'template-compilation'          => __(
				'Error occurred in 2FAS plugin during template compilation.',
				'2fas-light' ),
			'template-rendering'            => __(
				'Error occurred in 2FAS plugin during template rendering.',
				'2fas-light' ),
			'authentication-expired'        => __(
				'Your authentication session has expired. Please log in again.',
				'2fas-light' ),
			'authentication-limit'          => __(
				'Attempt limit exceeded. Your account has been blocked for 5 minutes.',
				'2fas-light' ),
			'authentication-not-found'      => __( 'Authentication not found. Please log in again.', '2fas-light' ),
			'authentication-failed'         => __( 'Authentication failed. Please log in again.', '2fas-light' ),
			'totp-status-disabled'          => __(
				'Cannot perform this action because second factor is disabled.',
				'2fas' ),
		];
	}
}
