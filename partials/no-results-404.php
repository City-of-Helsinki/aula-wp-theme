<?php

/**
 * The No results found -template
 *
 * @package Oppijaportaali
 *
 */

?>

<section>
	<div class="container">
		<article>
			<div class="not-found-wrapper">
				<h1 class="not-found-wrapper__title">
					<?php pll_esc_html_e( 'Sivua ei löytynyt' ); ?>
				</h1>
				<p>
					<?php pll_esc_html_e( 'Näyttää siltä, että saavuit sivulle, jota ei ole olemassa.' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php pll_esc_html_e( 'Klikkaa pääsivulle!' ); ?>
					</a>
				</p>
			</div>
		</article>
	</div>
</section>
