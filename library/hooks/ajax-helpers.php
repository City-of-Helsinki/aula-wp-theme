<?php

/**
 * AJAX related stuff needed in Aula
 */

/**
 * Add service to favs
 */
function ajax_add_service_to_favorites() {
	$user_services  = new User_services();
	$users_services = $user_services->get_user_services();
	$service_id     = isset( $_POST['service_id'] ) ? wp_unslash( $_POST['service_id'] ) : null;
	$user_id        = isset( $_POST['user_id'] ) ? wp_unslash( $_POST['user_id'] ) : null;

	if ( $service_id && $user_id ) {
		$users_services[] = $service_id;
		update_user_meta( $user_id, 'user_services', $users_services );

		Utils()->the_own_services_row( true );
		Utils()->the_services_row( true, $user_services );
	}

	die();
}

add_action( 'wp_ajax_add_service_to_favorites', 'ajax_add_service_to_favorites' );
add_action( 'wp_ajax_nopriv_add_service_to_favorites', 'ajax_add_service_to_favorites' );

/**
 * Remove service from favs
 */
function ajax_remove_service_from_favorites() {
	$user_services  = new User_services();
	$users_services = $user_services->get_user_services();
	$service_id     = isset( $_POST['service_id'] ) ? wp_unslash( $_POST['service_id'] ) : null;
	$user_id        = isset( $_POST['user_id'] ) ? wp_unslash( $_POST['user_id'] ) : null;

	if ( $service_id && $user_id ) {
		$key = array_search( $service_id, $users_services );
		if ( false !== $key ) {
			unset( $users_services[ $key ] );
			update_user_meta( $user_id, 'user_services', $users_services );

			Utils()->the_own_services_row( false );
			Utils()->the_services_row( false, $user_services );
		}
	}

	die();
}

add_action( 'wp_ajax_remove_service_from_favorites', 'ajax_remove_service_from_favorites' );
add_action( 'wp_ajax_nopriv_remove_service_from_favorites', 'ajax_remove_service_from_favorites' );

function ajax_add_new_own_service() {
	$nonce = $_POST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'aula_user_nonce' ) ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	$service_details = $_POST['service_details'];
	$user_id         = isset( $_POST['user_id'] ) ? wp_unslash( $_POST['user_id'] ) : null;

	$service_name        = isset( $service_details['serviceName'] ) ? sanitize_text_field( $service_details['serviceName'] ) : null;
	$service_description = isset( $service_details['serviceDescription'] ) ? sanitize_text_field( $service_details['serviceDescription'] ) : null;
	$service_url         = isset( $service_details['serviceUrl'] ) ? esc_url_raw( $service_details['serviceUrl'] ) : null;
	$identifier          = md5( $service_name . $service_url );

	global $wpdb;
	$table  = $wpdb->prefix . 'user_own_services';
	$data   = array(
		'identifier'          => $identifier,
		'user_id'             => $user_id,
		'service_name'        => $service_name,
		'service_url'         => $service_url,
		'service_description' => $service_description,
	);
	$format = array( '%s', '%d', '%s', '%s', '%s' );
	$insert = $wpdb->insert( $table, $data, $format );

	if ( false !== $insert ) {
		$user_services = new User_services();
		Utils()->the_services_row( false, $user_services );
		Utils()->the_own_services_row( false );
	}

	die();
}

add_action( 'wp_ajax_add_new_own_service', 'ajax_add_new_own_service' );
add_action( 'wp_ajax_nopriv_add_new_own_service', 'ajax_add_new_own_service' );

function ajax_remove_own_service() {
	$nonce = $_POST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'aula_user_nonce' ) ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	$user_id            = isset( $_POST['userId'] ) ? wp_unslash( $_POST['userId'] ) : null;
	$service_id         = isset( $_POST['serviceId'] ) ? wp_unslash( $_POST['serviceId'] ) : null;
	$service_identifier = isset( $_POST['serviceIdentifier'] ) ? wp_unslash( $_POST['serviceIdentifier'] ) : null;

	global $wpdb;
	$table = $wpdb->prefix . 'user_own_services';

	$delete = $wpdb->delete(
		$table,
		[
			'id'         => $service_id,
			'user_id'    => $user_id,
			'identifier' => $service_identifier,
		],
		[ '%d', '%d', '%s' ]
	);

	if ( false !== $delete ) {
		pll_esc_html_e( 'Oma palvelusi on nyt poistettu.' );
	} else {
		pll_esc_html_e( 'Oman palvelun poistossa tapahtui virhe.' );
	}

	die();
}

add_action( 'wp_ajax_remove_own_service', 'ajax_remove_own_service' );

function ajax_pin_own_service() {
	$nonce = $_POST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'aula_user_nonce' ) ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	$user_id            = isset( $_POST['userId'] ) ? wp_unslash( $_POST['userId'] ) : null;
	$set_visible        = isset( $_POST['setVisible'] ) ? (int) wp_unslash( $_POST['setVisible'] ) : null;
	$service_id         = isset( $_POST['serviceId'] ) ? wp_unslash( $_POST['serviceId'] ) : null;
	$service_identifier = isset( $_POST['serviceIdentifier'] ) ? wp_unslash( $_POST['serviceIdentifier'] ) : null;

	global $wpdb;
	$table = $wpdb->prefix . 'user_own_services';

	$update = $wpdb->update(
		$table,
		[
			'visible' => $set_visible,
		],
		[
			'id'         => $service_id,
			'user_id'    => $user_id,
			'identifier' => $service_identifier,
		],
		[ '%d' ],
		[ '%d', '%d', '%s' ]
	);

	$user_services = new User_services();

	if ( false !== $update ) {
		if ( 1 === $set_visible ) {
			Utils()->the_own_services_row( true );
			Utils()->the_services_row( true, $user_services );
		} else {
			Utils()->the_services_row( false, $user_services );
			Utils()->the_own_services_row( false );
		}
	}

	die();
}

add_action( 'wp_ajax_pin_own_service', 'ajax_pin_own_service' );

function ajax_update_user_settings() {
	$nonce = $_POST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'aula_user_nonce' ) ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	$user_id              = isset( $_POST['userId'] ) ? wp_unslash( $_POST['userId'] ) : null;
	$multiavatar          = isset( $_POST['profilePicture'] ) ? wp_unslash( $_POST['profilePicture'] ) : null;
	$profilePicVisibility = isset( $_POST['profilePictureVisibility'] ) ? wp_unslash( $_POST['profilePictureVisibility'] ) : null;
	$search_engine        = isset( $_POST['searchEngine'] ) ? wp_unslash( $_POST['searchEngine'] ) : 'google';
	$hide_search          = isset( $_POST['hideSearch'] ) ? wp_unslash( $_POST['hideSearch'] ) : null;
	$hide_drive           = isset( $_POST['hideDrive'] ) ? wp_unslash( $_POST['hideDrive'] ) : null;
	$hide_classroom       = isset( $_POST['hideClassroom'] ) ? wp_unslash( $_POST['hideClassroom'] ) : null;
	$custom_School        = isset( $_POST['customSchool'] ) ? wp_unslash( $_POST['customSchool'] ) : 'empty';

	update_user_meta( $user_id, 'user_multiavatar', $multiavatar );
	update_user_meta( $user_id, 'user_hide_search', $hide_search );
	update_user_meta( $user_id, 'user_hide_drive', $hide_drive );
	update_user_meta( $user_id, 'user_hide_classroom', $hide_classroom );
	update_user_meta( $user_id, 'search_engine_selection', $search_engine );
	update_user_meta( $user_id, 'profile_picture_visibility', $profilePicVisibility );

	// Update or delete custom school value
	if ( $custom_School === 'empty' ) {
		delete_user_meta( $user_id, Oppiaste_form_section::$custom_user_meta_key );
	} else {
		update_user_meta( $user_id, Oppiaste_form_section::$custom_user_meta_key, $custom_School );
	}

	echo pll_esc_html__( 'Asetukset päivitetty.' );

	die();
}

add_action( 'wp_ajax_update_user_settings', 'ajax_update_user_settings' );

function ajax_update_info_window_open_count() {
	$post_id       = $_POST['postId'];
	$post_meta_key = $_POST['metaKey'];

	if ( empty( $post_meta_key ) ) {
		die();
	}

	$count = ! empty( get_post_meta( $post_id, $post_meta_key, true ) ) ? (int) get_post_meta( $post_id, $post_meta_key, true ) : 0;

	$count ++;

	update_post_meta( $post_id, $post_meta_key, $count );

	die();
}

add_action( 'wp_ajax_update_info_window_open_count', 'ajax_update_info_window_open_count' );

function ajax_update_service_open_count() {
	$post_id       = $_POST['postId'];
	$post_meta_key = $_POST['metaKey'];

	if ( empty( $post_meta_key ) ) {
		die();
	}

	$count = ! empty( get_post_meta( $post_id, $post_meta_key, true ) ) ? (int) get_post_meta( $post_id, $post_meta_key, true ) : 0;

	$count ++;

	update_post_meta( $post_id, $post_meta_key, $count );

	die();
}

add_action( 'wp_ajax_update_service_open_count', 'ajax_update_service_open_count' );

function render_info_window_statistics( $field ) {
	global $post;
	$meta_key_total_opens   = '_info_window_total_opens';
	$meta_key_button_clicks = '_info_window_button_click';
	$total_opens            = ! empty( get_post_meta( $post->ID, $meta_key_total_opens, true ) ) ? (int) get_post_meta( $post->ID, $meta_key_total_opens, true ) : 0;
	$button_clicks          = ! empty( get_post_meta( $post->ID, $meta_key_button_clicks, true ) ) ? (int) get_post_meta( $post->ID, $meta_key_button_clicks, true ) : 0;

	echo '<h3>Statistiikka</h3>';
	echo "<p>Info ikkuna avattu {$total_opens} kertaa.</p>";
	echo "<p>Painiketta klikattu {$button_clicks} kertaa.</p>";
}

// Training copy button to acf field
add_action( 'acf/render_field/name=bgcolor', 'render_info_window_statistics' );

/*
 * Function to be used to update closed info windows by user
 */
function ajax_update_closed_info_windows_by_user() {
	$nonce   = $_POST['nonce'];
	$user_id = (int) $_POST['userId'];
	$post_id = (int) $_POST['postId'];

	if ( ! wp_verify_nonce( $nonce, 'aula_user_nonce' ) ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	// Not logged in
	if ( 0 === $user_id ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	$users_closed_info_windows = get_user_meta( $user_id, '_user_closed_info_windows', true );

	// Lets add / modify user meta
	if ( empty( $users_closed_info_windows ) ) {
		$new_array = [ $post_id ];
		update_user_meta( $user_id, '_user_closed_info_windows', $new_array );
	} else {
		if ( ! in_array( $post_id, $users_closed_info_windows ) ) {
			array_push( $users_closed_info_windows, $post_id );
			update_user_meta( $user_id, '_user_closed_info_windows', $users_closed_info_windows );
		}
	}

	die();
}

add_action( 'wp_ajax_update_closed_info_windows_by_user', 'ajax_update_closed_info_windows_by_user' );

/*
 * Function to be used to update hided info windows by user
 */
function ajax_update_hided_info_windows_by_user() {
	$nonce   = $_POST['nonce'];
	$user_id = (int) $_POST['userId'];
	$post_id = (int) $_POST['postId'];

	if ( ! wp_verify_nonce( $nonce, 'aula_user_nonce' ) ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	// Not logged in
	if ( 0 === $user_id ) {
		die( pll_esc_html__( 'Käyttäjää ei pystytty tunnistamaan.' ) );
	}

	$users_closed_info_windows = get_user_meta( $user_id, '_user_hided_info_windows', true );

	// Lets add / modify user meta
	if ( empty( $users_closed_info_windows ) ) {
		$new_array = [ $post_id ];
		update_user_meta( $user_id, '_user_hided_info_windows', $new_array );
	} else {
		if ( ! in_array( $post_id, $users_closed_info_windows ) ) {
			array_push( $users_closed_info_windows, $post_id );
			update_user_meta( $user_id, '_user_hided_info_windows', $users_closed_info_windows );
		}
	}

	die();
}

add_action( 'wp_ajax_update_hided_info_windows_by_user', 'ajax_update_hided_info_windows_by_user' );

/**
 * Load concentration data based on post id
 */
function ajax_load_concentration() {
	$post_id = isset( $_POST['postId'] ) ? wp_unslash( $_POST['postId'] ) : null;

	if ( ! $post_id ) {
		die();
	}

	$content   = apply_filters( 'the_content', get_the_content( null, false, $post_id ) );
	$bg_url    = get_the_post_thumbnail_url( $post_id, 'full' );
	$duration  = get_field( 'concentration_duration', $post_id );
	$track_url = get_field( 'concentration_music', $post_id );

	$array = [
		'content'   => $content,
		'bg_url'    => $bg_url,
		'duration'  => $duration,
		'track_url' => $track_url,
	];

	die( json_encode( $array ) );
}

add_action( 'wp_ajax_load_concentration', 'ajax_load_concentration' );
add_action( 'wp_ajax_nopriv_load_concentration', 'ajax_load_concentration' );

/**
 * Update drive table body
 */
function ajax_update_drive_table_body() {
	$orderby = isset( $_POST['orderby'] ) ? $_POST['orderby'] : null;

	$current_user_id    = get_current_user_id();
	$user_access_token  = get_user_meta( $current_user_id, 'access_token', true );
	$user_refresh_token = get_user_meta( $current_user_id, 'refresh_token', true );

	$api = new GoogleDriveApi();

	/**
	 * Scenario: token found from user meta
	 */
	if ( ! empty( $user_access_token ) ) {

		/**
		 * Try to retrieve files access_token
		 */
		$files_response = $api->get_files( Key_crypter::decrypt_key( $user_access_token ), $orderby );

		/**
		 * If access token no longer valid, use refresh token to update access token
		 */
		if ( false === $files_response ) {

			// Not ok...need to update access_token woth refresh token
			$token_data = $api->get_access_token( GOOGLE_CLIENT_ID, GOOGLE_REDIRECT_URI, GOOGLE_CLIENT_SECRET, null, true, Key_crypter::decrypt_key( $user_refresh_token ) );

			if ( $token_data ) {
				$access_token = $token_data->access_token;
				update_user_meta( $current_user_id, 'access_token', Key_crypter::crypt_key( $token_data->access_token ) );
				$files_response = $api->get_files( $access_token );
			}
		}

		foreach ( $files_response->files as $file ) {
			$args = [
				'title'         => $file->name,
				'mime_type'     => $file->mimeType,
				'url'           => 'https://drive.google.com/open?id=' . $file->id,
				'owners'        => $file->owners,
				'modified_time' => $file->modifiedTime,
				'is_mine'       => $file->ownedByMe,
			];

			get_template_part( 'partials/components/google-drive-table-row', '', $args );
		}

		die();
	}
}

add_action( 'wp_ajax_update_drive_table_body', 'ajax_update_drive_table_body' );
