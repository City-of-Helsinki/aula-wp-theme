<?php

/**
 * If using ACF blocks
 * Add the logic here =>
 *
 * @package Oppijaportaali
 *
 */

add_action( 'acf/init', 'register_oppijaportaali_acf_blocks' );

/**
 * Function where ACF custom blocks are resgitered
 */
function register_oppijaportaali_acf_blocks() {

	// check function exists.
	if ( function_exists( 'acf_register_block_type' ) ) {

		// Registering blocks
		acf_register_block_type(
			[
				'name'            => 'hero', // don't need acf/block-name
				'title'           => __( 'Hero', 'oppijaportaali' ),
				'render_template' => 'partials/gb-blocks/gb-acf-hero.php',
				'category'        => 'formatting',
				'icon'            => 'format-image',
				'supports'        => [
					'align' => [ 'full' ],
				],
			]
		);
	}
}
