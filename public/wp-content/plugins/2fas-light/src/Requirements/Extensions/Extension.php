<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements\Extensions;

use TwoFAS\Light\Requirements\Requirement;

abstract class Extension extends Requirement {
	
	/**
	 * @var string
	 */
	protected $extension_name;
	
	/**
	 * @var string
	 */
	protected $message;
	
	/**
	 * @inheritDoc
	 */
	public function is_satisfied(): bool {
		if ( ! is_null( $this->is_satisfied ) ) {
			return $this->is_satisfied;
		}
		
		return $this->is_satisfied = extension_loaded( $this->extension_name );
	}
	
	/**
	 * @inheritDoc
	 */
	public function get_message(): string {
		return sprintf(
		/* translators: %s: Required extension */
			__( '2FAS Light plugin requires the <strong>%s</strong> extension to work properly.', '2fas-light' ),
			$this->message
		);
	}
}
