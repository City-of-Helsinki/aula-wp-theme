<?php

class Bing_wallpaper {

	/**
	 * Bing api url
	 *
	 * @var string
	 */
	private static $api_url = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=en-US';

	public static function get_bg_url() {

		$response = self::get_bing_response();

		if ( false === $response ) {
			return null;
		}

		return 'https://www.bing.com' . $response->images[0]->url;
	}

	public static function get_bing_response() {

		// Do we have this information in our transients already?
		$transient = get_transient( 'aula_bing_response' );

		// Yep!  Just return it and we're done.
		if ( ! empty( $transient ) ) {

			// The function will return here every time after the first time it is run, until the transient expires.
			return $transient;

			// Nope!  We gotta make a call.
		} else {
			$response      = wp_remote_get( self::$api_url );
			$response_code = wp_remote_retrieve_response_code( $response );

			if ( 200 === $response_code ) {
				$response_body    = wp_remote_retrieve_body( $response );
				$decoded_response = json_decode( $response_body );
				// Save the API response so we don't have to call again until next 60 minutes
				set_transient( 'aula_bing_response', $decoded_response, MINUTE_IN_SECONDS * 60 );

				return $decoded_response;
			}

			return false;
		}
	}

}
