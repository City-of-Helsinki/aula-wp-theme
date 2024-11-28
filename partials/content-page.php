<?php

/**
 * The main template for page
 *
 * @package Oppijaportaali
 *
 */

?>

<article <?php post_class( 'page-container gutenberg post-' . sanitize_title( get_the_title() ) ); ?>>
	<?php the_content(); ?>
</article>
