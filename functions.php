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

function hide_nickname_field_css() {

    echo '<style>tr.user-nickname-wrap{ display: none; }</style>';

};

add_action( 'admin_head-user-edit.php', 'hide_nickname_field_css' );

add_action( 'admin_head-profile.php',   'hide_nickname_field_css' );
