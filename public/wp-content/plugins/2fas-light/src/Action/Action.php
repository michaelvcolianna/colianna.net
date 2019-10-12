<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\App;

abstract class Action {
	
	/**
	 * @param App $app
	 *
	 * @return mixed
	 */
	abstract public function handle( App $app );
}
