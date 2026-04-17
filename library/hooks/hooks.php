<?php

/**
 * Filter video oembeds and wrap with Foundations flex-video
 *
 * @param $html
 * @param $url
 * @param $attr
 * @param $post_id
 *
 * @return string
 */
add_filter(
	'embed_oembed_html',
	function ( $html, $url, $attr, $post_id ) {
		$matches = [
			'youtube.com',
			'vimeo.com',
			'youtu.be',
		];

		foreach ( $matches as $match ) {
			if ( false !== stripos( $url, $match ) ) {
				return '<div class="framecontainer">' . $html . '</div>';
			}
		}

		return $html;
	},
	99,
	4
);

/**
 * Customise tags in tinyMCE
 */
add_filter(
	'tiny_mce_before_init',
	function ( $init ) {
		$block_formats         = array(
			'Paragraph=p',
			'Heading 1=h1',
			'Heading 2=h2',
			'Heading 3=h3',
			'Heading 4=h4',
			'Heading 5=h5',
			'Heading 6=h6',
		);
		$init['block_formats'] = implode( ';', $block_formats );

		return $init;
	}
);

/**
 * Hook anything here to output before and after page content
 *
 * @hook oppijaportaali_before_page
 */
add_action(
	'oppijaportaali_before_page',
	function () {

	}
);

add_action(
	'oppijaportaali_after_page',
	function () {

	}
);

/**
 * Add scripts to head
 *
 * @hook wp_head
 */
add_action(
	'wp_head',
	function () {
		$options = get_option( 'options_oppijaportaali_scripts_head' );

		if ( ! empty( $options ) ) :
			echo $options;
		endif;
	},
	999
);

/**
 * Add scripts to footer
 *
 * @hook wp_head
 */
add_action(
	'wp_footer',
	function () {
		$options = get_option( 'options_oppijaportaali_scripts_footer' );

		if ( ! empty( $options ) ) :
			echo $options;
		endif;
	},
	999
);

/**
 * Add scripts after opening body
 *
 * @hook oppijaportaali_after_body
 */
add_action(
	'oppijaportaali_after_body',
	function () {
		$options = get_option( 'options_oppijaportaali_scripts_after_body' );

		if ( ! empty( $options ) ) :
			echo $options;
		endif;
	}
);

/**
 * Modify excerpt lenght and style
 */
add_filter(
	'excerpt_length',
	function ( $length ) {
		return 12;
	},
	999
);

add_filter(
	'excerpt_more',
	function () {
		return '...';
	}
);

add_filter(
	'get_the_excerpt',
	function ( $excerpt, $post ) {
		if ( has_excerpt( $post ) ) {
			$excerpt_length = apply_filters( 'excerpt_length', 12 );
			$excerpt_more   = apply_filters( 'excerpt_more', '...' );
			$excerpt        = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
		}

		return $excerpt;
	},
	10,
	2
);

/*
 * Let polylang to copy post title, content and excerpt when making a new language version
 */
add_filter(
	'default_content',
	function ( $content ) {
		if ( isset( $_GET['from_post'] ) ) {
			$my_post = get_post( sanitize_text_field( wp_unslash( $_GET['from_post'] ) ) );
			if ( $my_post ) {
				return $my_post->post_content;
			}
		}

		return $content;
	}
);

add_filter(
	'default_excerpt',
	function ( $content ) {
		if ( isset( $_GET['from_post'] ) ) {
			$my_post = get_post( sanitize_text_field( wp_unslash( $_GET['from_post'] ) ) );
			if ( $my_post ) {
				return $my_post->post_excerpt;
			}
		}

		return $content;
	}
);

add_filter(
	'default_title',
	function ( $content ) {
		if ( isset( $_GET['from_post'] ) ) {
			$my_post = get_post( sanitize_text_field( wp_unslash( $_GET['from_post'] ) ) );
			if ( $my_post ) {
				return $my_post->post_title;
			}
		}

		return $content;
	}
);

/**
 * Disable users endpoint in api
 */
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		if ( ! current_user_can( 'list_users' ) ) {
			if ( isset( $endpoints['/wp/v2/users'] ) ) {
				unset( $endpoints['/wp/v2/users'] );
			}
			if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
				unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
			}
		}

		return $endpoints;
	}
);


/**
 * Block rendering filter
 *
 * You can alter the block rendering by block here
 *
 * Leaving this here as an example..
 */
//add_filter( 'render_block', function ( $block_content, $block ) {
//
//	/**
//	 * Adds table-responsive class prior to table
//	 */
//	if ( $block['blockName'] === 'core/table' ) {
//
//		$classes = '';
//
//		if ( $block['attrs']['align'] === 'full' ) {
//			$classes = ' alignfull';
//		}
//
//		if ( $block['attrs']['align'] === 'wide' ) {
//			$classes = ' alignwide';
//		}
//
//		return sprintf(
//			'<div class="table-responsive%s">%s</div>',
//			$classes, $block_content
//		);
//	}
//
//	return $block_content;
//}, 10, 2 );

/**
 * Use filter to create new block categories
 *
 * @param array $categories Array of the categories
 * @param object $post Post object
 *
 * @return array
 */
function oppijaportaali_block_categories( $categories, $post ) {
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'new-luuptek-block-category',
				'title' => __( 'Luuptek blocks', 'oppijaportaali' ),
			],
		]
	);
}

add_filter( 'block_categories_all', 'oppijaportaali_block_categories', 10, 2 );

/**
 * Remove jquery-migrate from front end
 *
 * @param object $scripts Scripts object
 */
function dequeue_jquery_migrate( $scripts ) {
	if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff(
			$scripts->registered['jquery']->deps,
			[ 'jquery-migrate' ]
		);
	}
}

add_action( 'wp_default_scripts', 'dequeue_jquery_migrate' );

add_action(
	'template_redirect',
	function () {
		if ( is_search() && ! empty( $_GET['s'] ) ) {
			$engine = ! empty( $_GET['engine'] ) ? $_GET['engine'] : 'google';
			$s      = sanitize_text_field( wp_unslash( $_GET['s'] ) );

			if ( 'google' === $engine ) {
				$to_redirect = "https://www.google.com/search?q={$s}&tbs=lr:lang_1fi&lr=lang_fi";
			} else {
				$to_redirect = "https://duckduckgo.com/?q={$s}&kp=1&kl=fi-fi&kz=-1&kc=1&k1=-1&kn=1&kf=1&kac=-1&kh=1&kae=-1&ka=a&kt=a&kaj=m&kam=google-maps&k9=%23FD4F00&kj=%23333333";
			}
			wp_redirect( $to_redirect );
			exit;
		}
	}
);

/**
 * Lets have a filter after login
 *
 * Redirect "ruotsinkieliset" to sv front page
 *
 * Redirect all rest to fi front page
 *
 * - Need to have oppi school picker plugin active && school abbrevation need to be found from user meta
 *
 */
add_filter(
	'login_redirect',
	function ( $redirect_to, $request, $user ) {
		if ( ! is_user_logged_in() ) {
			return $redirect_to;
		}
		if ( in_array( 'oppi-school-picker/plugin.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$abbrevation = get_user_meta( $user->ID, 'user_data', true ) ? get_user_meta( $user->ID, 'user_data', true ) : false;
			if ( false !== $abbrevation ) {
				$front_page_fi = get_option( 'page_on_front' );

				if ( OppiSchoolPicker\is_ruotsinkielinen( $abbrevation ) ) {
					$to_redirect_id  = pll_get_post( $front_page_fi, 'sv' );
					$to_redirect_url = get_permalink( $to_redirect_id );

					return $to_redirect_url;
				} else {
					$to_redirect_url = get_permalink( $front_page_fi );

					return $to_redirect_url;
				}
			}
		}

		return $redirect_to;
	},
	99,
	3
);

/**
 * Action to modify O365 plugin after token processed
 * So we want sv-people to swedish front page (as in above)
 *
 * See: https://docs.wpo365.com/article/82-developer-hooks
 */
add_action( 'wpo365/oidc/authenticated', 'user_signed_in_with_microsoft', 10, 1 );
add_action( 'wpo365/saml/authenticated', 'user_signed_in_with_microsoft', 10, 1 );
function user_signed_in_with_microsoft( $wp_usr_id ) {
	if ( in_array( 'oppi-school-picker/plugin.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$abbrevation = get_user_meta( $wp_usr_id, 'user_data', true ) ? get_user_meta( $wp_usr_id, 'user_data', true ) : false;
		if ( false !== $abbrevation ) {
			$front_page_fi = get_option( 'page_on_front' );

			if ( OppiSchoolPicker\is_ruotsinkielinen( $abbrevation ) ) {
				$to_redirect_id  = pll_get_post( $front_page_fi, 'sv' );
				$to_redirect_url = get_permalink( $to_redirect_id );

				if ( class_exists( '\Wpo\Services\Log_Service' ) ) {
					\Wpo\Services\Log_Service::write_log( 'WARN', "The hook do_action( 'wpo365_openid_token_processed' ) just fired for user $wp_usr_id. User was redirected to $to_redirect_url" );
				}

				wp_redirect( $to_redirect_url );
				exit();
			}
		}
	}
}

/**
 * Hide WP admin bar from non admins
 */
if ( ! current_user_can( 'manage_options' ) ) {
	add_filter( 'show_admin_bar', '__return_false' );
}

/**
 * Add custom helper text after admin title
 */
add_action( 'edit_form_after_title', 'add_content_after_title' );
function add_content_after_title( $post ) {
	if ( $post->post_type == 'info-popups' ) {
		echo '<div class="notice notice-info is-dismissible"><div class="inside">';
		echo '<p><b>Infoikkunat toiminnallisuudella voit näyttää tiedotteita kaikille tai tietyille helsinkiläisille oppilaille ja opiskelijoille.</b></p>';
		echo '<ol>';
		echo '<li>Laita tiedotteellesi otsikko, max muutaman lauseen sisältö ja linkki.</li>';
		echo '<li>Valitse lapulle (tiedote) taustaväri.</li>';
		echo '<li>Oppiasteet-kohdasta voit valita yhden tai useita oppiasteita, joille tiedotteesi näkyy. Jos haluat, että tiedote näkyy eri kielillä, niin voit valita myös esimerkiksi SV-oppiasteen. Esim. Lukio abit ja Lukio abit SV näyttää tiedotteen kaikille Aulan suomen- ja ruotsinkielisille abeille.</li>';
		echo '<li>Kohdasta "Julkaise" voit joko ajastaa tai julkaista tiedotteen heti.</li>';
		echo '<li>Muista palata katsomaan kuinka monta kertaa tiedotettasi on katsottu ja kun tiedote ei ole enää ajankohtainen, poista se.</li>';
		echo '</ol>';
		echo '</div></div>';
	}
}

/**
 * Add custom post types to be translated in polylang
 */
add_filter(
	'pll_get_post_types',
	function ( $post_types, $false ) {
		$post_types[] = 'services';
		$post_types[] = 'info-popups';
		$post_types[] = 'concentration';
		$post_types[] = '404-content';

		return $post_types;
	},
	10,
	2
);
add_filter(
	'pll_get_taxonomies',
	function ( $taxonomies, $false ) {
		$taxonomies[] = 'service-oppiaste';

		return $taxonomies;
	},
	10,
	2
);


/**
 * IOS splashscreens
 *
 * @hook wp_head
 */
add_action( 'wp_head', function () {

	$imageUri = UTILS()->get_image_uri();

	echo <<<EOT
	\n
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- iPad Pro 12.9" (2048px x 2732px) -->
    <link href="{$imageUri}/ipadpro2_splash.png" sizes="2048x2732" rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" />

    <!-- iPad Pro 10.5" (1668px x 2224px) -->
    <link href="{$imageUri}/ipadpro1_splash.png" sizes="1668x2224" rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" />

    <!-- iPad Mini, Air (1536px x 2048px) -->
    <link href="{$imageUri}/ipad_splash.png" sizes="1536x2048" rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"/>

    <!-- iPhone Xs Max (1242px x 2688px) -->
    <link href="{$imageUri}/iphonexsmax_splash.png" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" />

    <!-- iPhone Xr (828px x 1792px) -->
    <link href="{$imageUri}/iphonexr_splash.png" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" />

    <!-- iPhone X, Xs (1125px x 2436px) -->
    <link href="{$imageUri}/iphonex_splash.png" sizes="1125x2436" rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" />

    <!-- iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px) -->
    <link href="{$imageUri}/iphoneplus_splash.png" sizes="1242x2208" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" />

    <!-- iPhone 8, 7, 6s, 6 (750px x 1334px) -->
    <link href="{$imageUri}/iphone6_splash.png" sizes="750x1334" rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" />
	\n
EOT;
}, 999 );

/**
 * Add iFrame to allowed wp_kses_post tags
 *
 * @param array $tags Allowed tags, attributes, and/or entities.
 * @param string $context Context to judge allowed tags by. Allowed values are 'post'.
 *
 * @return array
 */
function custom_wpkses_post_tags( $tags, $context ) {

	if ( 'post' === $context ) {
		$tags['iframe'] = array(
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		);
	}

	return $tags;
}

add_filter( 'wp_kses_allowed_html', 'custom_wpkses_post_tags', 10, 2 );

add_action( 'show_user_profile', 'add_school_abbrevation_to_profile' );
add_action( 'edit_user_profile', 'add_school_abbrevation_to_profile' );
function add_school_abbrevation_to_profile( $user ) {
	$abbr = get_user_meta( $user->ID, 'user_data', true );

	if ( empty( $abbr ) ) {
		return;
	}
	?>
	<table class="form-table">
		<tr>
			<th><label for="phone"><?php _e( 'Koulun tunnus', 'oppijaportaali' ); ?></label></th>
			<td>
				<?php echo esc_html( $abbr ); ?>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Disable site html link and language dropdown in login.php
 */
add_filter(
	'login_site_html_link',
	function ( $html_link ) {
		$html_link = '';

		return $html_link;
	}
);
add_filter( 'login_display_language_dropdown', '__return_false' );

/**
 * Add chat script based on school
 */
add_filter( 'wp_head', function () {

	// show no chat if, not logged in OR is swe version in page
	if ( ! is_user_logged_in() || pll_current_language() === 'sv' ) {
		return;
	}

	$school_abbrevation = UTILS()->get_user_data_meta();

	// Only load chat if use is from peruskoulu, lukio or ammattikoulu
	if ( ! \OppiSchoolPicker\is_lukio( $school_abbrevation ) && ! \OppiSchoolPicker\is_ammattikoulu( $school_abbrevation ) && ! \OppiSchoolPicker\is_peruskoulu( $school_abbrevation ) ) {
		return;
	}

	if ( \OppiSchoolPicker\is_peruskoulu( $school_abbrevation ) ) {
		if ( ApunappiSchools\is_apunappi_school( $school_abbrevation ) ) {
			?>
			<script
				type="text/javascript"
				id="wbc-widget-button"
				src="https://coh-chat-app-prod.ow6i4n9pdzm.eu-de.codeengine.appdomain.cloud/get-widget-button?tenantId=sote-prod&assistantId=apunappi&engagementId=apunappi">
			</script>
			<?php
		} else {
			?>
			<script src="https://wds.ace.teliacompany.com/wds/instances/J5XKjqJt/ACEWebSDK.min.js"></script>
			<a href="https://hel.humany.net/oppilashuolto-chat"></a>
			<?php
		}

		return;
	}

	if ( \OppiSchoolPicker\is_lukio( $school_abbrevation ) || \OppiSchoolPicker\is_ammattikoulu( $school_abbrevation ) ) {
		// Show or not apunappi chat script
		if ( ApunappiSchools\is_apunappi_school( $school_abbrevation ) || ApunappiSchools\user_has_apunappi_department() ) {
			?>
			<script
				type="text/javascript"
				id="wbc-widget-button"
				src="https://coh-chat-app-prod.ow6i4n9pdzm.eu-de.codeengine.appdomain.cloud/get-widget-button?tenantId=sote-prod&assistantId=apunappi&engagementId=apunappi-toinen">
			</script>
			<?php
		} else {
			?>
			<!-- Shows wrong kind of chatbot, remove for now.
			-->
			<?php
		}
		?>
		<?php
	}
} );

/**
 * When there is disconnectdrive=1 in url ==> delete tokens
 */
add_action( 'get_header', function () {
	if ( ! is_user_logged_in() ) {
		return;
	}

	$current_user_id = get_current_user_id();

	if ( isset( $_GET['disconnectdrive'] ) ) {
		if ( $_GET['disconnectdrive'] === '1' ) {
			delete_user_meta( $current_user_id, 'access_token' );
			delete_user_meta( $current_user_id, 'refresh_token' );
		}
	}
} );


/**
 * Redirect all search page requests to home url
 */
add_action( 'template_redirect', function () {
	if ( is_search() && empty( $_GET['s'] ) ) {
		wp_redirect( home_url() );
		exit;
	}
} );

/**
 * Modify admin view when adding new concentration
 */
add_action( 'edit_form_after_title', function () {
	global $post;
	if ( 'concentration' === $post->post_type ) {
		echo 'Keskittymisen nimi';
	}
} );

add_action( 'edit_form_after_editor', function () {
	global $post;
	if ( 'concentration' === $post->post_type ) {
		echo 'Keskittymisen tekstisisältö';
	}
} );

/**
 * Fake wp login in development
 *
 * @return void
 */
function fake_wp_login_for_localhost() {
	if ( wp_get_environment_type() !== 'development' ) {
		return;
	}

	$user_id = 1; // Change this to the desired user ID
	if ( ! is_user_logged_in() ) {
		wp_set_current_user( $user_id );
		wp_set_auth_cookie( $user_id );
		do_action( 'wp_login', get_userdata( $user_id )->user_login );
	}
}

//add_action( 'init', 'fake_wp_login_for_localhost' );
