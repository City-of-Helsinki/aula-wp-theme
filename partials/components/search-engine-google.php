<div class="search-engine-wrapper search-engine-wrapper--google">
	<form role="search" method="get" class="searchform"
	      action="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">
		<div class="search-engine-form-group">
			<div class="search-engine-wrapper__google-icon">
				<img src="<?php echo UTILS()->get_image_uri() . '/google-icon.svg' ?>" alt=""/>
			</div>
			<label class="screen-reader-text" for="s"><?php pll_esc_html_e( 'Hae Googlesta' ); ?></label>
			<input type="text" class="search-engine-form-control" name="s" id="s" autocomplete="off" />
			<button type="submit" class="search-engine-form-control__submit" title="<?php pll_esc_html_e('Aloita haku'); ?>">
				<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<g fill="none" fill-rule="evenodd">
						<path d="M0 0h24v24H0z"></path>
						<path class="icon-fill"
						      d="M15 1a8 8 0 11-4.798 14.402l-6.401 6.4-1.591-1.59 6.398-6.4A8 8 0 0115 1zm0 2a6 6 0 100 12 6 6 0 000-12z"
						      fill="currentColor"></path>
					</g>
				</svg>
			</button>
		</div>
		<input type="hidden" name="engine" value="google">
	</form>
</div>
