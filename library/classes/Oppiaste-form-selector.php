<?php

if ( ! is_user_logged_in() ) {
	return;
}

class Oppiaste_form_section {

	public static $custom_user_meta_key = 'user_custom_school';

	public static function output_form_section() {
		$school_abbrevation = Utils()->get_user_data_meta();

		// only show for lukio/ammattikoulu
		if ( ! \OppiSchoolPicker\is_lukio( $school_abbrevation ) && ! \OppiSchoolPicker\is_ammattikoulu( $school_abbrevation ) ) {
			return;
		}

		$schools = self::get_different_schools_array();

		if ( count( $schools ) < 2 ) {
			return;
		}

		$custom_selected = false;

		$custom_school = get_user_meta( get_current_user_id(), self::$custom_user_meta_key, true );

		if ( ! empty( $custom_school ) ) {
			$custom_selected = true;
		}
		?>
		<div class="update-user-settings__section">
			<h3 class="update-user-settings-form__subtitle">
				<?php pll_esc_html_e( 'Oletuskoulun valinta' ); ?>
			</h3>
			<div>
				<label for="oppiaste-custom-selection"
					   class="screen-reader-text update-user-settings-form__label">
					<?php pll_esc_html_e( 'Aseta oletuskoulusi' ); ?>
				</label>
				<select id="oppiaste-custom-selection" class="update-user-settings-form__form-field">
					<option
						value="empty"<?php echo $custom_selected ? '' : ' selected' ?>><?php pll_esc_html_e( 'Ei valintaa' ); ?></option>
					<?php
					foreach ( $schools as $key => $value ) {
						$selected = ( $key === $custom_school );
						?>
						<option
							value="<?php echo esc_attr( $key ); ?>"<?php echo $selected ? ' selected' : ''; ?>><?php echo esc_html( $value ); ?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
		<?php
	}

	public static function get_different_schools_array() {
		$user_data = get_user_meta( get_current_user_id(), 'user_data', true );

		if ( ! $user_data ) {
			return [];
		}

		$exoloded = explode( ';', $user_data );

		if ( count( $exoloded ) === 0 ) {
			return [];
		}

		$array = [];

		foreach ( $exoloded as $string ) {
			$school_name = OppiSchoolPicker\get_school_name( $string );

			if ( $school_name ) {
				$array[ $string ] = $school_name;
			}
		}

		/**
		 * Lets also check for departments
		 */
		$user_departments = get_user_meta( get_current_user_id(), 'user_department', true );

		if ( ! $user_departments ) {
			return $array;
		}

		$exoloded = explode( ';', $user_departments );

		if ( count( $exoloded ) === 0 ) {
			return $array;
		}

		foreach ( $exoloded as $string ) {
			$school_name = OppiSchoolPicker\get_school_name( $string );

			if ( $school_name ) {
				$array[ $string ] = $school_name;
			}
		}

		return $array;
	}
}
