<?php

namespace TwoFAS\Light\View;

use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;
use TwoFAS\Light\Browser\Browser;
use TwoFAS\Light\Exception\DateTime_Creation_Exception;
use TwoFAS\Light\Time\Time;

class View_Renderer {
	
	const ERROR_TEMPLATE_NOT_FOUND = '2FAS Light plugin could not find a template.';
	const ERROR_COMPILATION_FAILED = 'Error occurred in 2FAS plugin during template compilation.';
	const ERROR_RENDERING_FAILED = 'Error occurred in 2FAS plugin during template rendering.';
	const ERROR_PARSING_DATE = 'Could not parse date';
	
	/**
	 * @var Twig_Environment
	 */
	private $twig;
	
	/** @var Time */
	private $time;
	
	/**
	 * View_Renderer constructor.
	 *
	 * @param Time $time
	 */
	public function __construct( Time $time ) {
		$this->time = $time;
	}
	
	public function init() {
		$twig_loader          = new Twig_Loader_Filesystem( TWOFAS_LIGHT_TEMPLATES_PATH );
		$this->twig           = new Twig_Environment( $twig_loader );
		$this->twig->addFunction( new Twig_SimpleFunction( 'timestamp_to_wp_datetime',
			array( $this, 'timestamp_to_wp_datetime' ) ) );
		$this->twig->addFunction( new Twig_SimpleFunction( 'describe_device', array( $this, 'describe_device' ) ) );
		$this->twig->addFunction( new Twig_SimpleFunction( 'login_footer', 'login_footer' ) );
		$this->twig->addFunction( new Twig_SimpleFunction( 'login_header', 'login_header' ) );
	}
	
	/**
	 * @param $template
	 * @param $arguments
	 *
	 * @return string
	 */
	public function render( $template, $arguments ) {
		$arguments['twofas_plugin_path']           = TWOFAS_LIGHT_URL;
		$arguments['twofas_admin_path']            = TWOFAS_LIGHT_WP_ADMIN_PATH;
		$arguments['twofas_full_plugin_is_active'] = defined( 'TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG' );
		$arguments['login_url']                    = wp_login_url();
		$arguments['nonce_field']                  = wp_nonce_field( 'twofas_light_ajax', $name = '_wpnonce',
			$referer = false, $echo = false );
		
		try {
			return $this->twig->render( $template, $arguments );
		} catch ( Twig_Error_Loader $e ) {
			return $this->render_error( self::ERROR_TEMPLATE_NOT_FOUND );
		} catch ( Twig_Error_Syntax $e ) {
			return $this->render_error( self::ERROR_COMPILATION_FAILED );
		} catch ( Twig_Error_Runtime $e ) {
			return $this->render_error( self::ERROR_RENDERING_FAILED );
		}
	}
	
	/**
	 * @param $user_agent
	 *
	 * @return string
	 */
	public function describe_device( $user_agent ) {
		$twofas_browser = new Browser( $user_agent );
		
		return $twofas_browser->describe();
	}
	
	/**
	 * @param string $message
	 *
	 * @return string
	 */
	private function render_error( $message ) {
		return '<div class="twofas-light-view-renderer-error-container"><div class="notice notice-error error twofas-light-view-renderer-error"><p>' . $message . '</p></div></div>';
	}
	
	/**
	 * @param int $timestamp
	 *
	 * @return string
	 */
	public function timestamp_to_wp_datetime( $timestamp ) {
		try {
			return $this->time->format_to_string_using_wp_settings( $timestamp );
		} catch ( DateTime_Creation_Exception $e ) {
			return self::ERROR_PARSING_DATE;
		}
	}
}
