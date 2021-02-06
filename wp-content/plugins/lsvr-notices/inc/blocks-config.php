<?php

// Register blocks
add_action( 'init', 'lsvr_notices_register_blocks', 20 );
if ( ! function_exists( 'lsvr_notices_register_blocks' ) ) {
	function lsvr_notices_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Notice List Widget
			if ( class_exists( 'Lsvr_Shortcode_Notice_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-notices/notice-list-widget', array(
					'attributes' => Lsvr_Shortcode_Notice_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Notice_List_Widget', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_notices_register_blocks_json' );
if ( ! function_exists( 'lsvr_notices_register_blocks_json' ) ) {
	function lsvr_notices_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Notice List Widget
			if ( class_exists( 'Lsvr_Shortcode_Notice_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-notices/notice-list-widget',
					'tag' => 'lsvr_notice_list_widget',
					'title' => esc_html__( 'LSVR Notices Widget', 'lsvr-notices' ),
		        	'description' => esc_html__( 'List of notice posts', 'lsvr-notices' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'megaphone',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-notices' ),
		        	'attributes' => Lsvr_Shortcode_Notice_List_Widget::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>