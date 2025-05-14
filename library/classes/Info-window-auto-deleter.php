<?php

/**
 * Used to auto delete info windows which archive date is in the past
 *
 * Class Training_auto_deleter
 */
class Info_window_auto_deleter {

	private $today;

	function __construct() {
		$this->today = gmdate( 'Ymd' );
		add_action( 'delete_old_info_windows', [ $this, 'draft_posts' ] );
		$this->register_cron_hook();
	}

	/**
	 * Register hook for cron
	 */
	public function register_cron_hook() {
		if ( ! wp_next_scheduled( 'delete_old_info_windows' ) ) {
			wp_schedule_event( time(), 'hourly', 'delete_old_info_windows' );
		}
	}

	public function draft_posts() {

		/**
		 * Get all info windows when:
		 * 1. archive date < today
		 *
		 * Then, set as draft
		 */
		$query = new WP_Query(
			[
				'post_type'      => 'info-popups',
				'posts_per_page' => - 1,
				'lang'           => '', // All languages queried
				'meta_query'     => [
					'relation' => 'AND',
					[
						'key'     => 'archive_date',
						'compare' => '!=',
						'value'   => '',
					],
					[
						'key'     => 'archive_date',
						'value'   => $this->today,
						'compare' => '<',
					],
				],
			]
		);

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$new_post_status = [
					'ID'          => get_the_ID(),
					'post_status' => 'draft',
				];
				wp_update_post( $new_post_status );
			}
		}

		wp_reset_postdata();
	}
}

$auto_deleter = new Info_window_auto_deleter();
