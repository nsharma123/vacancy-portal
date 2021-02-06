<?php

// Register blocks
add_action( 'init', 'lsvr_galleries_register_blocks', 20 );
if ( ! function_exists( 'lsvr_galleries_register_blocks' ) ) {
	function lsvr_galleries_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Gallery List Widget
			if ( class_exists( 'Lsvr_Shortcode_Gallery_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-galleries/gallery-list-widget', array(
					'attributes' => Lsvr_Shortcode_Gallery_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Gallery_List_Widget', 'shortcode' ),
				));
			}

    		// Featured Gallery Widget
			if ( class_exists( 'Lsvr_Shortcode_Gallery_Featured_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-galleries/gallery-featured-widget', array(
					'attributes' => Lsvr_Shortcode_Gallery_Featured_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Gallery_Featured_Widget', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_galleries_register_blocks_json' );
if ( ! function_exists( 'lsvr_galleries_register_blocks_json' ) ) {
	function lsvr_galleries_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Gallery List Widget
			if ( class_exists( 'Lsvr_Shortcode_Gallery_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-galleries/gallery-list-widget',
					'tag' => 'lsvr_gallery_list_widget',
					'title' => esc_html__( 'LSVR Galleries Widget', 'lsvr-galleries' ),
		        	'description' => esc_html__( 'List of gallery posts', 'lsvr-galleries' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'format-gallery',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-galleries' ),
		        	'attributes' => Lsvr_Shortcode_Gallery_List_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Featured Gallery Widget
			if ( class_exists( 'Lsvr_Shortcode_Gallery_Featured_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-galleries/gallery-featured-widget',
					'tag' => 'lsvr_gallery_featured_widget',
					'title' => esc_html__( 'LSVR Featured Gallery Widget', 'lsvr-galleries' ),
		        	'description' => esc_html__( 'Single gallery post', 'lsvr-galleries' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'format-gallery',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-galleries' ),
		        	'attributes' => Lsvr_Shortcode_Gallery_Featured_Widget::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>