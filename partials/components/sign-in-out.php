<li class="main-nav__items__item">
	<?php if ( ! is_user_logged_in() ) : ?>
		<div id="wpo365OpenIdRedirect" class="wpo365-mssignin-wrapper">
			<div class="wpo365-mssignin-spacearound">
				<div class="wpo365-mssignin-button" onclick="window.wpo365.pintraRedirect.toMsOnline()"
					title="<?php pll_esc_html_e( 'Kirjaudu sisään edu.hel.fi' ); ?>">
					<img class="sign-svg" src="<?php echo esc_url( UTILS()->get_image_uri() . '/sign-in.svg' ); ?>" alt=""/>
			</div>
		</div>
	</div>

	<?php else : ?>
		<a href="<?php echo esc_url( wp_logout_url() ); ?>"
		   title="<?php pll_esc_html_e( 'Kirjaudu ulos edu.hel.fi' ); ?>">
			<img class="sign-svg" src="<?php echo esc_url( UTILS()->get_image_uri() . '/sign-out.svg' ); ?>" alt=""/>
		</a>
	<?php endif; ?>
</li>
