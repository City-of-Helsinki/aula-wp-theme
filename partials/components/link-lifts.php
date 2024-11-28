<?php

/**
 * Don't render anything if not logged in
 */
if ( ! is_user_logged_in() ) {
	return;
}

$school_abbrevation = UTILS()->get_user_data_meta();

$lifts_field = 'link_lifts';

if ( OppiSchoolPicker\is_lukio( $school_abbrevation ) ) {
	$lifts_field = 'link_lifts_lukio';
} elseif ( OppiSchoolPicker\is_ammattikoulu( $school_abbrevation ) ) {
	$lifts_field = 'link_lifts_ammattikoulu';
} elseif ( OppiSchoolPicker\is_varhaiskasvatus( $school_abbrevation ) ) {
	$lifts_field = 'link_lifts_varhaiskasvatus';
}


?>
<div class="link-lifts">
	<div class="link-lifts-wrapper">
		<div class="link-lifts-row">
			<?php
			get_template_part( 'partials/blocks/b-link-lift-school-home' );
			get_template_part( 'partials/blocks/b-link-lift-psykologi' );
			get_template_part( 'partials/blocks/b-link-lift-lunch-lists' );
			get_template_part( 'partials/blocks/b-link-lift-opinto-opas' );
			get_template_part( 'partials/blocks/b-link-lift-kirjastot' );
			get_template_part( 'partials/blocks/b-link-lift-terveydenhuolto' );
			get_template_part( 'partials/blocks/b-link-lift-hobbies' );

			if ( have_rows( $lifts_field ) ) {
				while ( have_rows( $lifts_field ) ) {
					the_row();
					$lift_title       = get_sub_field( 'title' );
					$lift_description = get_sub_field( 'description' );
					$lift_url         = get_sub_field( 'url' );
					$lift_icon        = get_sub_field( 'icon' );

					$args = [
						'title'       => $lift_title,
						'description' => $lift_description,
						'url'         => $lift_url,
						'icon'        => $lift_icon,
					];

					get_template_part( 'partials/blocks/b-link-lift', '', $args );
				}
			}
			?>

		</div>
	</div>
</div>
