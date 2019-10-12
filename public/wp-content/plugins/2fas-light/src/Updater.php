<?php

namespace TwoFAS\Light;

use TwoFAS\Light\Migration\Executor\Migration_Executor;
use TwoFAS\Light\Option\Option;

class Updater {
	
	/** @var Option */
	private $option;
	
	/** @var Migration_Executor */
	private $migration_executor;
	
	/**
	 * Updater constructor.
	 *
	 * @param Option             $option
	 * @param Migration_Executor $migration_executor
	 */
	public function __construct( Option $option, Migration_Executor $migration_executor ) {
		$this->option             = $option;
		$this->migration_executor = $migration_executor;
	}
	
	/**
	 * @param string $running_version
	 */
	public function update_if_needed( $running_version ) {
		$stored_version = $this->option->get_plugin_version();
		
		if ( $stored_version !== $running_version ) {
			$this->migration_executor->migrate();
			$this->option->update_plugin_version( $running_version );
		}
	}
}
