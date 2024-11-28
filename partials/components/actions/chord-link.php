<?php

$randomness = get_field( 'chord_randomness', 'option' );

$randomness_array = explode( '/', $randomness );

// No randomness? No rendering...
if ( ! is_array( $randomness_array ) ) {
	return;
}

// No numeric values? No rendering...
if ( ! is_numeric( $randomness_array[0] ) || ! is_numeric( $randomness_array[1] ) ) {
	return;
}

$random = rand( $randomness_array[0], $randomness_array[1] );

if ( 1 !== $random ) {
	return;
}

$chord_link = UTILS()->get_chord_link();

// If there's no chord link, no rendering..
if ( empty( $chord_link ) ) {
	return;
}
?>
<li class="actions-wrapper__list-item">
	<a href="<?php echo esc_url( $chord_link ); ?>" class="actions-wrapper__list-link actions-wrapper__list-link--main chord-link"
	   title="<?php pll_esc_html_e( 'Avaa mysteeri' ); ?>">
		<?php Utils()->the_svg( 'chords' ); ?>
	</a>
</li>
