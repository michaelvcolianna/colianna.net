<?php
declare(strict_types=1);

namespace TwoFAS\Light\Http;

abstract class Controller {
	
	protected function view( string $template_name, array $data = array() ): View_Response {
		return new View_Response( $template_name, $data );
	}
	
	protected function redirect( URL_Interface $url ): Redirect_Response {
		return new Redirect_Response( $url );
	}
	
	protected function json( array $body, int $status_code = 200 ): JSON_Response {
		return new JSON_Response( $body, $status_code );
	}
}
