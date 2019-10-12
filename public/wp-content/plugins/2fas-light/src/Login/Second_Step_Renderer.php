<?php

namespace TwoFAS\Light\Login;

use TwoFAS\Light\App;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\Result\Result_HTML;
use TwoFAS\Light\View\View_Renderer;
use TwoFASLight_Error_Factory;
use WP_Error;

class Second_Step_Renderer {
	
	const LOGIN_ERROR_CODE = 'twofas_light_login_error';
	
	/** @var View_Renderer */
	private $view_renderer;
	
	/** @var Login_Params_Mapper */
	private $login_params_mapper;
	
	/** @var Request */
	private $request;
	
	/** @var TwoFASLight_Error_Factory */
	private $error_factory;
	
	/**
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->view_renderer       = $app->get_view_renderer();
		$this->login_params_mapper = $app->get_login_params_mapper();
		$this->request             = $app->get_request();
		$this->error_factory       = $app->get_error_factory();
	}
	
	/**
	 * @param string $error_message
	 *
	 * @return Result_HTML
	 */
	public function render( $error_message = '' ) {
		$html = $this->view_renderer->render( 'login_second_step.html.twig', array_merge(
			$this->login_params_mapper->map_from_request_for_view(),
			array(
				'twofas_light_login_error'            => $this->wrap_error_message_with_wp_error( $error_message ),
				'twofas_light_save_device_as_trusted' => $this->request->get_from_post( 'twofas_light_save_device_as_trusted' ),
				'login_form_action_url'               => esc_url( site_url( 'wp-login.php', 'login_post' ) ),
			)
		) );
		
		return new Result_HTML( $html );
	}
	
	/**
	 * @param string $error_message
	 *
	 * @return WP_Error|null
	 */
	private function wrap_error_message_with_wp_error( $error_message ) {
		if ( empty( $error_message ) ) {
			return null;
		}
		
		return $this->error_factory->create_wp_error( self::LOGIN_ERROR_CODE, $error_message );
	}
}
