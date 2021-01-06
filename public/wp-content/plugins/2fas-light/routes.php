<?php

use TwoFAS\Light\Http\Action_Index;
use TwoFAS\Light\Http\Controllers\Show_Plugin_Page;
use TwoFAS\Light\Http\Controllers\Configure_Totp;
use TwoFAS\Light\Http\Controllers\Remove_Totp;
use TwoFAS\Light\Http\Controllers\Reload_QR_Code;
use TwoFAS\Light\Http\Controllers\Enable_Totp;
use TwoFAS\Light\Http\Controllers\Disable_Totp;
use TwoFAS\Light\Http\Controllers\Remove_Trusted_Device;
use TwoFAS\Light\Http\Controllers\Rate_Prompt;

return [
	'routes' => [
		Action_Index::TWOFAS_LIGHT_ADMIN_PAGE_SLUG => [
			Action_Index::TWOFAS_ACTION_DEFAULT => [
				'controller' => Show_Plugin_Page::class,
				'action'     => 'show_page',
				'method'     => [ 'GET' ],
				'middleware' => []
			],
			Action_Index::TWOFAS_ACTION_CONFIGURE_TOTP => [
				'controller' => Configure_Totp::class,
				'action'     => 'configure',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'ajax']
			],
			Action_Index::TWOFAS_ACTION_REMOVE_CONFIGURATION => [
				'controller' => Remove_Totp::class,
				'action'     => 'remove',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'totp_enabled']
			],
			Action_Index::TWOFAS_ACTION_RELOAD_QR_CODE => [
				'controller' => Reload_QR_Code::class,
				'action'     => 'reload',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'ajax']
			],
			Action_Index::TWOFAS_ACTION_TOTP_ENABLE => [
				'controller' => Enable_Totp::class,
				'action'     => 'enable',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'ajax', 'totp_configured']
			],
			Action_Index::TWOFAS_ACTION_TOTP_DISABLE => [
				'controller' => Disable_Totp::class,
				'action'     => 'disable',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'ajax', 'totp_configured', 'totp_enabled']
			],
			Action_Index::TWOFAS_ACTION_REMOVE_TRUSTED_DEVICE => [
				'controller' => Remove_Trusted_Device::class,
				'action'     => 'remove',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'ajax', 'totp_configured']
			],
			Action_Index::TWOFAS_ACTION_POSTPONE_RATE_PLUGIN_PROMPT => [
				'controller' => Rate_Prompt::class,
				'action'     => 'postpone',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'ajax']
			],
			Action_Index::TWOFAS_ACTION_HIDE_RATE_PLUGIN_PROMPT => [
				'controller' => Rate_Prompt::class,
				'action'     => 'hide',
				'method'     => [ 'POST' ],
				'middleware' => ['nonce', 'ajax']
			],
		],
	]
];
