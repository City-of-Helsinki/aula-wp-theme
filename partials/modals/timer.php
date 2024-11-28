<div class="modal fade" id="timer-modal" tabindex="-1" role="dialog" aria-labelledby="timer-modal"
     aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
				        aria-label="<?php pll_esc_html_e( 'Sulje keskittymislaskurin asetukset' ); ?>">
					<span aria-hidden="true"><?php Utils()->the_svg( 'close-icon' ); ?></span>
				</button>
			</div>
			<div class="modal-body">
				<form id="timer-form">
					<h2 class="timer-settings-form__title">
						<?php pll_esc_html_e( 'Aseta keskittymisaika' ); ?>
					</h2>
					<div class="timer-settings-form__row">
						<div class="timer-settings-form__row-column">
							<label for="timer-minutes-input" class="timer-settings-form__label screen-reader-text">
								<?php pll_esc_html_e( 'Kuinka monta minuuttia haluat keskittyä?' ); ?>
							</label>
							<input type="number" min="1" max="999" value="25" id="timer-minutes-input" class="timer-settings-form__form-field timer-settings-form__form-field--minutes">
						</div>
						<div class="timer-settings-form__row-column">
							<button class="timer-settings-form__btn add-new-service-form__btn--timer-minutes" data-timer-minutes="25">
								25m
							</button>
						</div>
						<div class="timer-settings-form__row-column">
							<button class="timer-settings-form__btn add-new-service-form__btn--timer-minutes" data-timer-minutes="15">
								15m
							</button>
						</div>
						<div class="timer-settings-form__row-column">
							<button class="timer-settings-form__btn add-new-service-form__btn--timer-minutes" data-timer-minutes="5">
								5m
							</button>
						</div>
					</div>

					<div class="timer-settings-form__timer-left-wrapper">
						<div class="timer-settings-form__timer-left-wrapper__timer">
							<span class="timer-left-text">25:00</span>
						</div>
					</div>

					<button type="submit" class="timer-settings-form__btn timer-settings-form__btn--start">
						<?php pll_esc_html_e( 'Aloita' ); ?>
					</button>
					<button class="timer-settings-form__btn timer-settings-form__btn--continue" disabled>
						<?php pll_esc_html_e( 'Jatka' ); ?>
					</button>
					<button class="timer-settings-form__btn timer-settings-form__btn--pause" disabled>
						<?php pll_esc_html_e( 'Keskeytä' ); ?>
					</button>
					<button class="timer-settings-form__btn timer-settings-form__btn--stop">
						<?php pll_esc_html_e( 'Lopeta' ); ?>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
