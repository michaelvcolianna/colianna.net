<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements\Extensions;

class MbString extends Extension {
	
	/**
	 * @var string
	 */
	protected $extension_name = 'mbstring';
	
	/**
	 * @var string
	 */
	protected $message = 'Multibyte String';
}
