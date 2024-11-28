<div class="link-lifts-column">
	<a href="<?php echo esc_url( $args['url'] ); ?>" class="link-lifts-column__link" target="_blank"
	   aria-label="<?php echo esc_html( $args['title'] . Utils()->get_open_new_tab_text() ); ?>">
		<div class="link-lift-item">
			<div class="link-lift-item__icon">
				<img src="<?php echo esc_url( $args['icon']['url'] ); ?>"
				     alt="<?php echo esc_attr( $args['icon']['alt'] ); ?>"/>
			</div>
			<div class="link-lift-item__details">
				<h3 class="link-lift-item__title">
					<?php echo esc_html( $args['title'] ); ?>
				</h3>
				<p class="link-lift-item__description">
					<?php echo esc_html( $args['description'] ); ?>
				</p>
			</div>
		</div>
	</a>
</div>
