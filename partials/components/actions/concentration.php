<?php

$oppiaste_checker = new Oppiaste_checker();

$query_args = [
	'post_type'      => 'concentration',
	'posts_per_page' => - 1,
	'tax_query'      => [
		[
			'taxonomy' => 'service-oppiaste',
			'terms'    => $oppiaste_checker::get_oppiaste_options_term_value(),
		],
	],
];

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() ) {
	wp_reset_postdata();

	return;
}
?>
<li class="actions-wrapper__list-item">
	<a href="#" class="actions-wrapper__list-link actions-wrapper__list-link--main actions-wrapper__list-item--concentration"
	   aria-label="<?php pll_esc_html_e( 'Avaa keskittymisasetukset' ); ?>">
		<?php Utils()->the_svg( 'concentration-icon' ); ?>
	</a>
</li>

