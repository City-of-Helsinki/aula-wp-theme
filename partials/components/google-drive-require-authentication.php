<?php

if ( ! is_user_logged_in() ) {
	return;
}

// Google OAuth URL
$google_oauth_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode( GOOGLE_OAUTH_SCOPE ) . '&redirect_uri=' . GOOGLE_REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=offline&prompt=consent';
$block_heading    = isset( $args['heading'] ) ? $args['heading'] : null;
$block_error      = isset( $args['error'] ) ? $args['error'] : null;
$button_text      = isset( $args['button_text'] ) ? $args['button_text'] : pll_esc_html__( 'Yhdistä Google Drive' );
?>
<div class="tab-content-drive-auth">
	<?php if ( ! empty( $block_heading ) ) : ?>
		<h2>
			<?php echo esc_html( $block_heading ); ?>
		</h2>
	<?php endif; ?>
	<?php if ( ! empty( $block_error ) ) : ?>
		<p>
			<?php echo esc_html( $block_error ); ?>
		</p>
	<?php endif; ?>
	<a href="<?php echo esc_url( $google_oauth_url ); ?>" class="btn btn-aula btn-aula--border">
		<?php echo esc_html( $button_text ); ?>
	</a>
</div>
