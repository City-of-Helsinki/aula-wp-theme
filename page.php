<?php

/**
 * The main page-template wrapper
 *
 * @package Oppijaportaali
 */

get_header();

do_action( 'oppijaportaali_before_page' );
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'partials/service-failure' );
		get_template_part( 'partials/components/search-engine' );
		get_template_part( 'partials/components/action-tabs' );
		get_template_part( 'partials/components/plain-services' );
		get_template_part( 'partials/components/link-lifts' );
		get_template_part( 'partials/sections/s-actions' );
	}
}

do_action( 'oppijaportaali_after_page' );

get_footer();
