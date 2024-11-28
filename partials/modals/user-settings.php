<?php

if ( ! is_user_logged_in() ) {
	return;
}

$user_id                = get_current_user_id();
$multiavatar            = ! empty( get_user_meta( $user_id, 'user_multiavatar', true ) ) ? get_user_meta( $user_id, 'user_multiavatar', true ) : null;
$hide_search            = ! empty( get_user_meta( $user_id, 'user_hide_search', true ) ) ? (int) get_user_meta( $user_id, 'user_hide_search', true ) : null;
$hide_drive             = ! empty( get_user_meta( $user_id, 'user_hide_drive', true ) ) ? (int) get_user_meta( $user_id, 'user_hide_drive', true ) : null;
$hide_classroom         = ! empty( get_user_meta( $user_id, 'user_hide_classroom', true ) ) ? (int) get_user_meta( $user_id, 'user_hide_classroom', true ) : null;
$profile_pic_visibility = ! empty( get_user_meta( $user_id, 'profile_picture_visibility', true ) ) ? get_user_meta( $user_id, 'profile_picture_visibility', true ) : null;
$search_engine          = ! empty( get_user_meta( $user_id, 'search_engine_selection', true ) ) ? get_user_meta( $user_id, 'search_engine_selection', true ) : 'google';
$user_access_token      = get_user_meta( $user_id, 'access_token', true );
$user_refresh_token     = get_user_meta( $user_id, 'refresh_token', true );
?>
<div class="modal fade" id="user-settings-modal" tabindex="-1" role="dialog" aria-labelledby="user-settings-modal"
     aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				        aria-label="<?php pll_esc_html_e( 'Sulje käyttäjäasetukset' ); ?>">
					<span aria-hidden="true"><?php Utils()->the_svg( 'close-icon' ); ?></span>
				</button>
			</div>
			<div class="modal-body">
				<h2 class="update-user-settings-form__title">
					<?php pll_esc_html_e( 'Asetukset' ); ?>
				</h2>
				<div class="update-user-settings__section">
					<h3 class="update-user-settings-form__subtitle">
						<?php pll_esc_html_e( 'Siirry kieliversioon' ); ?>
					</h3>
					<?php get_template_part( 'partials/components/lang-selector' ); ?>
				</div>
				<form id="update-user-settings-form">
					<div class="update-user-settings__section">
						<h3 class="update-user-settings-form__subtitle">
							<?php pll_esc_html_e( 'Sivun asetukset' ); ?>
						</h3>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value=""
							       id="hide-search-input"<?php echo $hide_search === 1 ? ' checked' : ''; ?>>
							<label class="form-check-label" for="hide-search-input">
								<?php pll_esc_html_e( 'Piilota haku' ); ?>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value=""
							       id="hide-drive-input"<?php echo $hide_drive === 1 ? ' checked' : ''; ?>>
							<label class="form-check-label" for="hide-drive-input">
								<?php pll_esc_html_e( 'Piilota Drive' ); ?>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value=""
							       id="hide-classroom-input"<?php echo $hide_classroom === 1 ? ' checked' : ''; ?>>
							<label class="form-check-label" for="hide-classroom-input">
								<?php pll_esc_html_e( 'Piilota Classroom' ); ?>
							</label>
						</div>
						<p style="margin: 1.5rem 0 0 0;"><?php pll_esc_html_e('Driven ja Classroomin piilottaminen vaatii sivun uudelleenlatauksen tallennuksen jälkeen.'); ?></p>
					</div>
					<?php if ( ! empty( $user_access_token ) && ! empty( $user_refresh_token ) ) : ?>
						<div class="update-user-settings__section">
							<h3 class="update-user-settings-form__subtitle">
								<?php pll_esc_html_e( 'Google Drive' ); ?>
							</h3>
							<a href="<?php echo esc_url( home_url( '/' ) . '?disconnectdrive=1' ); ?>"
							   class="lang-menu__link">
								<?php pll_esc_html_e( 'Katkaise drive-yhteys' ); ?>
							</a>
						</div>
					<?php endif; ?>
					<div class="update-user-settings__section">
						<h3 class="update-user-settings-form__subtitle">
							<?php pll_esc_html_e( 'Hakukone' ); ?>
						</h3>
						<div>
							<label for="search-engine-selection"
							       class="screen-reader-text update-user-settings-form__label">
								<?php pll_esc_html_e( 'Aseta hakukone' ); ?>
							</label>
							<select id="search-engine-selection" class="update-user-settings-form__form-field">
								<?php
								$values = [
									[
										'id'   => 'google',
										'name' => pll_esc_html__( 'Google' ),
									],
									[
										'id'   => 'duckduckgo',
										'name' => pll_esc_html__( 'Duckduckgo' ),
									],
								];
								foreach ( $values as $value ) {
									$value_row = $value['id'] === $search_engine ? 'value="' . $value['id'] . '" SELECTED' : 'value="' . $value['id'] . '"';
									?>
									<option <?php echo $value_row; ?>>
										<?php echo esc_html( $value['name'] ); ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
					<?php Oppiaste_form_section::output_form_section(); ?>
					<div class="update-user-settings__section update-user-settings__section--no-separator">
						<h3 class="update-user-settings-form__subtitle">
							<?php pll_esc_html_e( 'Profiilikuva' ); ?>
						</h3>
						<div>
							<label for="profile-image-visibility"
							       class="screen-reader-text update-user-settings-form__label">
								<?php pll_esc_html_e( 'Profiilikuvan näkyvyys' ); ?>
							</label>
							<select id="profile-image-visibility" class="update-user-settings-form__form-field">
								<?php
								$values = [
									[
										'id'   => 'use_empty',
										'name' => pll_esc_html__( 'Tyhjä' ),
									],
									[
										'id'   => 'use_multiavatar',
										'name' => pll_esc_html__( 'Avatar' ),
									],
								];
								foreach ( $values as $value ) {
									$value_row = $value['id'] === $profile_pic_visibility ? 'value="' . $value['id'] . '" SELECTED' : 'value="' . $value['id'] . '"';
									?>
									<option <?php echo $value_row; ?>>
										<?php echo esc_html( $value['name'] ); ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="update-user-settings-form__profile-image-row" id="profile-settings-o365">
							<div
								class="update-user-settings-form__profile-image-column update-user-settings-form__profile-image-column--image">
								<?php
								$profile_pic_url = Utils()->get_o365_profile_pic_url();
								if ( $profile_pic_url ) {
									?>
									<img src="<?php echo esc_url( $profile_pic_url ); ?>"
									     alt="<?php pll_esc_html_e( 'Microsoft-tilin profiilikuva' ); ?>">
									<?php
								} else {
									pll_esc_html_e( 'Sinulla ei ole Microsoft-tiliin tallennettua profiilikuvaa. Voit asettaa sen Teamsissa, jonka jälkeen kuva on seuraavana päivänä käytettävissä täällä Aulassa.' );
								}
								?>
							</div>
							<div
								class="update-user-settings-form__profile-image-column update-user-settings-form__profile-image-column--input">
								<?php
								if ( $profile_pic_url ) {
									pll_esc_html_e( 'Tämä on Microsoft-tilin profiilikuvasi' );
								}
								?>
							</div>
						</div>
						<div class="update-user-settings-form__profile-image-row" id="profile-settings-multiavatar">
							<div
								class="update-user-settings-form__profile-image-column update-user-settings-form__profile-image-column--image">
								<div id="user-settings-multiavatar-preview">
									<?php Utils()->the_svg( 'dummy-person-image' ); ?>
								</div>
							</div>
							<div
								class="update-user-settings-form__profile-image-column update-user-settings-form__profile-image-column--input">
								<label for="profile-image-input"
								       class="screen-reader-text update-user-settings-form__label">
									<?php pll_esc_html_e( 'Profiilikuva' ); ?>
								</label>
								<input type="text" placeholder="<?php pll_esc_html_e( 'Kirjoita tähän jotain...' ); ?>"
								       id="profile-image-input" class="update-user-settings-form__form-field"
								       value="<?php echo esc_attr( $multiavatar ); ?>">
							</div>
						</div>
					</div>
					<button type="submit" class="update-user-settings-form__btn update-user-settings-form__btn--submit">
						<?php pll_esc_html_e( 'Tallenna' ); ?>
						<?php Utils()->the_svg( 'loop-icon' ); ?>
					</button>
					<button class="add-new-service-form__btn add-new-service-form__btn--cancel" data-dismiss="modal">
						<?php pll_esc_html_e( 'Peruuta' ); ?>
					</button>
					<div class="update-user-settings-form__notifications"></div>
				</form>
			</div>
		</div>
	</div>
</div>
