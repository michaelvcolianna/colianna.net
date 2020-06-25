<?php

namespace TwoFAS\Light\User;

use TwoFAS\Light\Exception\User_Not_Found_Exception;

class User_Repository {
	
	/**
	 * @param string $login
	 *
	 * @return User
	 * @throws User_Not_Found_Exception
	 */
	public function get_by_login( $login ) {
		$wp_user = get_user_by( 'login', $login );
		
		if ( ! $wp_user ) {
			throw new User_Not_Found_Exception();
		}
		
		return new User( $wp_user->ID );
	}
}
