<?php

class TwoFASLight_System_Requirements_Checker {
	
	/** @var TwoFASLight_System_Versions_Provider */
	private $versions_provider;
	
	/** @var TwoFASLight_Requirements_Spec */
	private $requirements_spec;
	
	/**
	 * TwoFASLight_System_Requirements_Checker constructor.
	 *
	 * @param TwoFASLight_System_Versions_Provider $versions_provider
	 * @param TwoFASLight_Requirements_Spec        $requirements_spec
	 */
	public function __construct(
		TwoFASLight_System_Versions_Provider $versions_provider,
		TwoFASLight_Requirements_Spec $requirements_spec
	) {
		$this->versions_provider = $versions_provider;
		$this->requirements_spec = $requirements_spec;
	}
	
	/**
	 * @throws TwoFASLight_Unmet_System_Requirements_Exception
	 */
	public function check_system_requirements() {
		$errors = array();
		$missing_php_extensions = $this->check_php_extensions_presence();
		
		if ( ! $this->check_php_version() ) {
			$errors[] = sprintf(
				'PHP version is older than required. Required version: %s. Your version: %s.',
				$this->requirements_spec->get_minimum_php_version(),
				$this->versions_provider->get_php_version()
			);
		}
		
		if ( ! $this->check_wp_version() ) {
			$errors[] = sprintf(
				'WordPress version is older than required. Required version: %s. Your version: %s.',
				$this->requirements_spec->get_minimum_wp_version(),
				$this->versions_provider->get_wp_version()
			);
		}
		
		if ( ! empty( $missing_php_extensions ) ) {
			$errors[] = sprintf( 'Some required PHP extensions are missing: %s.',
				implode( ', ', $missing_php_extensions ) );
		}
		
		if ( ! empty( $errors ) ) {
			throw new TwoFASLight_Unmet_System_Requirements_Exception( $errors );
		}
	}
	
	/**
	 * @return bool
	 */
	private function check_php_version() {
		$current_php_version = $this->versions_provider->get_php_version();
		
		return version_compare( $current_php_version, $this->requirements_spec->get_minimum_php_version(), '>=' );
	}
	
	/**
	 * @return bool
	 */
	private function check_wp_version() {
		$wp_version = $this->versions_provider->get_wp_version();
		
		return version_compare( $wp_version, $this->requirements_spec->get_minimum_wp_version(), '>=' );
	}
	
	/**
	 * @return array
	 */
	private function check_php_extensions_presence() {
		$missing_php_extensions = array();
		
		foreach ( $this->requirements_spec->get_required_php_extensions() as $extension ) {
			if ( ! $this->versions_provider->is_php_extension_loaded( $extension ) ) {
				$missing_php_extensions[] = $extension;
			}
		}
		
		return $missing_php_extensions;
	}
}
