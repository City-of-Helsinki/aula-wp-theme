<li class="actions-wrapper__list-item">
	<a href="#" aria-haspopup="true" aria-expanded="false" class="actions-wrapper__list-link actions-wrapper__list-link--main toggle-music-controls" aria-label="<?php pll_esc_html_e( 'Avaa tai sulje musiikin kuuntelun asetukset' ); ?>">
		<?php Utils()->the_svg( 'headphones-icon' ); ?>
	</a>
	<div class="actions-wrapper-music-actions-wrapper">
		<ul class="actions-wrapper__list">
			<li class="actions-wrapper__list-item">
				<a href="#" class="actions-wrapper__list-link actions-wrapper__list-link--button-press" data-button-type="start-music" aria-label="<?php pll_esc_html_e( 'Aloita musiikin kuuntelu' ); ?>">
					<?php Utils()->the_svg( 'play-icon' ); ?>
					<?php Utils()->the_svg( 'equalizer' ); ?>
				</a>
			</li>
			<li class="actions-wrapper__list-item">
				<a href="#" class="actions-wrapper__list-link actions-wrapper__list-link--button-press" data-button-type="pause-music" aria-label="<?php pll_esc_html_e( 'Keskeytä musiikin kuuntelu' ); ?>">
					<?php Utils()->the_svg( 'pause-icon' ); ?>
				</a>
			</li>
			<li class="actions-wrapper__list-item">
				<a href="#" class="actions-wrapper__list-link actions-wrapper__list-link--button-press" data-button-type="forward-music" aria-label="<?php pll_esc_html_e( 'Seuraava kappale' ); ?>">
					<?php Utils()->the_svg( 'next-icon' ); ?>
				</a>
			</li>
			<li class="actions-wrapper__list-item">
				<a href="#" class="actions-wrapper__list-link actions-wrapper__list-link--button-press" data-button-type="previous-music" aria-label="<?php pll_esc_html_e( 'Edellinen kappale' ); ?>">
					<?php Utils()->the_svg( 'previous-icon' ); ?>
				</a>
			</li>
		</ul>
	</div>
</li>
