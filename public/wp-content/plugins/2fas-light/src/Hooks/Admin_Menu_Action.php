<?php
declare(strict_types=1);

namespace TwoFAS\Light\Hooks;

use TwoFAS\Light\Http\View_Response;
use TwoFAS\Light\Templates\Twig;

class Admin_Menu_Action implements Hook_Interface {
	
	/**
	 * @var string
	 */
	private $menu_id = 'twofas-light-menu';
	
	/**
	 * @var string
	 */
	private $menu_name = '2FAS Light';
	
	/**
	 * @var string
	 */
	private $menu_title = '2FAS Light';
	
	/**
	 * @var string
	 */
	private $capability = 'read';
	
	/**
	 * @var Twig
	 */
	private $twig;
	
	/**
	 * @param Twig $twig
	 */
	public function __construct( Twig $twig ) {
		$this->twig = $twig;
	}
	
	/**
	 * @var View_Response
	 */
	protected $response;
	
	public function register_hook() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}
	
	/**
	 * @param View_Response $response
	 */
	public function set_response( View_Response $response ) {
		$this->response = $response;
	}
	
	public function add_menu() {
		add_menu_page(
			$this->menu_title,
			$this->menu_name,
			$this->capability,
			$this->menu_id,
			[ $this, 'render' ],
			TWOFAS_LIGHT_PLUGIN_URL . '/assets/img/icon.svg'
		);
	}
	
	public function render() {
		echo $this->twig->render_view( $this->response->get_template(), $this->response->get_data() );
	}
}
