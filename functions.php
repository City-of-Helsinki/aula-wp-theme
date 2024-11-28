<?php

// For doing testing in local..
//$user_id = 1;
//wp_set_current_user( $user_id );
//$user = get_current_user();
//wp_set_auth_cookie( $user_id );
//do_action( 'wp_login', $user->user_login, $user );

/**
 * Main functions and definitions
 *
 * @package Oppijaportaali
 */

/**
 * Require helpers
 */
require dirname( __FILE__ ) . '/library/functions/helpers.php';

/**
 * Set theme name which will be referenced from style & script registrations
 *
 * @return WP_Theme
 */
function oppijaportaali_theme() {
	return wp_get_theme();
}

/**
 * Set custom imagesizes
 *
 * @return array
 */
function oppijaportaali_set_imagesizes() {
	return [
		[
			'name'   => 'article_lift',
			'width'  => 360,
			'height' => 200,
			'crop'   => true,
		],
	];
}

/**
 * If defined, the feed will be shown on admin dashboard
 */
define( 'FEED_URI', 'https://www.luuptek.fi/feed/?post_type=guide' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
if ( ! function_exists( 'oppijaportaali_setup' ) ) :

	/**
	 * WP base setup here
	 */
	function oppijaportaali_setup() {

		global $cap, $content_width;

		/**
		 * Load textdomain
		 */
		load_theme_textdomain( 'oppijaportaali', get_template_directory() . '/library/lang' );

		/**
		 * Add editor styling
		 */
		add_editor_style( asset_uri( 'styles/main.css' ) );

		/**
		 * Require ACF stuff
		 */
		require_files( dirname( __FILE__ ) . '/library/acf-blocks' );
		require_files( dirname( __FILE__ ) . '/library/acf-options' );

		/**
		 * Require some classes
		 */
		require_files( dirname( __FILE__ ) . '/library/classes' );

		/**
		 * Require custom post types
		 */
		require_files( dirname( __FILE__ ) . '/library/custom-posts' );

		/**
		 * Require custom taxonomies
		 */
		require_files( dirname( __FILE__ ) . '/library/custom-taxonomies' );

		/**
		 * Require metaboxes
		 */
		require_files( dirname( __FILE__ ) . '/library/metaboxes' );

		/**
		 * Widgets (nav-menus & widgetized areas)
		 */
		require_files( dirname( __FILE__ ) . '/library/widgets' );

		/**
		 * Functions and helpers
		 */
		require_files( dirname( __FILE__ ) . '/library/functions' );

		/**
		 * Hooks
		 */
		require_files( dirname( __FILE__ ) . '/library/hooks' );

		/**
		 * Theme supports
		 */
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'html5', [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ] );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'editor-color-palette',
				[
					[
						'name'  => __( 'Theme primary', 'oppijaportaali' ),
						'slug'  => 'theme-primary',
						'color' => '#fd4f00',
					],
					[
						'name'  => __( 'Theme secondary', 'oppijaportaali' ),
						'slug'  => 'theme-secondary',
						'color' => '#bd2719',
					],
					[
						'name'  => __( 'Solid black', 'oppijaportaali' ),
						'slug'  => 'solid-black',
						'color' => '#000',
					],
					[
						'name'  => __( 'Solid white', 'oppijaportaali' ),
						'slug'  => 'solid-white',
						'color' => '#FFF',
					],
				]
			);

			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );
			add_theme_support( 'disable-custom-colors' );
			add_theme_support( 'disable-custom-gradients' );
			add_theme_support( 'disable-custom-font-sizes' );
		}

		/**
		 * Register custom imagesizes
		 */
		if ( ! empty( oppijaportaali_set_imagesizes() ) ) {
			foreach ( oppijaportaali_set_imagesizes() as $size ) {
				add_image_size( $size['name'], $size['width'], $size['height'], $size['crop'] );
			}
		}

	}

endif; // oppijaportaali_setup

add_action( 'after_setup_theme', 'oppijaportaali_setup' );

/**
 * Add feed (if defined) to dashboard
 */
add_action(
	'wp_dashboard_setup',
	function () {
		if ( defined( 'FEED_URI' ) ) {
			add_meta_box( 'dashboard_custom_feed', __( 'Latest from WP-quide', 'oppijaportaali' ), 'oppijaportaali_feed', 'dashboard', 'side', 'low' );
		}

		/**
		 * Setup post guide feed into dashboard
		 */
		function oppijaportaali_feed() {
			echo '<div class="rss-widget">';
			wp_widget_rss_output(
				FEED_URI,
				[
					'items'        => 5,
					'show_title'   => 0,
					'show_summary' => 1,
					'show_author'  => 0,
					'show_date'    => 1,
				]
			);
			echo '</div>';
		}
	}
);

/**
 * Add text to theme footer
 */
add_filter(
	'admin_footer_text',
	function () {
		return '<span id="footer-thankyou">' . oppijaportaali_theme()->Name . ' by: <a href="' . oppijaportaali_theme()->AuthorURI . '" target="_blank">' . oppijaportaali_theme()->Author . '</a><span>';
	}
);

/**
 * Allow svg-uploads
 */
add_filter(
	'upload_mimes',
	function ( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}
);

/**
 * Move WP-templates to templates-folder for cleaner experience on dev
 */
add_filter(
	'stylesheet',
	function ( $stylesheet ) {
		return dirname( $stylesheet );
	}
);

add_action(
	'after_switch_theme',
	function () {
		$stylesheet = get_option( 'stylesheet' );
		if ( basename( $stylesheet ) !== 'templates' ) {
			update_option( 'stylesheet', $stylesheet . '/templates' );
		}
	}
);

/**
 * Register local ACF-json
 */
add_filter(
	'acf/settings/save_json',
	function () {
		return get_stylesheet_directory() . '/library/acf-data';
	}
);

add_filter(
	'acf/settings/load_json',
	function () {
		$paths[] = get_stylesheet_directory() . '/library/acf-data';

		return $paths;
	}
);

/**
 * Add translatable string to pll
 */
if ( function_exists( 'pll_register_string' ) ) {
	$translatables = require( get_template_directory() . '/library/translation-strings.php' );
	foreach ( $translatables as $name => $string ) {
		pll_register_string( $name, $string );
	}
}

/**
 * Update google maps api key for ACF
 */
function update_acf_google_maps_api_key() {

	if ( function_exists( 'acf_update_setting' ) ) {
		acf_update_setting( 'google_api_key', 'your-api-here' );
	}
}

add_action( 'acf/init', 'update_acf_google_maps_api_key' );


function skip_authentication_for_ip_range() {

	if ( class_exists( '\Wpo\Services\Log_Service' ) ) {
		\Wpo\Services\Log_Service::write_log( 'WARN', "The hook apply_filter( 'wpo365_skip_authentication' ) just fired" );
	}

	$allowed_ips = [
		'127.0.0.1',
		'62.237.220.3', // Exove
		'54.68.32.247', // Wordfence Central
		'137.163.145.226',
		'137.163.145.129',
		'137.163.145.130',
		'137.163.145.131',
		'137.163.145.132',
		'137.163.145.133',
		'137.163.145.134',
		'137.163.145.135',
		'137.163.145.136',
		'137.163.145.137',
		'137.163.145.138',
		'137.163.145.139',
		'137.163.145.140',
		'137.163.145.141',
		'137.163.145.142',
		'137.163.145.143',
		'137.163.145.144',
		'137.163.145.145',
		'137.163.145.146',
		'137.163.145.147',
		'137.163.145.148',
		'137.163.145.149',
		'137.163.145.150',
		'137.163.145.151',
		'137.163.145.152',
		'137.163.145.153',
		'137.163.145.154',
		'137.163.145.155',
		'137.163.145.156',
		'137.163.145.157',
		'137.163.145.158',
		'137.163.145.159',
		'137.163.145.160',
		'137.163.145.161',
		'137.163.145.162',
		'137.163.145.163',
		'137.163.145.164',
		'137.163.145.165',
		'137.163.145.166',
		'137.163.145.167',
		'137.163.145.168',
		'137.163.145.169',
		'137.163.145.170',
		'137.163.145.171',
		'137.163.145.172',
		'137.163.145.173',
		'137.163.145.174',
		'137.163.145.175',
		'137.163.145.176',
		'137.163.145.177',
		'137.163.145.178',
		'137.163.145.179',
		'137.163.145.180',
		'137.163.145.181',
		'137.163.145.182',
		'137.163.145.183',
		'137.163.145.184',
		'137.163.145.185',
		'137.163.145.186',
		'137.163.145.187',
		'137.163.145.188',
		'137.163.145.189',
		'137.163.145.190',
	];

	if ( in_array( $_SERVER['REMOTE_ADDR'], $allowed_ips ) ) {
		return true;
	}

	return false;
}

add_filter( 'wpo365_skip_authentication', 'skip_authentication_for_ip_range', 10, 0 );

function hide_nickname_field_css() {

    echo '<style>tr.user-nickname-wrap{ display: none; }</style>';

};

add_action( 'admin_head-user-edit.php', 'hide_nickname_field_css' );

add_action( 'admin_head-profile.php',   'hide_nickname_field_css' );
