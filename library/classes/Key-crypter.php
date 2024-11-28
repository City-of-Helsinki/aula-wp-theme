<?php

class Key_crypter {

	/**
	 * Key used for encryption
	 *
	 * @var string
	 */
	private static $key = AUTH_KEY;

	/**
	 * Cipher method
	 *
	 * @var string
	 */
	private static $cipher = 'aes-128-cbc-hmac-sha1';

	/**
	 * Initialization vector
	 *
	 * @var string
	 */
	private static $iv = OPENSSL_IV;

	public static function crypt_key( $phrase ) {
		$key     = hash( 'sha256', self::$key );
		$crypted = openssl_encrypt( $phrase, self::$cipher, $key, 0, self::$iv );

		return $crypted;

	}

	public static function decrypt_key( $phrase ) {
		$key     = hash( 'sha256', self::$key );
		$crypted = openssl_decrypt( $phrase, self::$cipher, $key, 0, self::$iv );

		return $crypted;
	}

}
