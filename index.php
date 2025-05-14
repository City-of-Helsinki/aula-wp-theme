<?php

/**
 * The main article-list template
 *
 * @package Oppijaportaali
 */

get_header();

?>

<?php do_action( 'oppijaportaali_before_page' ); ?>
<?php get_template_part( 'partials/no-results', '404' ); ?>
<?php get_footer(); ?>
