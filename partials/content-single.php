<?php

/**
 * The main template for single article
 *
 * @package Oppijaportaali
 *
 */

?>

<article <?php post_class( 'post-container gutenberg post-' . sanitize_title( get_the_title() ) ); ?>>
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
</article>
