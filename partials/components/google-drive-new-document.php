<div class="google-drive-buttons-wrapper">
	<a href="#" class="google-drive-new-document-opener" aria-haspopup="true" aria-expanded="false"
	   aria-label="<?php pll_esc_attr__( 'Avaa tai sulje uuden Google dokumentin luomisen valinnat' ) ?>">
		<?php UTILS()->the_svg( 'add-new-icon' ); ?>
		<?php pll_esc_html_e( 'Luo uusi Google-tiedosto' ); ?>
	</a>
	<ul class="google-drive-new-document-options-list">
		<li class="google-drive-new-document-options-list__item">
			<a href="https://docs.google.com/document/create" class="google-drive-new-document-options-list__link"
			   aria-label="<?php pll_esc_attr__( 'Luo uusi Google-docs' ) . UTILS()->get_open_new_tab_text(); ?>"
			   target="_blank">
				<?php UTILS()->the_svg( 'document' ); ?>
				<?php pll_esc_html_e( 'Luo uusi Google-docs' ); ?>
			</a>
		</li>
		<li class="google-drive-new-document-options-list__item">
			<a href="https://docs.google.com/spreadsheets/create" class="google-drive-new-document-options-list__link"
			   aria-label="<?php pll_esc_attr__( 'Luo uusi Google-spreadsheet' ) . UTILS()->get_open_new_tab_text(); ?>"
			   target="_blank">
				<?php UTILS()->the_svg( 'spreadsheet' ); ?>
				<?php pll_esc_html_e( 'Luo uusi Google-spreadsheet' ); ?>
			</a>
		</li>
		<li class="google-drive-new-document-options-list__item">
			<a href="https://docs.google.com/presentation/create" class="google-drive-new-document-options-list__link"
			   aria-label="<?php pll_esc_attr__( 'Luo uusi Google-slides' ) . UTILS()->get_open_new_tab_text(); ?>"
			   target="_blank">
				<?php UTILS()->the_svg( 'slide' ); ?>
				<?php pll_esc_html_e( 'Luo uusi Google-slides' ); ?>
			</a>
		</li>
	</ul>
</div>
