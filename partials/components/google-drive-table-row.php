<?php

$block_name          = isset( $args['title'] ) ? $args['title'] : null;
$block_mime_type     = isset( $args['mime_type'] ) ? $args['mime_type'] : null;
$block_url           = isset( $args['url'] ) ? $args['url'] : null;
$block_owners        = isset( $args['owners'] ) ? $args['owners'] : null;
$block_last_modified = isset( $args['modified_time'] ) ? $args['modified_time'] : null;
$block_is_mine       = isset( $args['is_mine'] ) ? $args['is_mine'] : false;

$date          = new DateTime( $block_last_modified );
$date_modified = $date->format( 'd.m.Y' );

$svg_name = Utils()->get_svg_file_name_by_mime( $block_mime_type );
?>
<tr>
	<td class="icon-column" aria-hidden="true">
		<?php Utils()->the_svg( $svg_name ); ?>
	</td>
	<td>
		<a href="<?php echo esc_url( $block_url ); ?>" target="_blank"
		   aria-label="<?php echo esc_attr( sprintf( pll__( 'Katso tiedosto %s Googlessa' ), $block_name ) . Utils()->get_open_new_tab_text() ); ?>">
			<?php echo esc_html( $block_name ); ?>
		</a>
	</td>
	<td class="table-column-align-right">
		<?php
		if ( $block_is_mine ) {
			pll_esc_html_e( 'Minä' );
		} else {
			$i = 1;
			foreach ( $block_owners as $owner ) {
				echo esc_html( $owner->displayName );
				if ( $i > 1 ) {
					echo '<br>';
				}
				$i ++;
			}
		}
		?>
	</td>
	<td class="table-column-align-right">
		<?php echo esc_html( $date_modified ); ?>
	</td>
</tr>
