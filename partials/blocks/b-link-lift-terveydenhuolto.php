<?php

/**
 * Template to display terveydenhuolto page details
 */

// No show, if Oppi school picker is not installed
if ( ! in_array( 'oppi-school-picker/plugin.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return;
}

// Lets get school abbrevation from user data, if not found don't render anything
$abbrevation = UTILS()->get_user_data_meta();

if ( false === $abbrevation ) {
	return;
}

// No rendering, if lukio
if ( OppiSchoolPicker\is_lukio( $abbrevation ) ) {
	return;
}

$url = OppiSchoolPicker\get_terveydenhuolto_url( $abbrevation );

if ( empty( $url ) ) {
	return;
}

?>
<div class="link-lifts-column">
	<a href="<?php echo esc_url( $url ); ?>" class="link-lifts-column__link" target="_blank"
	   aria-label="<?php echo esc_html( pll__( 'Terveys ja kasvu' ) . Utils()->get_open_new_tab_text() ); ?>">
		<div class="link-lift-item">
			<div class="link-lift-item__icon">
				<img src="<?php echo esc_url( UTILS()->get_image_uri() . '/terveydenhuolto-icon.svg' ); ?>" alt=""/>
			</div>
			<div class="link-lift-item__details">
				<h3 class="link-lift-item__title">
					<?php
					pll_esc_html_e( 'Terveys ja kasvu' );
					?>
				</h3>
				<p class="link-lift-item__description">
					<?php
					pll_esc_html_e( 'Terveydenhoitaja' );
					?>
				</p>
			</div>
		</div>
	</a>
</div>
