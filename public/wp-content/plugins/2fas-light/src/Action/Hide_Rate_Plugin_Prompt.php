<?php

namespace TwoFAS\Light\Action;

use TwoFAS\Light\Result\Result_JSON;
use TwoFAS\Light\App;

class Hide_Rate_Plugin_Prompt extends Action {
	
	/**
	 * @param App $app
	 *
	 * @return Result_JSON
	 */
	public function handle( App $app ) {
		$can_hide = $app->get_rate_plugin_prompt()->should_display();
		
		if ( $can_hide ) {
			$app->get_user()->set_rate_plugin_prompt_hidden();
			$result = 'success';
		} else {
			$result = 'error';
		}
		
		return new Result_JSON( array(
			'twofas_light_result' => $result,
		) );
	}
}
