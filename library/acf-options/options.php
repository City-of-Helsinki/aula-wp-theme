<?php

if ( function_exists( 'acf_add_options_page' ) ) {

	$args = [
		'page_title'      => __( 'Theme Options', 'oppijaportaali' ),
		'parent_slug'     => 'options-general.php',
		'update_button'   => __( 'Update options', 'oppijaportaali' ),
		'updated_message' => __( 'Options updated', 'oppijaportaali' ),
	];

	acf_add_options_page( $args );

}
