<?php

/**
 *
 * This Google Drive API handler class is a custom PHP library to handle the Google Drive API calls.
 *
 */
class GoogleDriveApi {
	const OAUTH2_TOKEN_URI = 'https://oauth2.googleapis.com/token';
	const DRIVE_FILE_META_URI = 'https://www.googleapis.com/drive/v3/files/';
	const CLASSROOM_COURSES_URI = 'https://classroom.googleapis.com/v1/courses/';

	function __construct( $params = array() ) {
		if ( count( $params ) > 0 ) {
			$this->initialize( $params );
		}
	}

	function initialize( $params = array() ) {
		if ( count( $params ) > 0 ) {
			foreach ( $params as $key => $val ) {
				if ( isset( $this->$key ) ) {
					$this->$key = $val;
				}
			}
		}
	}

	/**
	 * Function to retrieve access token
	 *
	 * @param $client_id
	 * @param $redirect_uri
	 * @param $client_secret
	 * @param $code
	 *
	 * @return false|mixed
	 */
	public function get_access_token( $client_id, $redirect_uri, $client_secret, $code, $refresh = false, $refresh_token = null ) {
		$curl_post_fields = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code=' . $code . '&grant_type=authorization_code';

		if ( $refresh ) {
			$curl_post_fields = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&refresh_token=' . $refresh_token . '&grant_type=refresh_token';
		}

		$api_response = wp_remote_post(
			self::OAUTH2_TOKEN_URI,
			[
				'body' => $curl_post_fields,
			]
		);

		if ( ! is_wp_error( $api_response ) ) {
			if ( wp_remote_retrieve_response_code( $api_response ) === 200 ) {
				return json_decode( wp_remote_retrieve_body( $api_response ) );
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function get_files( $access_token, $orderby = 'modifiedByMeTime' ) {
		$api_url = self::DRIVE_FILE_META_URI . '?fields=files(mimeType,id,name,modifiedTime,owners,ownedByMe)&pageSize=30&orderBy=' . $orderby . ' desc';

		$api_response = wp_remote_get(
			$api_url,
			[
				'headers' => [
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $access_token,
				],
			]
		);

		if ( ! is_wp_error( $api_response ) ) {
			if ( wp_remote_retrieve_response_code( $api_response ) === 200 ) {
				return json_decode( wp_remote_retrieve_body( $api_response ) );
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function get_courses( $access_token ) {
		$api_url = self::CLASSROOM_COURSES_URI;

		$api_response = wp_remote_get(
			$api_url,
			[
				'headers' => [
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $access_token,
				],
			]
		);

		if ( ! is_wp_error( $api_response ) ) {
			if ( wp_remote_retrieve_response_code( $api_response ) === 200 ) {
				return json_decode( wp_remote_retrieve_body( $api_response ) );
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
