<?php
$timed_service = new Timed_service_message();
$status        = get_field( 'service_fault_message_status', 'option' );

if ( $timed_service->is_service_active() ) {
	$theme_field     = 'options_timed_service_fault_theme';
	$message_field   = 'options_timed_service_fault_message';
	$read_more_field = 'options_timed_service_fault_message_read_more';
} else {
	$theme_field     = 'options_service_fault_theme';
	$message_field   = 'options_service_fault_message';
	$read_more_field = 'options_service_fault_message_read_more';
}

$theme             = ! empty( get_option( $theme_field ) ) ? get_option( $theme_field ) : 'engel';
$message           = get_option( $message_field );
$read_more_message = get_option( $read_more_field );

if ( $status === true || $timed_service->is_service_active() ) {
	?>
	<div class="service-failure-wrapper">
		<div class="service-failure <?php echo 'service-failure--' . $theme; ?>">
			<p class="service-failure__content">
				<?php Utils()->the_svg( 'alert-circle-full' ); ?> <?php echo $message; ?>
				<?php if ( ! empty( $read_more_message ) ) : ?>
					<button class="btn btn-transparent-black-color pull-right" id="toggle-service-failure">
						<?php pll_esc_html_e( 'Lue lisää' ); ?>
					</button>
				<?php endif; ?>
			</p>
			<?php if ( ! empty( $read_more_message ) ) : ?>
				<div class="service-failure-read-more-content">
					<?php echo apply_filters( 'the_content', $read_more_message ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}
?>
