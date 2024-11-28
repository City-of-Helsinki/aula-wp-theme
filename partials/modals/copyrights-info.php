<?php
$bing_response = Bing_wallpaper::get_bing_response();

if ( false === $bing_response ) {
	return false;
}
?>
<div class="modal fade" id="copyrights-info-modal" tabindex="-1" role="dialog" aria-labelledby="copyrights-info-modal"
     aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				        aria-label="<?php pll_esc_html_e( 'Sulje tiedot' ); ?>">
					<span aria-hidden="true"><?php Utils()->the_svg( 'close-icon' ); ?></span>
				</button>
			</div>
			<div class="modal-body">
				<p>
					<strong>
						<?php pll_esc_html_e( 'Kuvan tiedot' ); ?>
					</strong>
				</p>
				<p>
					<strong><?php echo esc_html( $bing_response->images[0]->title ); ?></strong><br>
					<a class="copyright-modal-link"
					   href="<?php echo esc_url( $bing_response->images[0]->copyrightlink ); ?>" target="_blank">
						<?php echo esc_html( $bing_response->images[0]->copyright ); ?>
						<?php Utils()->the_svg( 'external-link-icon' ); ?>
					</a>
				</p>
			</div>
		</div>
	</div>
</div>
