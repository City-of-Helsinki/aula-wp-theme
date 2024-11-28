<?php

/**
 * Template to display school home page details
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

$school_name = OppiSchoolPicker\get_school_name( $abbrevation );
$school_url  = OppiSchoolPicker\get_school_url( $abbrevation );

// In case some error in abbrevation
if ( false === $school_name ) {
	return;
}

?>
<div class="link-lifts-column">
	<a href="<?php echo esc_url( $school_url ); ?>" class="link-lifts-column__link" target="_blank"
	   aria-label="<?php echo esc_html( pll__( 'Koulun kotisivu' ) . Utils()->get_open_new_tab_text() ); ?>">
		<div class="link-lift-item">
			<div class="link-lift-item__icon">
				<img src="<?php echo esc_url( UTILS()->get_image_uri() . '/home-icon.svg' ); ?>" alt=""/>
			</div>
			<div class="link-lift-item__details">
				<h3 class="link-lift-item__title">
					<?php
					if ( OppiSchoolPicker\is_ammattikoulu( $abbrevation ) ) {
						pll_esc_html_e( 'Kotisivu' );
					} elseif ( OppiSchoolPicker\is_lukio( $abbrevation ) ) {
						pll_esc_html_e( 'Lukion kotisivu' );
					} else {
						pll_esc_html_e( 'Koulun kotisivu' );
					}
					?>
				</h3>
				<p class="link-lift-item__description">
					<?php echo esc_html( $school_name ); ?>
				</p>
			</div>
		</div>
	</a>
</div>
