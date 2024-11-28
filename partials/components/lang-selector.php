<?php

if ( ! function_exists( 'pll_current_language' ) ) {
	return;
}


$translations = pll_the_languages( array( 'raw' => 1 ) );

?>
<nav role="navigation">
	<ul class="lang-menu" role="menu">
		<?php
		foreach ( $translations as $translation ) {
			?>
			<li class="lang-menu__item">
				<a href="<?php echo esc_url( $translation['url'] ); ?>"
				   lang="<?php echo esc_html( $translation['slug'] ); ?>"
				   class="lang-menu__link">
					<?php echo esc_html( $translation['name'] ); ?>
				</a>
			</li>
			<?php
		}
		?>
	</ul>
</nav>
