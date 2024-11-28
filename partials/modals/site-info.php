<?php
$info_content = get_field( 'site_info_content', 'option' );
?>
<div class="modal fade" id="site-info-modal" tabindex="-1" role="dialog" aria-labelledby="site-info-modal"
     aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				        aria-label="<?php pll_esc_html_e( 'Sulje sivun tiedot' ); ?>">
					<span aria-hidden="true"><?php Utils()->the_svg( 'close-icon' ); ?></span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo wp_kses_post( apply_filters( 'the_content', $info_content ) ); ?>
			</div>
		</div>
	</div>
</div>
