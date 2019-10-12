<?php

namespace TwoFAS\Light\Migration;

class Migration_Remove_Rate_Prompt_Countdown_Start_From_Options implements Migration {
	
	const RATE_PROMPT_COUNTDOWN_START_FIELD_NAME = 'twofas_light_rate_prompt_countdown_start';
	
	/**
	 * @return void
	 */
	public function migrate() {
		delete_option( self::RATE_PROMPT_COUNTDOWN_START_FIELD_NAME );
	}
}
