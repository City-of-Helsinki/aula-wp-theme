<?php

$current_user_id     = get_current_user_id();
$closed_info_windows = get_user_meta( $current_user_id, '_user_closed_info_windows', true ) ? get_user_meta( $current_user_id, '_user_closed_info_windows', true ) : [];
$hided_info_windows  = get_user_meta( $current_user_id, '_user_hided_info_windows', true ) ? get_user_meta( $current_user_id, '_user_hided_info_windows', true ) : [];
$oppiaste_checker    = new Oppiaste_checker();

$query_args = [
	'post_type'      => 'info-popups',
	'posts_per_page' => 3,
	'post__not_in'   => $hided_info_windows,
	'tax_query'      => [
		[
			'taxonomy' => 'service-oppiaste',
			'terms'    => $oppiaste_checker::get_oppiaste_options_term_value(),
		],
	],
];

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() ) {
	wp_reset_postdata();

	return;
}
?>
<div class="all-info-windows">
	<?php
	while ( $query->have_posts() ) {
		$query->the_post();
		$link_array                     = get_field( 'link', get_the_ID() );
		$info_window_modal_body_classes = [ 'info-window-modal-body' ];
		$is_youtube                     = UTILS()->is_acf_link_youtube( $link_array );

		if ( $is_youtube ) {
			$info_window_modal_body_classes[] = 'info-window-modal-body--is-video';
		}

		$block_args = [
			'id'      => get_the_ID(),
			'title'   => get_the_title(),
			'text'    => get_field( 'text', get_the_ID() ),
			'link'    => $link_array,
			'bgcolor' => ! empty( get_field( 'bgcolor', get_the_ID() ) ) ? get_field( 'bgcolor', get_the_ID() ) : 'orginal-yellow',
		];

		if ( in_array( $block_args['id'], $closed_info_windows ) ) {
			$block_args['bgcolor'] = 'disabled-grey';
		}

		if ( in_array( $block_args['id'], $hided_info_windows ) ) {
			$block_args['bgcolor'] = 'hidden';
		}

		$info_window_modal_body_classes[] = 'info-window-modal-body--' . $block_args['bgcolor'];
		?>
		<div class="single-info-window">
			<div class="info-window-opener">
				<button
					class="info-window-opener__button info-window-opener__button--<?php echo esc_attr( $block_args['bgcolor'] ) ?>"
					aria-label="<?php echo pll_esc_html__( 'Lue lisää aiheesta:' ) . esc_html( $block_args['title'] ); ?>"
					data-post-id="<?php echo esc_attr( $block_args['id'] ); ?>">
					<?php Utils()->the_svg( 'info-circle-icon' ); ?>
				</button>
				<button aria-label="<?php pll_esc_html_e( 'Piilota infoikkuna pysyvästi' ); ?>"
				        data-post-id="<?php echo esc_attr( $block_args['id'] ); ?>"
				        data-user-id="<?php echo esc_attr( $current_user_id ); ?>"
				        class="info-window-opener__close info-window-opener__close--<?php echo esc_attr( $block_args['bgcolor'] ); ?>">
					<?php Utils()->the_svg( 'close-icon' ); ?>
				</button>
			</div>
			<div class="info-window-modal" tabindex="-1" aria-hidden="true" role="dialog">
				<div
					class="<?php echo esc_attr( implode( ' ', $info_window_modal_body_classes ) ); ?>">
					<button aria-label="<?php pll_esc_html_e( 'Sulje infoikkuna' ); ?>"
					        data-post-id="<?php echo esc_attr( $block_args['id'] ); ?>"
					        data-user-id="<?php echo esc_attr( $current_user_id ); ?>"
					        class="info-window-modal-body__close info-window-modal-body__close--<?php echo esc_attr( $block_args['bgcolor'] ); ?>">
						<?php Utils()->the_svg( 'close-icon' ); ?>
					</button>
					<div class="info-window-modal-body__title-row">
						<div class="info-window-modal-body__title-row-icon">
							<?php Utils()->the_svg( 'info-circle-icon' ); ?>
						</div>
						<h3 class="info-window-modal-body__title">
							<?php echo esc_html( $block_args['title'] ); ?>
						</h3>
					</div>
					<p class="info-window-modal-body__text">
						<?php echo esc_html( $block_args['text'] ); ?>
						<?php if ( $is_youtube ): ?>
						<?php
						$video_id = UTILS()->get_acf_link_youtube_id( $link_array );
						?>
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item"
						        src="https://www.youtube.com/embed/<?php echo esc_attr( $video_id ); ?>"
						        allowfullscreen></iframe>
					</div>
					<?php endif; ?>
					</p>
					<?php if ( ! $is_youtube ) : ?>
						<?php if ( ! empty( $block_args['link'] ) ) : ?>
							<a href="<?php echo esc_url( $block_args['link']['url'] ); ?>"
							   class="info-window-modal-body__readmore"
							   target="<?php echo esc_attr( $block_args['link']['target'] ); ?>"
							   data-post-id="<?php echo esc_attr( $block_args['id'] ); ?>">
								<?php echo esc_html( $block_args['link']['title'] ); ?>
							</a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	wp_reset_postdata();
	?>
</div>
