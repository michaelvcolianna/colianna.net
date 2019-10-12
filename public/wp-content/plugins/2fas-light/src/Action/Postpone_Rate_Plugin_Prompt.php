<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Rate_Plugin_Prompt\Rate_Plugin_Prompt;
use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\App;
use TwoFAS\Light\Exception\DateTime_Creation_Exception;

class Postpone_Rate_Plugin_Prompt extends Action {
	
	/** @var Rate_Plugin_Prompt */
	private $rate_prompt;
	
	/**
	 * @param App $app
	 *
	 * @return Result_JSON
	 */
	public function handle( App $app ) {
		$this->rate_prompt = $app->get_rate_plugin_prompt();
		$can_hide          = $this->rate_prompt->should_display();
		
		if ( $can_hide ) {
			$result = $this->restart_countdown();
		} else {
			$result = 'error';
		}
		
		return new Result_JSON( array(
			'twofas_light_result' => $result,
		) );
	}
	
	/**
	 * @return string
	 */
	private function restart_countdown() {
		try {
			$this->rate_prompt->restart_countdown();
		} catch ( DateTime_Creation_Exception $e ) {
			return 'error';
		}
		return 'success';
	}
}
