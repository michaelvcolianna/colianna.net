<?php
declare(strict_types=1);

namespace TwoFAS\Light\Hooks;

use TwoFAS\Light\Http\Action_Index;

class Enqueue_Scripts_Action implements Hook_Interface {

	public function register_hook() {
		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public function enqueue_scripts() {
		wp_enqueue_script(
			'twofas-light-js',
			TWOFAS_LIGHT_PLUGIN_URL . '/assets/js/twofas_light.js',
			[ 'jquery' ],
			TWOFAS_LIGHT_PLUGIN_VERSION,
			true );

		wp_localize_script(
			'twofas-light-js',
			'twofas_light',
			[
				'ajax_url' => admin_url( 'admin.php' ),
				'twofas_light_menu_page' => Action_Index::TWOFAS_LIGHT_ADMIN_PAGE_SLUG
			] );
	}

}
