<?php

namespace TwoFAS\Light\Login;

use TwoFAS\Light\Request\Request;

class Login_Redirector_Factory {
	
	/**
	 * @param Login_Params_Mapper $login_params_mapper
	 * @param Request             $request
	 *
	 * @return Login_Redirector
	 */
	public function create( Login_Params_Mapper $login_params_mapper, Request $request ) {
		$current_path_checker = new Current_Path_Checker( new Included_Files(), ABSPATH );
		return new Login_Redirector( $current_path_checker, $login_params_mapper, $request );
	}
}
