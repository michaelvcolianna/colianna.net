<?php

namespace TwoFAS\Light\Migration;

interface Migration {
	
	/**
	 * @return void
	 */
	public function migrate();
}
