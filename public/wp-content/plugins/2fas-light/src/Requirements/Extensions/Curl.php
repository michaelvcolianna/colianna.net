<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements\Extensions;

class Curl extends Extension {
	
	/**
	 * @var string
	 */
	protected $extension_name = 'curl';
	
	/**
	 * @var string
	 */
	protected $message = 'cURL';
}
