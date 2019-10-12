<?php

namespace TwoFAS\Light\Migration\Executor;

class Migration_Executor {
	
	/** @var Migration_List */
	private $migration_list;
	
	/**
	 * Migration_Executor constructor.
	 *
	 * @param Migration_List $migration_list
	 */
	public function __construct( Migration_List $migration_list ) {
		$this->migration_list = $migration_list;
	}
	
	public function migrate() {
		$migrations = $this->migration_list->instantiate_migrations();
		foreach ( $migrations as $migration ) {
			$migration->migrate();
		}
	}
}
