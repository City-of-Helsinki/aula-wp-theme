<?php

/**
 * The main post-template-wrapper
 *
 * @package Oppijaportaali
 */

get_header();

?>

<?php do_action( 'oppijaportaali_before_page' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<section>
		<div class="container">
			<?php get_template_part( 'partials/content', get_post_type() ); ?>
		</div>
	</section>
<?php endwhile; endif; ?>

<?php do_action( 'oppijaportaali_after_page' ); ?>

<?php get_footer(); ?>
