<?php
declare(strict_types=1);

namespace TwoFAS\Light\Http;

class Safe_Redirect_Response extends Redirect_Response {

	public function redirect() {
		nocache_headers();
		wp_safe_redirect( $this->url->get() );
		exit;
	}
}
