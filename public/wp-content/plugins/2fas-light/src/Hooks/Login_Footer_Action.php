<?php
declare(strict_types=1);

namespace TwoFAS\Light\Hooks;

use TwoFAS\Light\Http\Request;
use TwoFAS\Light\Templates\Twig;

class Login_Footer_Action implements Hook_Interface {

	/**
	 * @var Twig
	 */
	private $twig;

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @param Twig    $twig
	 * @param Request $request
	 */
	public function __construct( Twig $twig, Request $request ) {
		$this->twig    = $twig;
		$this->request = $request;
	}

	public function register_hook() {
		$interim_login = $this->request->request( 'interim-login' );

		if ( empty( $interim_login ) ) {
			add_action( 'login_footer', [ $this, 'add_footer' ] );
		}
	}

	public function add_footer() {
		echo $this->twig->render_view( 'login_footer.html.twig' );
	}
}
