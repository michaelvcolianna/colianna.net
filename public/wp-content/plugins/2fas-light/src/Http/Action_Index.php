<?php
declare(strict_types=1);

namespace TwoFAS\Light\Http;

abstract class Action_Index {
	
	const TWOFAS_ACTION_KEY            = 'twofas_light_action';
	const TWOFAS_LIGHT_ADMIN_PAGE_SLUG = 'twofas-light-menu';
	
	const TWOFAS_ACTION_DEFAULT                     = '';
	const TWOFAS_ACTION_RELOAD_QR_CODE              = 'twofas-light-reload-qr-code';
	const TWOFAS_ACTION_CONFIGURE_TOTP              = 'twofas-light-configure-totp';
	const TWOFAS_ACTION_REMOVE_CONFIGURATION        = 'twofas-light-remove-configuration';
	const TWOFAS_ACTION_TOTP_ENABLE                 = 'twofas-light-totp-enable';
	const TWOFAS_ACTION_TOTP_DISABLE                = 'twofas-light-totp-disable';
	const TWOFAS_ACTION_REMOVE_TRUSTED_DEVICE       = 'twofas-light-remove-trusted-device';
	const TWOFAS_ACTION_HIDE_RATE_PLUGIN_PROMPT     = 'twofas-light-hide-notice';
	const TWOFAS_ACTION_POSTPONE_RATE_PLUGIN_PROMPT = 'twofas-light-postpone-notice';
}
