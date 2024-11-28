<?php

/**
 * Custom post type registering, one per file
 *
 * Use: https://generatewp.com/post-type/
 */
function register_cpt_info_popups() {

	$labels = array(
		'name'                  => _x( 'Info ikkunat', 'Post Type yleinen nimi', 'oppijaportaali' ),
		'singular_name'         => _x( 'Info ikkuna', 'Post Type yksittäinen nimi', 'oppijaportaali' ),
		'menu_name'             => __( 'Info ikkunat', 'oppijaportaali' ),
		'name_admin_bar'        => __( 'Info ikkunat', 'oppijaportaali' ),
		'archives'              => __( 'Arkistot', 'oppijaportaali' ),
		'attributes'            => __( 'Arkistot', 'oppijaportaali' ),
		'parent_item_colon'     => __( 'Yläsivu:', 'oppijaportaali' ),
		'all_items'             => __( 'Kaikki info ikkunat', 'oppijaportaali' ),
		'add_new'               => __( 'Lisää uusi info ikkuna', 'oppijaportaali' ),
		'new_item'              => __( 'Uusi info ikkuna', 'oppijaportaali' ),
		'edit_item'             => __( 'Muokkaa info ikkunaa', 'oppijaportaali' ),
		'update_item'           => __( 'Päivitä info ikkuna', 'oppijaportaali' ),
		'view_item'             => __( 'Katso info ikkuna', 'oppijaportaali' ),
		'view_items'            => __( 'Katso info ikkunat', 'oppijaportaali' ),
		'search_items'          => __( 'Etsi info ikkunoita', 'oppijaportaali' ),
		'not_found'             => __( 'Ei löytynyt', 'oppijaportaali' ),
		'not_found_in_trash'    => __( 'Ei löytynyt roskakorista', 'oppijaportaali' ),
		'featured_image'        => __( 'Julkaisun kuva', 'oppijaportaali' ),
		'set_featured_image'    => __( 'Aseta info ikkunan kuva', 'oppijaportaali' ),
		'remove_featured_image' => __( 'Poista info ikkunan kuva', 'oppijaportaali' ),
		'use_featured_image'    => __( 'Käytä info ikkunan kuvana', 'oppijaportaali' ),
		'insert_into_item'      => __( 'Lisää info ikkunaan', 'oppijaportaali' ),
		'uploaded_to_this_item' => __( 'Ladattu tähän info ikkunaan', 'oppijaportaali' ),
		'items_list'            => __( 'Info ikkunoiden listaus', 'oppijaportaali' ),
		'items_list_navigation' => __( 'Info ikkunoiden navigointi', 'oppijaportaali' ),
		'filter_items_list'     => __( 'Suodata info ikkunoita', 'oppijaportaali' ),
	);
	$args   = array(
		'label'               => __( 'Info ikkunat', 'oppijaportaali' ),
		'description'         => __( 'Info ikkunat kuvaus', 'oppijaportaali' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'author' ),
		'hierarchical'        => true,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'show_in_rest'        => true,
	);
	register_post_type( 'info-popups', $args );
}

add_action( 'init', 'register_cpt_info_popups', 0 );
