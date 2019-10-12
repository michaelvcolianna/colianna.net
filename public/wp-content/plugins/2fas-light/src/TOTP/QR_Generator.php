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
		$site_name       = $this->get_site_name();
		$user_email      = rawurlencode( wp_get_current_user()->user_email );
		$description     = $this->get_description();
		$size            = 300;
		
		$message = "otpauth://totp/{$description}:{$user_email}?secret={$secret}&issuer={$site_name}";
		
		$endroid_qr_code
			->setText( $message )
			->setSize( $size )
			->setErrorCorrection( 'high' );
		
		return $endroid_qr_code->getDataUri();
	}
	
	/**
	 * @return string
	 */
	private function get_site_name() {
		if ( is_multisite() ) {
			$site_name = sprintf( '%s (%s)', $this->options->get_blog_name(), $this->options->get_network_name() );
		} else {
			$site_name = $this->options->get_blog_name();
		}
		return rawurlencode( $site_name );
	}
	
	/**
	 * @return string
	 */
	private function get_description() {
		$site_url = get_option( 'siteurl' );
		if ( $site_url ) {
			$parsed = parse_url( $site_url );
			if ( isset( $parsed['host'] ) ) {
				return rawurlencode( $parsed['host'] );
			}
		}
		return rawurlencode( 'WordPress Account' );
	}
}
