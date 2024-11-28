<?php

/**
 * Class Oppiaste_checker
 */
class Oppiaste_checker {
	/**
	 * Key for user grade in meta-table
	 *
	 * @var string Name of key in user_meta
	 */
	public static $meta_key = 'user_grade';

	/**
	 * Current user
	 *
	 * @var WP_User|null WP_User object or null if not logged in
	 */
	public static $current_user;

	/**
	 * Oppiaste_checker constructor.
	 */
	public function __construct() {
		self::$current_user = wp_get_current_user();
	}

	/**
	 * Get oppiaste grade via user meta, if found
	 *
	 * @return int|null Value of oppiaste data, if found
	 */
	public static function get_oppiaste_value() {
		$value = ! empty( get_user_meta( self::$current_user->ID, self::$meta_key, true ) ) ? (int) get_user_meta( self::$current_user->ID, self::$meta_key, true ) : null;

		return $value;
	}

	/**
	 * Check if current user is from peruskoulu
	 *
	 * @return bool
	 */
	public static function is_peruskoulu() {
		if ( self::is_peruskoulu_1() || self::is_peruskoulu_2() || self::is_peruskoulu_3() || self::is_peruskoulu_4() || self::is_peruskoulu_5() || self::is_peruskoulu_6() || self::is_peruskoulu_7() || self::is_peruskoulu_8() || self::is_peruskoulu_9() || self::is_peruskoulu_10() ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if current user is from lukio
	 *
	 * @return bool
	 */
	public static function is_lukio() {
		if ( self::is_lukio_1() || self::is_lukio_2() || self::is_lukio_3() || self::is_lukio_4() ) {
			return true;
		}

		return false;
	}

	public static function get_oppiaste_options_term_value() {
		$key   = self::get_oppiaste_options_key();
		$value = get_field( $key, 'option' );

		return pll_get_term( $value );
	}

	private static function get_oppiaste_options_key() {
		if ( self::is_peruskoulu_1() ) {
			return 'oppiaste_term_peruskoulu_1';
		}

		if ( self::is_peruskoulu_2() ) {
			return 'oppiaste_term_peruskoulu_2';
		}

		if ( self::is_peruskoulu_3() ) {
			return 'oppiaste_term_peruskoulu_3';
		}

		if ( self::is_peruskoulu_4() ) {
			return 'oppiaste_term_peruskoulu_4';
		}

		if ( self::is_peruskoulu_5() ) {
			return 'oppiaste_term_peruskoulu_5';
		}

		if ( self::is_peruskoulu_6() ) {
			return 'oppiaste_term_peruskoulu_6';
		}

		if ( self::is_peruskoulu_7() ) {
			return 'oppiaste_term_peruskoulu_7';
		}

		if ( self::is_peruskoulu_8() ) {
			return 'oppiaste_term_peruskoulu_8';
		}

		if ( self::is_peruskoulu_9() ) {
			return 'oppiaste_term_peruskoulu_9';
		}

		if ( self::is_peruskoulu_10() ) {
			return 'oppiaste_term_peruskoulu_10';
		}

		if ( self::is_lukio_1() ) {
			return 'oppiaste_term_lukio_1';
		}

		if ( self::is_lukio_2() ) {
			return 'oppiaste_term_lukio_2';
		}

		if ( self::is_lukio_3() ) {
			return 'oppiaste_term_lukio_3';
		}

		if ( self::is_lukio_4() ) {
			return 'oppiaste_term_lukio_4';
		}

		if ( OppiSchoolPicker\is_ammattikoulu( self::get_user_school_data() ) ) {
			return 'oppiaste_term_ammattikoulu';
		}

		return 'oppiaste_term_default';
	}

	private static function is_peruskoulu_1() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 1, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_2() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 2, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_3() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 3, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_4() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 4, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_5() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 5, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_6() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 6, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_7() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 7, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_8() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 8, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_9() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 9, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_peruskoulu_10() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade( 10, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_lukio_1() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade_lukio( 1, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_lukio_2() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade_lukio( 2, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_lukio_3() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade_lukio( 3, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_lukio_4() {
		$oppiaste = self::get_oppiaste_value();

		if ( null === $oppiaste ) {
			return false;
		}

		if ( self::is_grade_lukio( 4, $oppiaste ) ) {
			return true;
		}

		return false;
	}

	private static function is_grade( $grade, $oppiaste ) {
		if ( in_array( $oppiaste, self::get_peruskoulu_array_values() ) && $grade === $oppiaste && OppiSchoolPicker\is_peruskoulu( self::get_user_school_data() ) ) {
			return true;
		}

		return false;
	}

	private static function is_grade_lukio( $grade, $oppiaste ) {
		if ( in_array( $oppiaste, self::get_lukio_array_values() ) && $grade === $oppiaste && OppiSchoolPicker\is_lukio( self::get_user_school_data() ) ) {
			return true;
		}

		return false;
	}

	private static function get_user_school_data() {
		return Utils()->get_user_data_meta();
	}

	private static function get_peruskoulu_array_values() {
		return [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ];
	}

	private static function get_lukio_array_values() {
		return [ 1, 2, 3, 4 ];
	}
}
