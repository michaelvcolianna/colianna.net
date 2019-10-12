<?php

namespace TwoFAS\Light\Migration\Executor;

use TwoFAS\Light\App;
use TwoFAS\Light\Migration\Migration;
use TwoFAS\Light\Migration\Migration_Remove_Rate_Prompt_Countdown_Start_From_Options;

class Migration_List {
	
	/** @var App */
	private $app;
	
	/**
	 * Migration_List constructor.
	 *
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->app = $app;
	}
	
	/**
	 * @return Migration[]
	 */
	public function instantiate_migrations() {
		return array(
			new Migration_Remove_Rate_Prompt_Countdown_Start_From_Options(),
		);
	}
}
