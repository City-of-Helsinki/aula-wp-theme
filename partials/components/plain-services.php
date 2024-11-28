<?php

if ( is_user_logged_in() ) {
	return;
}

$user_services  = new User_services();
$users_services = $user_services->get_user_services();
$all_services   = $user_services->get_services_api_response();
?>
<div class="services-wrapper services-wrapper--no-bg">
	<div class="services-row services-row--active">
		<?php
		Utils()->the_own_services_row( true );
		Utils()->the_services_row( true, $user_services );
		?>
	</div>

	<div class="services-actions-row">
		<div class="services-actions-row__item">

		</div>
		<div class="services-actions-row__item">
			<button class="all-services-toggler" aria-haspopup="true" aria-expanded="false"
			        aria-label="<?php pll_esc_html_e( 'Avaa tai sulje loput palvelut' ); ?>">
				<?php UTILS()->the_svg('arrow-down-shadow'); ?>
			</button>
		</div>
		<div class="services-actions-row__item">
			<?php if ( is_user_logged_in() ) : ?>
				<button class="add-new-service-toggler"
				        title="<?php pll_esc_html_e( 'Avaa uuden palvelun lisääminen' ); ?>"
				        data-toggle="modal" data-target="#add-new-service-modal">
					<span><?php pll_esc_html_e( 'Lisää oma palvelu' ); ?></span>
					<?php Utils()->the_svg( 'add-new-icon' ); ?>
				</button>
			<?php endif; ?>
		</div>
	</div>

	<div class="services-row services-row--inactive">
		<?php
		Utils()->the_services_row( false, $user_services );
		Utils()->the_own_services_row( false );
		?>
	</div>
</div>
