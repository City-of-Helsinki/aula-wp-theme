<?php

/**
 * Template to display kirjastot page details
 */

// No show, if Oppi school picker is not installed
if ( ! in_array( 'oppi-school-picker/plugin.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return;
}

// Lets get school abbrevation from user data, if not found don't render anything
$abbrevation = UTILS()->get_user_data_meta();

// No rendering, if ammattikoulu
if ( OppiSchoolPicker\is_ammattikoulu( $abbrevation ) ) {
	return;
}

if ( false === $abbrevation ) {
	return;
}

$url          = OppiSchoolPicker\get_library_url( $abbrevation );
$library_name = OppiSchoolPicker\get_library_name( $abbrevation );

if ( empty( $url ) ) {
	return;
}

?>
<div class="link-lifts-column">
	<a href="<?php echo esc_url( $url ); ?>" class="link-lifts-column__link" target="_blank"
	   aria-label="<?php echo esc_html( pll__( 'Kirjasto' ) . Utils()->get_open_new_tab_text() ); ?>">
		<div class="link-lift-item">
			<div class="link-lift-item__icon">
				<img src="<?php echo esc_url( UTILS()->get_image_uri() . '/kirjastot-icon.svg' ); ?>" alt=""/>
			</div>
			<div class="link-lift-item__details">
				<h3 class="link-lift-item__title">
					<?php
					pll_esc_html_e( 'Kirjasto' );
					?>
				</h3>
				<p class="link-lift-item__description">
					<?php echo esc_html( $library_name ); ?>
				</p>
			</div>
		</div>
	</a>
</div>
