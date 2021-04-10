<?php

use TwoFAS\Light\Http\Action_Index;
use TwoFAS\Light\Http\Controllers\{
	Show_Plugin_Page,
	Configure_Totp,
	Remove_Configuration,
	Reload_QR_Code,
	Enable_Totp,
	Disable_Totp,
	Remove_Trusted_Device,
	Generate_Backup_Codes,
	Print_Backup_Codes,
	Rate_Prompt
};

return [
	'routes' => [
		Action_Index::TWOFAS_LIGHT_ADMIN_PAGE_SLUG => [
			Action_Index::TWOFAS_ACTION_DEFAULT => [
				'controller' => Show_Plugin_Page::class,
				'action'     => 'show_page',
				'method'     => [ 'GET' ],
				'middleware' => ['user_logged']
			],
			Action_Index::TWOFAS_ACTION_CONFIGURE_TOTP => [
				'controller' => Configure_Totp::class,
				'action'     => 'configure',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax']
			],
			Action_Index::TWOFAS_ACTION_REMOVE_CONFIGURATION => [
				'controller' => Remove_Configuration::class,
				'action'     => 'remove',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'totp_enabled']
			],
			Action_Index::TWOFAS_ACTION_RELOAD_QR_CODE => [
				'controller' => Reload_QR_Code::class,
				'action'     => 'reload',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax']
			],
			Action_Index::TWOFAS_ACTION_TOTP_ENABLE => [
				'controller' => Enable_Totp::class,
				'action'     => 'enable',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax', 'totp_configured']
			],
			Action_Index::TWOFAS_ACTION_TOTP_DISABLE => [
				'controller' => Disable_Totp::class,
				'action'     => 'disable',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax', 'totp_configured', 'totp_enabled']
			],
			Action_Index::TWOFAS_ACTION_REMOVE_TRUSTED_DEVICE => [
				'controller' => Remove_Trusted_Device::class,
				'action'     => 'remove',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax', 'totp_configured']
			],
			Action_Index::TWOFAS_ACTION_POSTPONE_RATE_PLUGIN_PROMPT => [
				'controller' => Rate_Prompt::class,
				'action'     => 'postpone',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax']
			],
			Action_Index::TWOFAS_ACTION_HIDE_RATE_PLUGIN_PROMPT => [
				'controller' => Rate_Prompt::class,
				'action'     => 'hide',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax']
			],
			Action_Index::TWOFAS_ACTION_GENERATE_BACKUP_CODES   => [
				'controller' => Generate_Backup_Codes::class,
				'action'     => 'generate',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'ajax', 'totp_configured', 'totp_enabled']
			],
			Action_Index::TWOFAS_ACTION_PRINT_BACKUP_CODES      => [
				'controller' => Print_Backup_Codes::class,
				'action'     => 'print',
				'method'     => [ 'POST' ],
				'middleware' => ['user_logged', 'nonce', 'totp_configured', 'totp_enabled']
			],
		],
	]
];
