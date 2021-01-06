<?php
declare(strict_types=1);

namespace TwoFAS\Light\Helpers;

interface Environment_Interface {
	
	public function get_php_version(): string;
	
	public function get_wordpress_version(): string;
}
