<?php
if ( ! is_user_logged_in() ) {
	return;
}
$user_id        = get_current_user_id();
$hide_drive     = ! empty( get_user_meta( $user_id, 'user_hide_drive', true ) ) ? (int) get_user_meta( $user_id, 'user_hide_drive', true ) : null;
$hide_classroom = ! empty( get_user_meta( $user_id, 'user_hide_classroom', true ) ) ? (int) get_user_meta( $user_id, 'user_hide_classroom', true ) : null;
?>
<div class="tabs-wrapper">
	<ul class="action-tabs-nav" role="tablist">
		<li class="action-tabs-nav__item" role="presentation">
			<button class="action-tabs-nav__link action-tabs-nav__link--active" id="services-tab"
			        type="button" role="tab"
			        aria-controls="services-tab-content" aria-selected="true">
				<?php pll_esc_html_e( 'Työkalut' ); ?>
			</button>
		</li>
		<?php if ( $hide_drive !== 1 ) : ?>
			<li class="action-tabs-nav__item" role="presentation">
				<button class="action-tabs-nav__link" id="files-tab" type="button"
				        role="tab"
				        aria-controls="files-tab-content" aria-selected="false">
					<?php pll_esc_html_e( 'Tiedostot' ); ?>
				</button>
			</li>
		<?php endif; ?>
		<?php if ( $hide_classroom !== 1 && Validated_users::is_valid_user() ) : ?>
			<li class="action-tabs-nav__item" role="presentation">
				<button class="action-tabs-nav__link" id="classroom-tab" type="button"
				        role="tab"
				        aria-controls="classroom-tab-content" aria-selected="false">
					<?php pll_esc_html_e( 'Kurssit' ); ?>
				</button>
			</li>
		<?php endif; ?>
	</ul>
	<div class="action-tabs__tab-content" id="actions-tab-content">
		<div class="action-tabs__single-tab action-tabs__single-tab--active" id="services-tab-content" role="tabpanel"
		     aria-labelledby="services-tab">
			<?php get_template_part( 'partials/components/services' ); ?>
		</div>
		<div class="action-tabs__single-tab" id="files-tab-content" role="tabpanel" aria-labelledby="files-tab">
			<div class="drive-loading-overlay" aria-hidden="true">
				<div class="drive-loading-overlay__content">
					<?php Utils()->the_svg( 'refresh' ); ?>
				</div>
			</div>
			<?php get_template_part( 'partials/components/google-drive' ); ?>
		</div>
		<?php if ( $hide_classroom !== 1 && Validated_users::is_valid_user() ) : ?>
			<div class="action-tabs__single-tab" id="classroom-tab-content" role="tabpanel"
			     aria-labelledby="classroom-tab">
				<?php get_template_part( 'partials/components/google-classroom' ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
