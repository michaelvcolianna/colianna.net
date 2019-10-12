<?php

namespace TwoFAS\Light\View;

use TwoFAS\Light\Request\Request;

class Login_Footer_Renderer {
	
	/** @var View_Renderer */
	private $view_renderer;
	
	/** @var Request */
	private $request;
	
	/**
	 * Login_Footer_Renderer constructor.
	 *
	 * @param View_Renderer $view_renderer
	 * @param Request       $request
	 */
	public function __construct( View_Renderer $view_renderer, Request $request ) {
		$this->view_renderer = $view_renderer;
		$this->request       = $request;
	}
	
	public function render_footer() {
		$interim_login = $this->request->get_from_request( 'interim-login' );
		
		if ( null !== $interim_login ) {
			return;
		}
		
		echo $this->view_renderer->render( 'login_footer.html.twig', array() );
	}
}
