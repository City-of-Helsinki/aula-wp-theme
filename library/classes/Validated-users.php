<?php

class Validated_users {

	/**
	 * @var string[] Array of users to validate
	 */
	private static $validated_users = [
		'timo@luuptek.fi',
		'karri.mehtala@edu.hel.fi',
		'tessa.testaaja@edu.hel.fi',
		'tero.testaaja@edu.hel.fi',
		'tommi.tiittala@edu.hel.fi',
		'lauri.vihma@edu.hel.fi',
		'teemu.einola@edu.hel.fi',
		'testaat@edu.hel.fi',
		'testte2@edu.hel.fi',
		'kati.immeli-vanska@edu.hel.fi',
	];

	/**
	 * To check whether of not current user is to be validated or not
	 *
	 * @return bool
	 */
	public static function is_valid_user() {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		$current_user = wp_get_current_user();
		if ( $current_user instanceof WP_User ) {
			if ( in_array( $current_user->user_email, self::$validated_users ) ) {
				return true;
			}
		}

		return false;
	}
}
