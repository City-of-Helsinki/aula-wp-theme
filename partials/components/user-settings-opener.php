<li class="main-nav__items__item">
	<?php if ( ! is_user_logged_in() ) : ?>
		<div id="wpo365OpenIdRedirect" class="wpo365-mssignin-wrapper">
			<div class="wpo365-mssignin-spacearound">
				<div class="wpo365-mssignin-button" onclick="window.wpo365.pintraRedirect.toMsOnline()"
				     title="<?php pll_esc_html_e( 'Kirjaudu sisään edu.hel.fi' ); ?>">
					<img class="sign-svg" src="<?php echo esc_url( UTILS()->get_image_uri() . '/sign-in.svg' ); ?>"
					     alt=""/>
				</div>
			</div>
		</div>
	<?php else : ?>
		<a href="#" class="user-settings-modal-opener" title="<?php pll_esc_html_e( 'Avaa tai sulje toiminnot' ); ?>"
		   aria-haspopup="true"
		   aria-expanded="false">
			<div id="main-nav-dummy-avatar">
				<?php Utils()->the_svg( 'dummy-person-image' ); ?>
			</div>
			<div id="main-nav-multiavatar" aria-hidden="true">

			</div>
			<div class="user-settings-modal-opener__icon">
				<?php Utils()->the_svg( 'arrow-icon' ); ?>
			</div>
		</a>
		<ul class="main-nav__user-settings-menu" aria-label="<?php pll_esc_html_e( 'Käyttäjämenu' ); ?>" tabindex="-1">
			<li class="main-nav__user-settings-menu__item">
				<a href="#" class="main-nav__user-settings-menu__link open-user-settings">
					<?php Utils()->the_svg( 'settings-icon' ); ?>
					<?php pll_esc_html_e( 'Asetukset' ); ?>
				</a>
			</li>
			<li class="main-nav__user-settings-menu__item">
				<a href="<?php echo esc_url( wp_logout_url() ); ?>" class="main-nav__user-settings-menu__link">
					<?php Utils()->the_svg( 'sign-out' ); ?>
					<?php pll_esc_html_e( 'Kirjaudu ulos' ); ?>
				</a>
			</li>
		</ul>
	<?php endif; ?>
</li>
