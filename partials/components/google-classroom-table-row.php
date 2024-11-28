<?php

$block_name          = isset( $args['title'] ) ? $args['title'] : null;
$block_url           = isset( $args['url'] ) ? $args['url'] : null;
$block_last_modified = isset( $args['modified_time'] ) ? $args['modified_time'] : null;

$date          = new DateTime( $block_last_modified );
$date_modified = $date->format( 'd.m.Y' );

?>
<tr>
	<td>
		<a href="<?php echo esc_url( $block_url ); ?>" target="_blank"
		   aria-label="<?php echo esc_attr( sprintf( pll__( 'Katso kurssi %s Googlessa' ), $block_name ) . Utils()->get_open_new_tab_text() ); ?>">
			<?php echo esc_html( $block_name ); ?>
		</a>
	</td>
	<td class="table-column-align-right">
		<?php echo esc_html( $date_modified ); ?>
	</td>
</tr>
