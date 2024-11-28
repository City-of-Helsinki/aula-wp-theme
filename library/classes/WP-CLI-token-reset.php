<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Bail if WP-CLI is not present
if ( ! defined( 'WP_CLI' ) ) {
	return;
}

// Add command to wp-cli.
WP_CLI::add_command( 'aula tokens', 'Aula_Tokens_Reset' );

/**
 * Class Aula_Services_Reset
 */
class Aula_Tokens_Reset extends WP_CLI_Command {

	/**
	 * Aula_Services_Reset constructor.
	 */
	public function __construct() {
		// Here you can do something, when command execution starts
	}

	/**
	 * `wp aula tokens reset`
	 *
	 * Resets all tokens in wp_usermeta
	 *
	 * @param array $args arguments
	 * @param array $assoc_args flag arguments
	 */
	public function reset( $args = [], $assoc_args = [] ) {

		\WP_CLI::line( 'Starting reset...' );

		$count = 0;

		global $wpdb;

		// Define the meta keys to delete
		$meta_keys = array( 'access_token', 'refresh_token' );

		// Loop through each meta key and delete the associated user meta records
		foreach ( $meta_keys as $meta_key ) {
			$wpdb->delete(
				$wpdb->usermeta,
				array(
					'meta_key' => $meta_key
				),
				array(
					'%s'
				)
			);

			$count ++;
		}

		\WP_CLI::line( "DONE. Deleted {$count} tokens." );
	}
}
