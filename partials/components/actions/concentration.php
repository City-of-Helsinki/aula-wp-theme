<?php

$oppiaste_checker = new Oppiaste_checker();

$query_args = [
	'post_type'      => 'concentration',
	'posts_per_page' => 10, // set some max limit
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

