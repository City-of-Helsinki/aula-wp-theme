<?php

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'aula reset custom schools', function ( $args, $assoc_args ) {
		// Check if --dry-run flag is present
		$dry_run = isset( $assoc_args['dry-run'] );

		if ( $dry_run ) {
			WP_CLI::log( "--- DRY-RUN MODE: No changes will be saved to the database ---" );
		}

		// Fetch ALL users without any limit
		$users = get_users( [ 'number' => - 1 ] );

		$deleted_count = 0;
		$kept_count    = 0;

		foreach ( $users as $user ) {
			$user_id   = $user->ID;
			$user_name = $user->display_name ? $user->display_name : $user->user_login;

			// Get the user_custom_school meta
			$custom_school = get_user_meta( $user_id, 'user_custom_school', true );

			// Skip users who do not have the user_custom_school meta set
			if ( empty( $custom_school ) ) {
				continue;
			}

			// Fetch user_data and user_department meta values as strings
			$user_data       = get_user_meta( $user_id, 'user_data', true );
			$user_department = get_user_meta( $user_id, 'user_department', true );

			// Convert semicolon-separated strings into arrays and remove empty values
			$data_array = ! empty( $user_data ) && is_string( $user_data )
				? array_filter( array_map( 'trim', explode( ';', $user_data ) ) )
				: [];

			$dept_array = ! empty( $user_department ) && is_string( $user_department )
				? array_filter( array_map( 'trim', explode( ';', $user_department ) ) )
				: [];

			// Merge both meta arrays and remove duplicate values
			$combined = array_unique( array_merge( $data_array, $dept_array ) );

			// Keep the meta ONLY if unique items > 1 AND custom_school is in the array
			$keep_meta = ( count( $combined ) > 1 ) && in_array( $custom_school, $combined, true );

			if ( $keep_meta ) {
				WP_CLI::log( "säilytettiin user_custom_school käyttäjällä {$user_name}, \"{$custom_school}\" löytyi user_data- ja/tai user_department metasta" );
				$kept_count ++;
			} else {
				if ( ! $dry_run ) {
					delete_user_meta( $user_id, 'user_custom_school' );
				}

				$prefix = $dry_run ? '[DRY-RUN] ' : '';
				WP_CLI::log( "{$prefix}poistettiin user_custom_school käyttäjältä {$user_name}" );
				$deleted_count ++;
			}
		}

		$action_label = $dry_run ? 'Olisi poistettu' : 'Poistettiin';
		WP_CLI::success( "Valmis! {$action_label} metatieto {$deleted_count} käyttäjältä. Säilytettiin {$kept_count} käyttäjällä." );
	} );
}
