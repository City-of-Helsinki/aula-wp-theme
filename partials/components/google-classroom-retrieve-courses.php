<?php

if ( ! is_user_logged_in() ) {
	return;
}

$current_user_id = get_current_user_id();

$user_access_token  = get_user_meta( $current_user_id, 'access_token', true );
$user_refresh_token = get_user_meta( $current_user_id, 'refresh_token', true );

/**
 * Logic to get files using access token and/or refresh token
 *
 * - if valid access token found, use that to retrieve files
 * - if access is no longer valid, use refresh token to retrieve new
 * - if token is not found, use code in url to retrieve new token
 */


$auth_code = isset( $_GET['code'] ) ? $_GET['code'] : null;

$api = new GoogleDriveApi();

/**
 * Scenario: auth code available, no tokens found
 */
if ( empty( $user_access_token ) ) {
	$token_data = $api->get_access_token( GOOGLE_CLIENT_ID, GOOGLE_REDIRECT_URI, GOOGLE_CLIENT_SECRET, $auth_code );

	if ( false === $token_data ) {
		$args = [
			'error'       => pll_esc_html__( 'Linkitä ensin Google Classroom tilisi portaaliin.' ),
			'button_text' => pll_esc_html__( 'Yhdistä Classroom' ),
		];
		get_template_part( 'partials/components/google-drive-require-authentication', '', $args );

		return;
	}

	$access_token = $token_data->access_token;
	update_user_meta( $current_user_id, 'access_token', Key_crypter::crypt_key( $token_data->access_token ) );
	update_user_meta( $current_user_id, 'refresh_token', Key_crypter::crypt_key( $token_data->refresh_token ) );

	$courses_response = $api->get_files( $access_token );
}

/**
 * Scenario: token found from user meta
 */
if ( ! empty( $user_access_token ) ) {
	$access_ok = true;

	/**
	 * Try to retrieve files access_token
	 */
	$courses_response = $api->get_courses( Key_crypter::decrypt_key( $user_access_token ) );

	/**
	 * If access token no longer valid, use refresh token to update access token
	 */
	if ( false === $courses_response ) {
		$access_ok = false;

		// Not ok...need to update access_token woth refresh token
		$token_data = $api->get_access_token( GOOGLE_CLIENT_ID, GOOGLE_REDIRECT_URI, GOOGLE_CLIENT_SECRET, $auth_code, true, Key_crypter::decrypt_key( $user_refresh_token ) );

		if ( $token_data ) {
			$access_token = $token_data->access_token;
			$access_ok    = true;
			update_user_meta( $current_user_id, 'access_token', Key_crypter::crypt_key( $token_data->access_token ) );
			$courses_response = $api->get_courses( $access_token );

			if ( false === $courses_response ) {
				$access_ok = false;
			}
		}
	}

	if ( ! $access_ok ) {
		// Delete access token and refresh token from db if api requests will fail
		delete_user_meta( $current_user_id, 'access_token' );
		delete_user_meta( $current_user_id, 'refresh_token' );

		$args = [
			'error'       => pll_esc_html__( 'Linkitä ensin Google Classroom tilisi portaaliin.' ),
			'button_text' => pll_esc_html__( 'Yhdistä Classroom' ),
		];
		get_template_part( 'partials/components/google-drive-require-authentication', '', $args );

		return;
	}
}
?>
<div class="google-drive-table-content">
	<table class="google-drive-table">
		<thead>
		<tr>
			<th><?php pll_esc_html_e( 'Kurssin nimi' ); ?></th>
			<th class="table-column-align-right"><?php pll_esc_html_e( 'Viimeksi päivitetty' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php

		if ( isset( $courses_response->courses ) && count( $courses_response->courses ) > 0 ) {
			foreach ( $courses_response->courses as $course ) {
				$args = [
					'title'         => $course->name,
					'url'           => $course->alternateLink,
					'modified_time' => $course->updateTime,
				];

				get_template_part( 'partials/components/google-classroom-table-row', '', $args );
			}
		}
		?>
		</tbody>
	</table>
</div>

