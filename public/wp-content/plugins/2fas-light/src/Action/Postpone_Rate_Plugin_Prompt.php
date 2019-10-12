<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\App;

class Postpone_Rate_Plugin_Prompt extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return Result_JSON
	 */
	public function handle( App $app ) {
		$rate_plugin_prompt = $app->get_rate_plugin_prompt();
		$can_hide           = $rate_plugin_prompt->should_display();
		
		if ( $can_hide ) {
			$rate_plugin_prompt->restart_countdown();
			$result = 'success';
		} else {
			$result = 'error';
		}
		
		return new Result_JSON( array(
			'twofas_light_result' => $result,
		) );
	}
}
