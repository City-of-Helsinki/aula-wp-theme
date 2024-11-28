<?php

namespace LuuptekWP;

class Utils {

	/**
	 * Get custom CPTs
	 *
	 * @return array
	 */
	public function get_custom_post_types() {
		return get_post_types(
			[
				'public'   => true,
				'_builtin' => false,
			]
		);
	}

	/**
	 * Get first category-item
	 *
	 * @param string $taxonomy Taxonomy name
	 *
	 * @return mixed
	 */
	public function get_category( $taxonomy = 'category' ) {
		$categories = wp_get_object_terms( get_the_ID(), $taxonomy );

		return ! empty( $categories ) ? wp_get_object_terms( get_the_ID(), $taxonomy )[0] : null;
	}

	/**
	 * Get whole category-hierarchy
	 *
	 * @param string $taxonomy Taxonomy name
	 *
	 * @return array
	 */
	public function get_category_hierarchy( $taxonomy = 'category' ) {

		$cats     = [];
		$category = wp_get_object_terms( get_the_ID(), $taxonomy )[0];
		$cat_tree = get_ancestors( $category->term_id, $taxonomy );
		array_push( $cat_tree, $category->term_id );
		asort( $cat_tree );

		foreach ( $cat_tree as $cat ) {
			$cats[] = get_term_by( 'id', $cat, $taxonomy );
		}

		return $cats;
	}

	/**
	 * Get parent-most category
	 *
	 * @param string $taxonomy Taxonomy name
	 *
	 * @return mixed
	 */
	public function get_parent_category( $taxonomy = 'category' ) {
		$cats = self::get_category_hierarchy( $taxonomy );

		return $cats[0];
	}

	/**
	 * Get build images uri
	 *
	 * @return string
	 */
	public function get_image_uri() {
		return asset_uri( 'images' );
	}

	/**
	 * Get default image
	 *
	 * @param string $size Thumbmail size
	 *
	 * @return array|false
	 */
	public function get_default_image( $size = 'full' ) {
		$image_id = ! empty( get_option( 'options_oppijaportaali_default_image_id' ) ) ? get_option( 'options_oppijaportaali_default_image_id' ) : null;

		return wp_get_attachment_image_src( $image_id, $size )[0];
	}

	/**
	 * Get first paragraph from text content.
	 *
	 * @param string $text Text of the paragraph
	 *
	 * @return string
	 */
	public function get_first_paragraph( $text ) {
		$str = wpautop( $text );
		$str = substr( $str, 0, strpos( $str, '</p>' ) + 4 );
		$str = strip_tags( $str, '<a><strong><em>' );
		$str = preg_replace( '/\[.*\]\s*/', '', $str );

		return '<p>' . $str . '</p>';
	}

	/**
	 * Retrive post thumbnail (featured image) if defined,
	 * if not, retrieve default post image that's defined in theme settings
	 *
	 * @param string $size Post thumbnail size
	 * @param int $postId ID of the post
	 *
	 * @return false|string
	 */
	public function get_the_featured_image_url( $size = 'full', $postId = null ) {
		$featuredImageUrl = get_the_post_thumbnail_url( $postId, $size );

		if ( $featuredImageUrl ) {
			return $featuredImageUrl;
		} else {
			return $this->get_default_image( $size );
		}
	}

	/**
	 * Return post type name by post id
	 *
	 * @param int $post_id ID of the post
	 * @param string $name What to return (name/slug)
	 *
	 * @return mixed
	 */
	function get_post_type_name_by_post( $post_id, $name = 'name' ) {
		$post_type        = get_post_type( $post_id );
		$post_type_object = get_post_type_object( $post_type );

		return $post_type_object->labels->{$name};
	}

	/**
	 * Echoes some-links
	 *
	 * You can render these anywhere in the theme you want to..
	 */
	function get_social_media_links() {
		$social_medias = [ 'facebook', 'twitter', 'instagram', 'youtube', 'linkedin', 'github' ];

		foreach ( $social_medias as $social_media ) {
			$field  = 'options_oppijaportaali_contact_details_' . $social_media . '_url';
			$option = get_option( $field );

			if ( ! empty( $option ) ) {
				$faClass = 'fa-' . $social_media . '-square';
				if ( 'instagram' === $social_media || 'linkedin' === $social_media ) {
					$faClass = 'fa-' . $social_media;
				}
				?>
				<li>
					<a href="<?php echo esc_url( $option ); ?>" target="_blank"><em
							class="fab <?php echo $faClass ?>" aria-hidden="true"></em></a>
				</li>
				<?php
			}
		}
	}

	function get_current_date_minified() {
		$day = new \DateTime();
		$day->setTimezone( new \DateTimeZone( 'Europe/Helsinki' ) );

		$string = date_i18n( 'l' ) . ' ' . $day->format( 'j.n.Y' );

		if ( pll_current_language() == 'se' ) {
			$string = $day->format( 'j.n.Y' );
		}

		return $string;
	}

	function get_user_first_name() {
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$first_name   = get_user_meta( $current_user->ID, 'first_name', true );

			return $first_name;
		} else {
			return pll__( 'Tuntematon' );
		}
	}

	function get_user_display_name() {
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$name         = $current_user->display_name;

			return substr( $name, 0, strrpos( $name, ' ' ) ); // no last name
		} else {
			return pll__( 'Tuntematon' );
		}
	}

	function get_service_title( $title_fi, $title_sv, $title_en ) {
		$title = $title_fi;
		if ( 'sv' === pll_current_language() ) {
			if ( ! empty( $title_sv ) ) {
				$title = $title_sv;
			}
		}

		if ( 'en' === pll_current_language() ) {
			if ( ! empty( $title_en ) ) {
				$title = $title_en;
			}
		}

		return $title;
	}

	function get_chord_link() {
		$link = get_field( 'chord_link', 'option' );

		if ( 'sv' === pll_current_language() ) {
			$link = get_field( 'chord_link_sv', 'option' );
		}

		if ( 'en' === pll_current_language() ) {
			$link = get_field( 'chord_link_en', 'option' );
		}

		return $link;
	}

	function get_user_data_meta() {

		if ( ! is_user_logged_in() ) {
			return null;
		}

		$user = wp_get_current_user();
		$meta = get_user_meta( $user->ID, 'user_data', true ) ? get_user_meta( $user->ID, 'user_data', true ) : false;

		// Look for custom school value
		$meta = ! empty( get_user_meta( $user->ID, \Oppiaste_form_section::$custom_user_meta_key, true ) ) ? get_user_meta( $user->ID, \Oppiaste_form_section::$custom_user_meta_key, true ) : $meta;

		if ( $meta ) {
			$meta = \OppiSchoolPicker\get_primary_abbrevation( $meta );
		}

		return $meta;
	}

	function get_user_data_meta_no_aakkoset() {

		if ( ! is_user_logged_in() ) {
			return null;
		}

		$user = wp_get_current_user();
		$meta = get_user_meta( $user->ID, 'user_data', true ) ? get_user_meta( $user->ID, 'user_data', true ) : false;

		if ( $meta ) {
			$meta = \OppiSchoolPicker\get_primary_abbrevation( $meta );
		}

		if ( $meta ) {
			$search  = [ 'ä', 'å', 'Ä', 'Å', 'ö', 'Ö' ];
			$replace = [ 'a', 'a', 'A', 'A', 'o', 'O' ];
			$meta    = str_replace( $search, $replace, $meta );
		}

		return $meta;
	}

	function get_helsinki_home_url() {
		$url = 'https://www.hel.fi/kasvatuksen-ja-koulutuksen-toimiala/fi';

		if ( pll_current_language() === 'sv' ) {
			$url = 'https://www.hel.fi/kasvatuksen-ja-koulutuksen-toimiala/sv';
		}

		if ( pll_current_language() === 'en' ) {
			$url = 'https://www.hel.fi/kasvatuksen-ja-koulutuksen-toimiala/en';
		}

		return $url;
	}

	/**
	 * Get svg-image url
	 *
	 * @return string
	 */
	public function get_svg_image_url( $file_name ) {
		return asset_uri( 'images' ) . '/' . $file_name . '.svg';
	}

	/**
	 * Echoes svg directly from images-folder
	 *
	 * @param $file_name
	 */
	function the_svg( $file_name ) {
		readfile( asset_local( 'images' ) . '/' . $file_name . '.svg' );
	}

	/**
	 * Function to get user own services from DB
	 *
	 * @param int $visible Is service visible or not 0/1 (tinyint in db)
	 *
	 * @return array|object|null Results from SQL-query
	 */
	function get_user_own_services( $visible = 1 ) {
		global $wpdb;
		$user_id = get_current_user_id();

		$table_name = "{$wpdb->prefix}user_own_services";
		$sql        = $wpdb->prepare( "SELECT * FROM `$table_name` WHERE visible = %d AND user_id = %d", $visible, $user_id );

		$results = $wpdb->get_results( $sql, OBJECT );

		return $results;
	}

	/**
	 * Helper to echo own services list
	 *
	 * @param bool $is_active To echo active or non active own services
	 */
	function the_own_services_row( $is_active ) {
		$visible             = true === $is_active ? 1 : 0;
		$active_own_services = $this->get_user_own_services( $visible );

		foreach ( $active_own_services as $own_service ) {

			$args = [
				'title'                  => $own_service->service_name,
				'url'                    => $own_service->service_url,
				'own_service_id'         => $own_service->id,
				'own_service_identifier' => $own_service->identifier,
				'description'            => $own_service->service_description,
				'icon_url'               => '',
				'icon_alt'               => '',
				'active_service'         => $is_active,
				'is_own_service'         => true,
			];

			get_template_part( 'partials/blocks/b-service-item', '', $args );
		}
	}

	/**
	 * To echo general services and filter by user settings
	 *
	 * @param bool $is_active Active or non active services
	 * @param Object $user_services User_services class
	 */
	function the_services_row( $is_active, $user_services ) {
		$all_services   = $user_services->get_services_api_response();
		$users_services = $user_services->get_user_services();

		// Check that JSON response has been valid
		if ( $all_services !== false ) {
			foreach ( $all_services as $row ) {
				$service_title       = $row->title;
				$service_post_id     = $row->post_id;
				$service_url         = $row->url;
				$service_icon_url    = $row->icon_url;
				$service_icon_alt    = $row->icon_alt;
				$service_description = $row->description;

				$args = [
					'post_id'        => $service_post_id,
					'title'          => $service_title,
					'url'            => $service_url,
					'description'    => $service_description,
					'icon_url'       => $service_icon_url,
					'icon_alt'       => $service_icon_alt,
					'active_service' => $is_active,
				];

				if ( true === $is_active ) {
					if ( in_array( $row->id, $users_services ) ) {
						get_template_part( 'partials/blocks/b-service-item', '', $args );
					}
				} else {
					if ( ! in_array( $row->id, $users_services ) ) {
						get_template_part( 'partials/blocks/b-service-item', '', $args );
					}
				}
			}
		}
	}

	function the_open_new_tab_text() {
		echo esc_html( ' ' . pll__( '( Linkki avautuu uuteen ikkunaan )' ) );
	}

	function get_open_new_tab_text() {
		return esc_html( ' ' . pll__( '( Linkki avautuu uuteen ikkunaan )' ) );
	}


	function get_o365_profile_pic_url() {
		if ( ! is_user_logged_in() ) {
			return false;
		}

		$user     = wp_get_current_user();
		$user_id  = $user->ID;
		$url_path = O365_PROFILE_IMG_PATH . $user_id . '.png';

		if ( $this->does_url_exists( $url_path ) ) {
			return $url_path;
		} else {
			return false;
		}
	}

	function does_url_exists( $url ) {
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_NOBODY, true );
		curl_exec( $ch );
		$code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

		if ( 200 === $code ) {
			$status = true;
		} else {
			$status = false;
		}
		curl_close( $ch );

		return $status;
	}


	/**
	 * To check if link is youtube link or not
	 *
	 * @param array $link_array Link array from ACF link field
	 *
	 * @return bool
	 */
	function is_acf_link_youtube( $link_array ) {
		if ( ! isset( $link_array['url'] ) ) {
			return false;
		}

		if ( strpos( $link_array['url'], 'watch?v=' ) !== false ) {
			return true;
		}

		if ( strpos( $link_array['url'], '//youtu.be/' ) !== false ) {
			return true;
		}

		return false;
	}

	/**
	 * Get the youtube video ID from the youtube link
	 *
	 * @param array $link_array Link array from ACF link field
	 *
	 * @return bool|mixed|string Youtube ID, expecting link to be https://www.youtube.com/watch?v=VIDEO_ID OR https://youtu.be/VIDEO_ID
	 */
	function get_acf_link_youtube_id( $link_array ) {
		if ( ! isset( $link_array['url'] ) ) {
			return false;
		}

		if ( strpos( $link_array['url'], 'watch?v=' ) !== false ) {
			$exploded_string = explode( 'watch?v=', $link_array['url'] );

			return $exploded_string[1];
		}

		if ( strpos( $link_array['url'], '//youtu.be/' ) !== false ) {
			$exploded_string = explode( '//youtu.be/', $link_array['url'] );

			return $exploded_string[1];
		}

		return false;
	}

	/**
	 * Get array of music track tracks added in backend
	 *
	 * @return array|bool False if empty or array of track urls
	 */
	function get_music_setlist() {
		if ( ! have_rows( 'music_list', 'option' ) ) {
			return false;
		}

		$array = [];

		while ( have_rows( 'music_list', 'option' ) ) {
			the_row();
			$track   = get_sub_field( 'music_track' );
			$array[] = esc_url( $track['url'] );
		}

		return $array;
	}

	function get_svg_file_name_by_mime( $mime_type ) {
		switch ( $mime_type ) {
			case 'application/vnd.google-apps.document':
				return 'document';
			case 'application/vnd.google-apps.spreadsheet':
				return 'spreadsheet';
			case 'application/pdf':
				return 'pdf';
			case 'application/vnd.google-apps.folder':
				return 'folder';
			case 'application/vnd.google-apps.form':
				return 'forms';
			case 'application/vnd.google-apps.presentation':
				return 'slide';
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/png':
			case 'image/gif':
				return 'image';
			default:
				return 'unknown';
		}
	}
}
