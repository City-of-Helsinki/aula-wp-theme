<?php

/**
 * Custom post type registering, one per file
 *
 * Use: https://generatewp.com/post-type/
 */
function register_cpt_404_content() {

	$labels = array(
		'name'                  => _x( '404 sisältö', 'Post Type yleinen nimi', 'oppijaportaali' ),
		'singular_name'         => _x( '404 sisältö', 'Post Type yksittäinen nimi', 'oppijaportaali' ),
		'menu_name'             => __( '404 sisältö', 'oppijaportaali' ),
		'name_admin_bar'        => __( '404 sisältö', 'oppijaportaali' ),
		'archives'              => __( 'Arkistot', 'oppijaportaali' ),
		'attributes'            => __( 'Arkistot', 'oppijaportaali' ),
		'parent_item_colon'     => __( 'Yläsivu:', 'oppijaportaali' ),
		'all_items'             => __( 'Kaikki 404 sisältö', 'oppijaportaali' ),
		'add_new'               => __( 'Lisää uusi 404 sisältö', 'oppijaportaali' ),
		'new_item'              => __( 'Uusi 404 sisältö', 'oppijaportaali' ),
		'edit_item'             => __( 'Muokkaa 404 sisältöä', 'oppijaportaali' ),
		'update_item'           => __( 'Päivitä 404 sisältö', 'oppijaportaali' ),
		'view_item'             => __( 'Katso 404 sisältö', 'oppijaportaali' ),
		'view_items'            => __( 'Katso 404 sisältö', 'oppijaportaali' ),
		'search_items'          => __( 'Etsi info ikkunoita', 'oppijaportaali' ),
		'not_found'             => __( 'Ei löytynyt', 'oppijaportaali' ),
		'not_found_in_trash'    => __( 'Ei löytynyt roskakorista', 'oppijaportaali' ),
		'featured_image'        => __( 'Julkaisun kuva', 'oppijaportaali' ),
		'set_featured_image'    => __( 'Aseta 404 sisältön kuva', 'oppijaportaali' ),
		'remove_featured_image' => __( 'Poista 404 sisältön kuva', 'oppijaportaali' ),
		'use_featured_image'    => __( 'Käytä 404 sisältön kuvana', 'oppijaportaali' ),
		'insert_into_item'      => __( 'Lisää 404 sisältöan', 'oppijaportaali' ),
		'uploaded_to_this_item' => __( 'Ladattu tähän 404 sisältöan', 'oppijaportaali' ),
		'items_list'            => __( 'Info ikkunoiden listaus', 'oppijaportaali' ),
		'items_list_navigation' => __( 'Info ikkunoiden navigointi', 'oppijaportaali' ),
		'filter_items_list'     => __( 'Suodata info ikkunoita', 'oppijaportaali' ),
	);
	$args   = array(
		'label'               => __( '404 sisältö', 'oppijaportaali' ),
		'description'         => __( '404 sisältö kuvaus', 'oppijaportaali' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => false,
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
	register_post_type( '404-content', $args );
}

add_action( 'init', 'register_cpt_404_content', 0 );
