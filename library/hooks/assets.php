<?php

/**
 * All the assets
 *
 * @package Oppijaportaali
 */

/**
 * Admin stuff
 */
add_action(
	'admin_enqueue_scripts',
	function () {
		wp_enqueue_script(
			'luuptek_admin',
			asset_uri( 'scripts/admin.min.js' ),
			[ 'jquery', 'wp-i18n', 'wp-blocks', 'wp-dom-ready' ],
			filemtime( get_theme_file_path( 'assets/dist/scripts/admin.min.js' ) )
		);

		/**
		 * Main admin style
		 */
		wp_enqueue_style(
			'luuptek_admin_style',
			asset_uri( 'styles/admin.css' ),
			[],
			filemtime( get_theme_file_path( 'assets/dist/styles/admin.css' ) )
		);
	}
);

/**
 * Login stuff
 */
add_action(
	'login_enqueue_scripts',
	function () {
		/**
		 * Main admin style
		 */
		wp_enqueue_style(
			'luuptek_admin_style',
			asset_uri( 'styles/admin.css' ),
			[],
			filemtime( get_theme_file_path( 'assets/dist/styles/admin.css' ) )
		);
	}
);

/**
 * Enqueue scripts and styles
 */
add_action(
	'wp_enqueue_scripts',
	function () {

		/**
		 * Main scripts file
		 */
		wp_enqueue_script(
			'luuptek_theme',
			asset_uri( 'scripts/main.min.js' ),
			[ 'jquery' ],
			filemtime( get_theme_file_path( 'assets/dist/scripts/main.min.js' ) ),
			true
		);

		wp_localize_script(
			'luuptek_theme',
			'oppijaportaali_js',
			[
				'ajax_url'              => admin_url( 'admin-ajax.php' ),
				'nonce'                 => wp_create_nonce( 'aula_user_nonce' ),
				'user_id'               => is_user_logged_in() ? get_current_user_id() : null,
				'time_is_up'            => pll_esc_html__( 'Keskittymisaika loppunut' ),
				'add_new_form_errors'   => pll_esc_html__( 'Uuden palvelun lisäämisessä on ongelmia. Syötitkö tarvittavat tiedot?' ),
				'new_service_added'     => pll_esc_html__( 'Uusi palvelu lisätty onnistuneesti. Palvelu näkyy nyt ei-aktiiviissa palveluissa.' ),
				'user_settings_updated' => pll_esc_html__( 'Asetukset päivitetty.' ),
				'multiavatar'           => ! empty( get_user_meta( get_current_user_id(), 'user_multiavatar', true ) ) ? get_user_meta( get_current_user_id(), 'user_multiavatar', true ) : null,
				'music_tracks'          => Utils()->get_music_setlist(),
			]
		);


		/**
		 * Main style
		 */
		wp_enqueue_style(
			'luuptek_style',
			asset_uri( 'styles/main.css' ),
			[],
			filemtime( get_theme_file_path( 'assets/dist/styles/main.css' ) )
		);

		/**
		 * enable standalone mode on IOS Safari
		 */
		wp_enqueue_script(
			'standalone',
			'/wp-content/themes/oppijaportaali/assets/scripts/standalone.js',
			[],
			oppijaportaali_theme()->get( 'Version' )
		);

		/**
		 * Move jquery to footer
		 */
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	}
);

/**
 * Enqueue styles for Gutenberg Editor
 */
add_action(
	'enqueue_block_editor_assets',
	function () {

		wp_enqueue_script(
			'luuptek_admin',
			asset_uri( 'scripts/admin.min.js' ),
			[ 'wp-i18n', 'wp-blocks', 'wp-dom-ready' ],
			filemtime( get_theme_file_path( 'assets/dist/scripts/admin.min.js' ) )
		);

	},
	10
);
