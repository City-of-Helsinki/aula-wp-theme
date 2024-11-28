<li class="actions-wrapper__list-item">
	<a href="#" class="actions-wrapper__list-link actions-wrapper__list-link--main" data-toggle="modal" data-target="#timer-modal"
	   aria-label="<?php pll_esc_html_e( 'Avaa keskittymislaskuri' ); ?>">
		<?php Utils()->the_svg( 'timer-icon' ); ?>
	</a>
	<div class="actions-wrapper-time-left">
		<div class="actions-wrapper-time-left__wrapper">
			<svg class="actions-wrapper-time-left__svg" viewBox="0 0 300 300" width="300" height="300">
				<circle class="actions-wrapper-time-left__svg-circle" id="timer-circle" cx="150" cy="150" r="140"></circle>
			</svg>
			<span class="actions-wrapper-time-left__time-left timer-left-text">15:00</span>
			<button aria-label="<?php pll_esc_html_e( 'Lopeta ajastimen käyttö' ); ?>"
			        class="actions-wrapper-time-left__close">
				<?php Utils()->the_svg( 'close-icon' ); ?>
			</button>
			<button aria-label="<?php pll_esc_html_e( 'Käynnistä ajastin uudelleen' ); ?>"
			        class="actions-wrapper-time-left__repeat">
				<?php Utils()->the_svg( 'repeat-icon' ); ?>
			</button>
			<button aria-label="<?php pll_esc_html_e( 'Pysäytä ajastin' ); ?>"
			        class="actions-wrapper-time-left__pause">
				<?php Utils()->the_svg( 'pause-icon-black' ); ?>
			</button>
			<button aria-label="<?php pll_esc_html_e( 'Jatka ajastimen käyttöä' ); ?>"
			        class="actions-wrapper-time-left__resume">
				<?php Utils()->the_svg( 'play-icon-black' ); ?>
			</button>
		</div>
	</div>
</li>
