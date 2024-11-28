<nav class="main-nav">
	<a class="main-nav__home-link" href="<?php echo esc_url( Utils()->get_helsinki_home_url() ); ?>" target="_blank"
	   aria-label="<?php pll_esc_html_e( 'Helsingin kaupungin koulutuksen sivulle' ); ?>">
		<?php
		$logo_file_name = '/helsinki-logo-white.svg';

		if ( pll_current_language() === 'sv' ) {
			$logo_file_name = '/helsingfors-logo-white.svg';
		}
		?>
		<img src="<?php echo esc_url( UTILS()->get_image_uri() . $logo_file_name ); ?>" class="nav-logo"
		     alt="Logo"/>
		<span class="main-nav__title">
				<?php echo esc_html( get_bloginfo() ); ?>
			</span>
	</a>

	<ul class="main-nav__items">
		<li class="main-nav__items__item main-nav__items__item--time">
			<?php
			printf( esc_html( pll__( 'Hi %s! Today is %s and the time is' ) ), Utils()->get_user_display_name(), Utils()->get_current_date_minified() );
			?>
			<span id="the-time"></span>
		</li>
		<?php
		get_template_part( 'partials/components/user-settings-opener' );
		?>
	</ul>
</nav>
