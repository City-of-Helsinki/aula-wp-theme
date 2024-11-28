<?php

/**
 * The No results found -template
 *
 * @package Oppijaportaali
 *
 */

?>

<article>
	<h1>
		<?php /* translators: %s: search term */ ?>
		<?php printf( esc_html__( 'No results found for %s', 'oppijaportaali' ), '<span>' . get_search_query() . '</span>' ); ?>
	</h1>
	<p>
		<?php
		esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'oppijaportaali' );
		?>
	</p>
	<?php get_search_form(); ?>
</article>
