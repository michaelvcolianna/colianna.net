<?php
declare(strict_types=1);

namespace TwoFAS\Light\Requirements;

class Requirement_Checker {
	
	/**
	 * @var Requirement[]
	 */
	private $requirements = [];
	
	/**
	 * @var array
	 */
	private $not_satisfied = [];
	
	public function add_requirement( Requirement $requirement ): Requirement_Checker {
		$this->requirements[] = $requirement;
		
		return $this;
	}
	
	public function are_satisfied(): bool {
		$this->check_requirements();
		
		return empty( $this->not_satisfied );
	}

	public function get_not_satisfied(): array {
		return $this->not_satisfied;
	}
	
	private function check_requirements() {
		foreach ( $this->requirements as $requirement ) {
			if ( ! $requirement->is_satisfied() ) {
				$this->not_satisfied[] = $requirement->get_message();
			}
		}
	}
}
