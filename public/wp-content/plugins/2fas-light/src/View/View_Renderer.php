<?php

namespace TwoFAS\Light\View;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;
use TwoFAS\Light\Exception\DateTime_Creation_Exception;
use TwoFAS\Light\Time\Time;
use WhichBrowser\Parser;

class View_Renderer {
	
	const ERROR_TEMPLATE_NOT_FOUND = '2FAS Light plugin could not find a template.';
	const ERROR_COMPILATION_FAILED = 'Error occurred in 2FAS plugin during template compilation.';
	const ERROR_RENDERING_FAILED   = 'Error occurred in 2FAS plugin during template rendering.';
	const ERROR_PARSING_DATE       = 'Could not parse date';
	
	/**
	 * @var Environment
	 */
	private $twig;
	
	/** @var Time */
	private $time;
	
	/**
	 * @var Parser
	 */
	private $browser;
	
	/**
	 * @param Time   $time
	 * @param Parser $browser
	 */
	public function __construct( Time $time, Parser $browser ) {
		$this->time    = $time;
		$this->browser = $browser;
	}
	
	public function init() {
		$twig_loader = new FilesystemLoader( TWOFAS_LIGHT_TEMPLATES_PATH );
		$this->twig  = new Environment( $twig_loader );
		$this->twig->addFunction(
			new TwigFunction(
				'timestamp_to_wp_datetime',
				[ $this, 'timestamp_to_wp_datetime' ]
			)
		);
		$this->twig->addFunction( new TwigFunction( 'describe_device', [ $this, 'describe_device' ] ) );
		$this->twig->addFunction( new TwigFunction( 'login_footer', 'login_footer' ) );
		$this->twig->addFunction( new TwigFunction( 'login_header', 'login_header' ) );
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
		$arguments['nonce_field']                  = wp_nonce_field(
			'twofas_light_ajax',
			$name = '_wpnonce',
			$referer = false,
			$echo = false
		);
		
		try {
			return $this->twig->render( $template, $arguments );
		} catch ( LoaderError $e ) {
			return $this->render_error( self::ERROR_TEMPLATE_NOT_FOUND );
		} catch ( SyntaxError $e ) {
			return $this->render_error( self::ERROR_COMPILATION_FAILED );
		} catch ( RuntimeError $e ) {
			return $this->render_error( self::ERROR_RENDERING_FAILED );
		}
	}
	
	/**
	 * @param string $user_agent
	 *
	 * @return string
	 */
	public function describe_device( $user_agent ) {
		$this->browser->analyse( $user_agent );
		
		return $this->browser->browser->toString() . ' on ' . $this->browser->os->toString();
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
