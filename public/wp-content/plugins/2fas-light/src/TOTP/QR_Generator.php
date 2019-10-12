<?php

namespace TwoFAS\Light\TOTP;

use Endroid\QrCode\QrCode;
use TwoFAS\Light\Option\Option;

class QR_Generator {
	
	/** @var Option */
	private $options;
	
	/**
	 * QR_Generator constructor.
	 *
	 * @param Option $options
	 */
	public function __construct( Option $options ) {
		$this->options = $options;
	}
	
	/**
	 * @param  string $secret
	 *
	 * @return string
	 */
	public function generate_qr_code( $secret ) {
		// TOTP metadata
		$endroid_qr_code = new QrCode();
		$blog_name       = $this->options->get_url_encoded_blog_name();
		$user            = wp_get_current_user();
		$user_email      = $user->user_email;
		$description     = urlencode( 'WordPress Account' );
		$site_url        = get_option( 'siteurl' );
		$size            = 300;
		
		if ( $site_url ) {
			$parsed = parse_url( $site_url );
			
			if ( isset( $parsed['host'] ) ) {
				$description = $parsed['host'];
			}
		}
		
		$message = "otpauth://totp/{$description}:$user_email?secret={$secret}&issuer={$blog_name}";
		
		$endroid_qr_code
			->setText( $message )
			->setSize( $size )
			->setErrorCorrection( 'high' );
		
		return $endroid_qr_code->getDataUri();
	}
}
