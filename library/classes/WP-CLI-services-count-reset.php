<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Bail if WP-CLI is not present
if ( ! defined( 'WP_CLI' ) ) {
	return;
}

// Add command to wp-cli.
WP_CLI::add_command( 'aula services', 'Aula_Services_Reset' );

/**
 * Class Aula_Services_Reset
 */
class Aula_Services_Reset extends WP_CLI_Command {

	/**
	 * Aula_Services_Reset constructor.
	 */
	public function __construct() {
		// Here you can do something, when command execution starts
	}

	/**
	 * `wp aula services reset`
	 *
	 * Reset services open counts.
	 *
	 * @param array $args arguments
	 * @param array $assoc_args flag arguments
	 */
	public function reset( $args = [], $assoc_args = [] ) {

		\WP_CLI::line( 'Starting reset...' );

		$count = 0;

		$args = [
			'post_type'      => 'services',
			'lang'           => '',
			'posts_per_page' => - 1,
		];

		$posts = get_posts( $args );

		foreach ( $posts as $service ) {
			update_post_meta( $service->ID, '_service_clicks', 0 );
			$count ++;
		}

		\WP_CLI::line( "DONE. Updated {$count} services open count to zero" );
	}
}
