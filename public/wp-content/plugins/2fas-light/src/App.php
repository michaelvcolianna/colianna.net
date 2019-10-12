<?php

namespace TwoFAS\Light;

use TwoFAS\Encryption\Random\RandomGenerator;
use TwoFAS\Light\Cookie\Cookie;
use TwoFAS\Light\Device\Trusted_Device_Cookie_Manager;
use TwoFAS\Light\Device\Trusted_Device_Manager;
use TwoFAS\Light\Hash\Hash_Generator;
use TwoFAS\Light\Login\Login_Params_Mapper;
use TwoFAS\Light\Login\Login_Redirector;
use TwoFAS\Light\Login\Login_Redirector_Factory;
use TwoFAS\Light\Login\Second_Step_Renderer;
use TwoFAS\Light\Migration\Executor\Migration_Executor;
use TwoFAS\Light\Migration\Executor\Migration_List;
use TwoFAS\Light\Option\Option;
use TwoFAS\Light\Action\Router;
use TwoFAS\Light\Rate_Plugin_Prompt\Rate_Plugin_Prompt;
use TwoFAS\Light\Request\Request;
use TwoFAS\Light\Request\Request_Context;
use TwoFAS\Light\Step_Token\Step_Token;
use TwoFAS\Light\Step_Token\Step_Token_Cookie_To_User_Mapper;
use TwoFAS\Light\Step_Token\Step_Token_Validator;
use TwoFAS\Light\Time\Time;
use TwoFAS\Light\TOTP\Base32_Alphabet;
use TwoFAS\Light\TOTP\Base32_Decoder;
use TwoFAS\Light\TOTP\Code_Generator;
use TwoFAS\Light\TOTP\Code_Validator;
use TwoFAS\Light\TOTP\Format_Validator;
use TwoFAS\Light\TOTP\QR_Generator;
use TwoFAS\Light\TOTP\TOTP_Login_Validator;
use TwoFAS\Light\TOTP\Secret_Generator;
use TwoFAS\Light\TOTP\Single_Code_Generator;
use TwoFAS\Light\User\User;
use TwoFAS\Light\View\View_Renderer;
use TwoFASLight_Error_Factory;

abstract class App {
	
	/**
	 * @var Request_Context
	 */
	protected $request_context;
	
	/**
	 * @var Request
	 */
	protected $request;
	
	/**
	 * @var Router
	 */
	protected $router;
	
	/**
	 * @var View_Renderer
	 */
	protected $view_renderer;
	
	/**
	 * @var TOTP_Login_Validator
	 */
	protected $totp_login_validator;
	
	/**
	 * @var QR_Generator
	 */
	protected $totp_qr_generator;
	
	/**
	 * @var Base32_Alphabet
	 */
	protected $base32_alphabet;
	
	/**
	 * @var Secret_Generator
	 */
	protected $totp_secret_generator;
	
	/**
	 * @var User
	 */
	protected $user;
	
	/**
	 * @var Option
	 */
	protected $options;
	
	/**
	 * @var Cookie
	 */
	protected $cookie;
	
	/**
	 * @var Second_Step_Renderer
	 */
	protected $second_step_renderer;
	
	/**
	 * @var Time
	 */
	protected $time;
	
	/**
	 * @var TwoFASLight_Error_Factory
	 */
	protected $error_factory;
	
	/**
	 * @var Hash_Generator
	 */
	protected $hash_generator;
	
	/**
	 * @var Format_Validator
	 */
	protected $totp_format_validator;
	
	/**
	 * @var Rate_Plugin_Prompt
	 */
	protected $rate_plugin_prompt;
	
	/**
	 * @var Updater
	 */
	protected $updater;
	
	/**
	 * App constructor.
	 */
	public function __construct() {
		$this->request_context = new Request_Context();
		$this->request_context->fill_with_global_arrays( $_GET, $_POST, $_SERVER, $_COOKIE, $_REQUEST );
		
		$this->router = new Router();
		
		$this->time = new Time();
		
		$this->view_renderer = new View_Renderer( $this->time );
		$this->view_renderer->init();
		
		$this->user = new User( wp_get_current_user()->ID );
		
		$this->options = new Option();
		
		$this->totp_qr_generator = new QR_Generator( $this->get_options() );
		
		$this->totp_format_validator = new Format_Validator();
		
		$this->totp_login_validator = new TOTP_Login_Validator();
		
		$this->base32_alphabet = new Base32_Alphabet();
		
		$this->totp_secret_generator = new Secret_Generator( $this->base32_alphabet );
		
		$this->error_factory = new TwoFASLight_Error_Factory();
		
		$this->hash_generator = new Hash_Generator( new RandomGenerator() );
		
		$this->rate_plugin_prompt = new Rate_Plugin_Prompt( $this->time, $this->user );
		
		$migration_executor = new Migration_Executor( new Migration_List( $this ) );
		$this->updater      = new Updater( $this->options, $migration_executor );
	}
	
	/**
	 * @return View_Renderer
	 */
	public function get_view_renderer() {
		return $this->view_renderer;
	}
	
	/**
	 * @param string $totp_secret
	 *
	 * @return Code_Generator
	 */
	public function get_totp_code_generator( $totp_secret ) {
		return new Code_Generator(
			$totp_secret,
			$this->get_time(),
			$this->totp_format_validator,
			new Single_Code_Generator( Code_Generator::KEY_REGENERATION ),
			new Base32_Decoder( $this->base32_alphabet )
		);
	}
	
	/**
	 * @param string $totp_secret
	 *
	 * @return Code_Validator
	 */
	public function get_totp_code_validator( $totp_secret ) {
		return new Code_Validator( $this->get_totp_code_generator( $totp_secret ) );
	}
	
	/**
	 * @return TOTP_Login_Validator
	 */
	public function get_totp_login_validator() {
		return $this->totp_login_validator;
	}
	
	/**
	 * @return QR_Generator
	 */
	public function get_totp_qr_generator() {
		return $this->totp_qr_generator;
	}
	
	/**
	 * @return Secret_Generator
	 */
	public function get_totp_secret_generator() {
		return $this->totp_secret_generator;
	}
	
	/**
	 * @return User
	 */
	public function get_user() {
		return $this->user;
	}
	
	/**
	 * @return Option
	 */
	public function get_options() {
		return $this->options;
	}
	
	/**
	 * @return Request
	 */
	public function get_request() {
		return $this->request;
	}
	
	/**
	 * @return Cookie
	 */
	public function get_cookie() {
		return Cookie::create();
	}
	
	/**
	 * @param User $user
	 *
	 * @return Trusted_Device_Cookie_Manager
	 */
	public function get_trusted_device_cookie_manager( $user ) {
		return new Trusted_Device_Cookie_Manager( $this, $user );
	}
	
	/**
	 * @param User $user
	 *
	 * @return Trusted_Device_Manager
	 */
	public function get_trusted_device_manager( $user ) {
		return new Trusted_Device_Manager( $this, $user );
	}
	
	/**
	 * @return Step_Token
	 */
	public function get_step_token() {
		return Step_Token::create();
	}
	
	/**
	 * @return Step_Token_Validator
	 */
	public function get_step_token_validator() {
		return Step_Token_Validator::create();
	}
	
	/**
	 * @return Step_Token_Cookie_To_User_Mapper
	 */
	public function get_step_token_cookie_to_user_mapper() {
		return new Step_Token_Cookie_To_User_Mapper( $this->get_step_token() );
	}
	
	/**
	 * @return Login_Params_Mapper
	 */
	public function get_login_params_mapper() {
		return new Login_Params_Mapper( $this->request );
	}
	
	/**
	 * @return Login_Redirector
	 */
	public function get_login_redirector() {
		$login_redirector_factory = new Login_Redirector_Factory();
		return $login_redirector_factory->create( $this->get_login_params_mapper(), $this->request );
	}
	
	/**
	 * @return Second_Step_Renderer
	 */
	public function get_second_step_renderer() {
		return new Second_Step_Renderer( $this );
	}
	
	/**
	 * @return Time
	 */
	public function get_time() {
		return $this->time;
	}
	
	/**
	 * @return TwoFASLight_Error_Factory
	 */
	public function get_error_factory() {
		return $this->error_factory;
	}
	
	/**
	 * @return Hash_Generator
	 */
	public function get_hash_generator() {
		return $this->hash_generator;
	}
	
	/**
	 * @return Rate_Plugin_Prompt
	 */
	public function get_rate_plugin_prompt() {
		return $this->rate_plugin_prompt;
	}
	
	/**
	 * @return Updater
	 */
	public function get_updater() {
		return $this->updater;
	}
	
	abstract public function run();
}
