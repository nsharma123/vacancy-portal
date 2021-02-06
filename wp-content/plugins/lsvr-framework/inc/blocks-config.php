<?php

// Register custom category
add_filter( 'block_categories', 'lsvr_framework_register_blocks_category' );
if ( ! function_exists( 'lsvr_framework_register_blocks_category' ) ) {
	function lsvr_framework_register_blocks_category( $categories ) {

	    return array_merge( $categories, array(
	        array(
	            'slug' => 'lsvr-widgets',
	            'title' => esc_html__( 'LSVR Widgets', 'lsvr-framework' ),
	        ),
	    ));

	}
}

?>