<?php

/**
 * The No results found -template
 *
 * @package Oppijaportaali
 *
 */

?>

<div class="link-lifts">
	<div class="link-lifts-wrapper">
		<?php
		// Get content from 404-content post type (404-content)
		// posts per page 1
		//  Input post title to h1
		// input post content below the title
		$args = [
			'post_type'      => '404-content',
			'posts_per_page' => 1,
		];

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php endif;
		wp_reset_postdata(); ?>
	</div>
</div>
