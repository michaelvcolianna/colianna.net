<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements\Versions;

use TwoFAS\Light\Requirements\Requirement;

class PHP_Version extends Requirement {
	
	const PHP_MINIMUM_VERSION = '7.0';
	
	/**
	 * @inheritDoc
	 */
	public function is_satisfied(): bool {
		if ( ! is_null( $this->is_satisfied ) ) {
			return $this->is_satisfied;
		}
		
		return $this->is_satisfied = (bool) version_compare( PHP_VERSION, self::PHP_MINIMUM_VERSION, '>=' );
	}
	
	/**
	 * @inheritDoc
	 */
	public function get_message(): string {
		return sprintf(
		/* translators: %s: Minimum PHP version */
			__( '2FAS plugin does not support your PHP version. Minimum required version is %s.', '2fas-light' ),
			self::PHP_MINIMUM_VERSION );
	}
}
