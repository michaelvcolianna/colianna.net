<div class="error notice twofas-light-error-message">
	<p><strong>2FAS Light plugin requirements error</strong></p>
	<ul class="twofas-light-error-list">
		<?php foreach ( $error_messages as $error_message ): ?>
			<li><?php echo esc_html( $error_message ); ?></li>
		<?php endforeach; ?>
	</ul>
	<p>Plugin functionality cannot be enabled until this problem is solved. Please ask your hosting provider to support
		2FAS Light plugin's requirements.</p>
</div>
