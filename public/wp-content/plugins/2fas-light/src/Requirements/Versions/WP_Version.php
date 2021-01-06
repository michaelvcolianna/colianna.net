<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements\Versions;

use TwoFAS\Light\Requirements\Requirement;

class WP_Version extends Requirement {
	
	const WP_MINIMUM_VERSION = '4.9';
	
	/**
	 * @inheritDoc
	 */
	public function is_satisfied(): bool {
		if ( ! is_null( $this->is_satisfied ) ) {
			return $this->is_satisfied;
		}
		
		return $this->is_satisfied = (bool) version_compare(
			get_bloginfo( 'version' ),
			self::WP_MINIMUM_VERSION,
			'>=' );
	}
	
	/**
	 * @inheritDoc
	 */
	public function get_message(): string {
		return sprintf(
		/* translators: %s: Minimum WordPress version */
			__( '2FAS plugin does not support your WordPress version. Minimum required version is %s.', '2fas' ),
			self::WP_MINIMUM_VERSION );
	}
}
