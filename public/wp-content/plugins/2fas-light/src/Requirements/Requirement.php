<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements;

abstract class Requirement {
	
	/**
	 * @var bool
	 */
	protected $is_satisfied;
	
	/**
	 * @return bool
	 */
	abstract public function is_satisfied(): bool;
	
	/**
	 * @return string
	 */
	abstract public function get_message(): string;
}
