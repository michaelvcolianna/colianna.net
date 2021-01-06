<?php
declare(strict_types=1);

namespace TwoFAS\Light\Helpers;

use TwoFAS\Encryption\Random\{NonCryptographicalRandomIntGenerator, RandomStringGenerator, Str};

class Hash {
	
	const TRUSTED_DEVICE_KEY_LENGTH = 23;
	const STEP_TOKEN_KEY_LENGTH     = 128;
	const SESSION_KEY_LENGTH        = 16;
	
	public static function get_trusted_device_id(): string {
		$str = self::generate( self::TRUSTED_DEVICE_KEY_LENGTH );
		
		return md5( $str->__toString() );
	}
	
	public static function get_step_token(): string {
		$str = self::generate( self::STEP_TOKEN_KEY_LENGTH );
		
		return $str->__toString();
	}
	
	public static function get_session_id(): string {
		$str = self::generate( self::SESSION_KEY_LENGTH );
		
		return $str->toBase64()->__toString();
	}
	
	private static function generate( int $length ): Str {
		$generator = new RandomStringGenerator( new NonCryptographicalRandomIntGenerator() );
		
		return $generator->string( $length );
	}
}
