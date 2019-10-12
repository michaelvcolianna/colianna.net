<?php

namespace TwoFAS\Light\Step_Token;

use TwoFAS\Light\Exception\User_Not_Found_By_Step_Token_Cookie_Exception;
use TwoFAS\Light\User\User;

class Step_Token_Cookie_To_User_Mapper {
	
	/** @var Step_Token */
	private $step_token;
	
	/**
	 * @param Step_Token $step_token
	 */
	public function __construct( Step_Token $step_token ) {
		$this->step_token = $step_token;
	}
	
	/**
	 * @return User
	 * @throws User_Not_Found_By_Step_Token_Cookie_Exception
	 */
	public function get_user() {
		$token_cookie = $this->step_token->get_token_cookie();
		
		if ( ! $token_cookie || ! $token_cookie->get_user_login() ) {
			throw new User_Not_Found_By_Step_Token_Cookie_Exception();
		}
		
		$user = User::get_user_by_login( $token_cookie->get_user_login() );
		
		if ( ! $user ) {
			throw new User_Not_Found_By_Step_Token_Cookie_Exception();
		}
		
		if ( ! $this->step_token->validate_user_token( $user ) ) {
			throw new User_Not_Found_By_Step_Token_Cookie_Exception();
		}
		
		return $user;
	}
}
