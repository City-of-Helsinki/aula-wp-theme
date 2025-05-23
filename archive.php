<?php

/**
 * The main archive-template
 *
 * @package Oppijaportaali
 */

get_header();

?>

<?php do_action( 'oppijaportaali_before_page' ); ?>

<section>
	<div class="container">
		<h1><?php echo get_the_archive_title(); ?></h1>
		<?php
		if ( have_posts() ) :
			echo '<div class="post-lifts-row">';
			while ( have_posts() ) :
				the_post();
				get_template_part( 'partials/content', 'post-lift' );
			endwhile;
			echo '</div>';
			get_template_part( 'partials/pagination' );
		endif;
		?>
	</div>
</section>

<?php do_action( 'oppijaportaali_after_page' ); ?>

<?php get_footer(); ?>
