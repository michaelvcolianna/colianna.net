<?php

namespace TwoFAS\Light\Login;

class Included_Files {
	
	/**
	 * @return string[]
	 */
	public function get() {
		return get_included_files();
	}
}
