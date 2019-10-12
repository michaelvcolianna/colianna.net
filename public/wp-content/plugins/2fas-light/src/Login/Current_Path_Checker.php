<?php

namespace TwoFAS\Light\Login;

class Current_Path_Checker {
	
	/** @var Included_Files */
	private $included_files;
	
	/** @var string */
	private $abspath;
	
	/**
	 * @param Included_Files $included_files
	 * @param string         $abspath Should be equal to the ABSPATH WordPress constant.
	 */
	public function __construct( Included_Files $included_files, $abspath ) {
		$this->included_files = $included_files;
		$this->abspath        = $abspath;
	}
	
	/**
	 * @param string $relative_path Path relative to ABSPATH, without preceding slash, e.g. "wp-config.php".
	 *
	 * @return bool
	 */
	public function is_current_path( $relative_path ) {
		$absolute_path = $this->abspath . $relative_path;
		$normalized_path = $this->normalize_directory_separators( $absolute_path );
		$normalized_included_files = $this->normalize_directory_separators( $this->included_files->get() );
		return $normalized_path === $normalized_included_files[0];
	}
	
	/**
	 * @param string|string[] $paths
	 *
	 * @return string|string[]
	 */
	private function normalize_directory_separators( $paths ) {
		return str_replace( '\\', '/', $paths );
	}
}
