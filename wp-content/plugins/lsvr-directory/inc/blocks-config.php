<?php

// Register blocks
add_action( 'init', 'lsvr_directory_register_blocks', 20 );
if ( ! function_exists( 'lsvr_directory_register_blocks' ) ) {
	function lsvr_directory_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Listing List Widget
			if ( class_exists( 'Lsvr_Shortcode_Listing_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-directory/listing-list-widget', array(
					'attributes' => Lsvr_Shortcode_Listing_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Listing_List_Widget', 'shortcode' ),
				));
			}

    		// Featured Listing Widget
			if ( class_exists( 'Lsvr_Shortcode_Listing_Featured_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-directory/listing-featured-widget', array(
					'attributes' => Lsvr_Shortcode_Listing_Featured_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Listing_Featured_Widget', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_directory_register_blocks_json' );
if ( ! function_exists( 'lsvr_directory_register_blocks_json' ) ) {
	function lsvr_directory_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Listing List Widget
			if ( class_exists( 'Lsvr_Shortcode_Listing_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-directory/listing-list-widget',
					'tag' => 'lsvr_listing_list_widget',
					'title' => esc_html__( 'LSVR Directory Widget', 'lsvr-directory' ),
		        	'description' => esc_html__( 'List of listing posts', 'lsvr-directory' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'location-alt',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-directory' ),
		        	'attributes' => Lsvr_Shortcode_Listing_List_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Featured Listing Widget
			if ( class_exists( 'Lsvr_Shortcode_Listing_Featured_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-directory/listing-featured-widget',
					'tag' => 'lsvr_listing_featured_widget',
					'title' => esc_html__( 'LSVR Featured Listing Widget', 'lsvr-directory' ),
		        	'description' => esc_html__( 'Single listing post', 'lsvr-directory' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'location-alt',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-directory' ),
		        	'attributes' => Lsvr_Shortcode_Listing_Featured_Widget::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>