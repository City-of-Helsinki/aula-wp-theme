<?php

/**
 * Custom taxonomy registering, one per file
 *
 * Use: https://generatewp.com/post-type/
 */
function register_service_oppiaste_taxonomy() {
	$tax_labels = array(
		'name'                       => _x( 'Oppiasteet', 'blogs-creator taxonomy general name', 'sakke' ),
		'singular_name'              => _x( 'Oppiaste', 'blogs-creator taxonomy singular name', 'sakke' ),
		'menu_name'                  => __( 'Oppiasteet', 'sakke' ),
		'all_items'                  => __( 'Kaikki oppiasteet', 'sakke' ),
		'parent_item'                => __( 'Ylempi oppiaste', 'sakke' ),
		'parent_item_colon'          => __( 'Ylempi oppiaste:', 'sakke' ),
		'new_item_name'              => __( 'Uusi oppiaste', 'sakke' ),
		'add_new_item'               => __( 'Lisää uusi oppiaste', 'sakke' ),
		'edit_item'                  => __( 'Muokkaa oppiastea', 'sakke' ),
		'update_item'                => __( 'Päivitä oppiaste', 'sakke' ),
		'view_item'                  => __( 'Katso oppiaste', 'sakke' ),
		'separate_items_with_commas' => __( 'Erottele pilkuilla', 'sakke' ),
		'add_or_remove_items'        => __( 'Lisää ja poista oppiasteita', 'sakke' ),
		'choose_from_most_used'      => __( 'Valitse eniten käytetyistä', 'sakke' ),
		'popular_items'              => __( 'Suositut oppiasteet', 'sakke' ),
		'search_items'               => __( 'Etsi oppiasteita', 'sakke' ),
		'not_found'                  => __( 'Ei löytynyt', 'sakke' ),
		'no_terms'                   => __( 'Ei oppiasteita', 'sakke' ),
		'items_list'                 => __( 'Oppiasteiden listaus', 'sakke' ),
		'items_list_navigation'      => __( 'Oppiasteiden navigointi', 'sakke' ),
	);
	$tax_args   = array(
		'labels'            => $tax_labels,
		'hierarchical'      => true,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => false,
		'show_in_rest'      => true,
	);
	register_taxonomy( 'service-oppiaste', [ 'services', 'info-popups', 'concentration' ], $tax_args );
}

add_action( 'init', 'register_service_oppiaste_taxonomy', 5 );
