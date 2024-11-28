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
		$args = [ 'error' => pll_esc_html__( 'Linkitä ensin Google Drive tilisi portaaliin.' ) ];
		get_template_part( 'partials/components/google-drive-require-authentication', '', $args );

		return;
	}

	$access_token = $token_data->access_token;
	update_user_meta( $current_user_id, 'access_token', Key_crypter::crypt_key( $token_data->access_token ) );
	update_user_meta( $current_user_id, 'refresh_token', Key_crypter::crypt_key( $token_data->refresh_token ) );

	$files_response = $api->get_files( $access_token );
}

/**
 * Scenario: token found from user meta
 */
if ( ! empty( $user_access_token ) ) {
	$access_ok = true;

	/**
	 * Try to retrieve files access_token
	 */
	$files_response = $api->get_files( Key_crypter::decrypt_key( $user_access_token ) );

	/**
	 * If access token no longer valid, use refresh token to update access token
	 */
	if ( false === $files_response ) {
		$access_ok = false;

		// Not ok...need to update access_token woth refresh token
		$token_data = $api->get_access_token( GOOGLE_CLIENT_ID, GOOGLE_REDIRECT_URI, GOOGLE_CLIENT_SECRET, $auth_code, true, Key_crypter::decrypt_key( $user_refresh_token ) );

		if ( $token_data ) {
			$access_token = $token_data->access_token;
			$access_ok    = true;
			update_user_meta( $current_user_id, 'access_token', Key_crypter::crypt_key( $token_data->access_token ) );
			$files_response = $api->get_files( $access_token );

			if ( false === $files_response ) {
				$access_ok = false;
			}
		}
	}

	if ( ! $access_ok ) {
		// Delete access token and refresh token from db if api requests will fail
		delete_user_meta( $current_user_id, 'access_token' );
		delete_user_meta( $current_user_id, 'refresh_token' );

		$args = [
			'error' => pll_esc_html__( 'Linkitä ensin Google Drive tilisi portaaliin.' ),
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
			<th class="icon-column" aria-hidden="true"></th>
			<th><?php pll_esc_html_e( 'Nimi' ); ?></th>
			<th class="table-column-align-right"><?php pll_esc_html_e( 'Omistaja' ); ?></th>
			<th class="table-column-align-right">
				<button class="table-sorter-btn" aria-expanded="false"
				        aria-label="<?php echo pll_esc_attr__( 'Muokkaa tiedostojen suodatusta eri suodattimien avulla' ) ?>">
					<?php pll_esc_html_e( 'Päivämäärä' ); ?>
					<?php Utils()->the_svg( 'arrow-down-black' ); ?>
					<ul class="sortable-options" aria-hidden="true">
						<li class="sortable-options__item">
							<a href="#" class="sortable-options__link sortable-options__link--active"
							   data-orderby="modifiedByMeTime" aria-pressed="true">
								<?php pll_esc_html_e( 'Viimeksi muokkaamani' ); ?>
							</a>
						</li>
						<li class="sortable-options__item">
							<a href="#" class="sortable-options__link" data-orderby="modifiedTime">
								<?php pll_esc_html_e( 'Muokattu viimeksi' ); ?>
							</a>
						</li>
						<li class="sortable-options__item">
							<a href="#" class="sortable-options__link" data-orderby="recency">
								<?php pll_esc_html_e( 'Viimeisin avaamisjankohta' ); ?>
							</a>
						</li>
					</ul>
				</button>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php

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
		?>
		</tbody>
	</table>
</div>
