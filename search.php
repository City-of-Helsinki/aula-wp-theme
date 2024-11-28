<?php

/**
 * The main search-wrapper
 *
 * @package Oppijaportaali
 */

get_header();

?>

<?php do_action( 'oppijaportaali_before_page' ); ?>

<section>
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<h1>
				<?php /* translators: %s: search term */ ?>
				<?php printf( esc_html( __( 'Search Results for: %s', 'oppijaportaali' ) ), '<span>' . get_search_query() . '</span>' ); ?>
			</h1>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'partials/content', 'search' ); ?>
			<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'partials/no-results', 'search' ); ?>
		<?php endif; ?>
	</div>
</section>

<?php do_action( 'oppijaportaali_after_page' ); ?>

<?php get_footer(); ?>
