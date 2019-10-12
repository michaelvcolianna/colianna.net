<?php

namespace TwoFAS\Light\Network;

use TwoFAS\Light\View\View_Renderer;

class Network_Setup_Warning_Printer {
	
	/** @var View_Renderer */
	private $view_renderer;
	
	/**
	 * @param View_Renderer $view_renderer
	 */
	public function __construct( View_Renderer $view_renderer ) {
		$this->view_renderer = $view_renderer;
	}
	
	public function print_multinetwork_activation_warning() {
		$this->render_warning( array( $this, 'render_multinetwork_activation_warning' ) );
	}
	
	public function print_multisite_activation_warning() {
		$this->render_warning( array( $this, 'render_multisite_activation_warning' ) );
	}
	
	/**
	 * @param callable $callback
	 */
	private function render_warning( $callback ) {
		add_action( 'admin_notices', $callback );
		add_action( 'network_admin_notices', $callback );
	}
	
	public function render_multinetwork_activation_warning() {
		echo $this->view_renderer->render( 'local_activation_on_multinetwork_error.html.twig', array() );
	}
	
	public function render_multisite_activation_warning() {
		echo $this->view_renderer->render( 'local_activation_on_multisite_error.html.twig', array() );
	}
}
