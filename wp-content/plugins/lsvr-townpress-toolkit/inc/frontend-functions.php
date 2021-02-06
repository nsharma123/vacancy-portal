<?php

// Post terms
if ( ! function_exists( 'lsvr_townpress_toolkit_the_post_terms' ) ) {
	function lsvr_townpress_toolkit_the_post_terms( $post_id, $taxonomy, $template = '%s', $separator = ', ', $limit = 0 ) {

		$terms = wp_get_post_terms( $post_id, $taxonomy );
		$terms_parsed = array();
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				array_push( $terms_parsed, '<a href="' . esc_url( get_term_link( $term->term_id, $taxonomy ) ) . '" class="post__term-link">' . esc_html( $term->name ) . '</a>' );
			}
			if ( $limit > 0 && count( $terms_parsed ) > $limit ) {
				$terms_parsed = array_slice( $terms_parsed, 0, $limit );
			}
		}

		if ( ! empty( $terms_parsed ) ) { ?>

			<span class="post__terms">
				<?php echo sprintf( $template, implode( ', ', $terms_parsed ) ); ?>
			</span>

		<?php }

	}
}

?>