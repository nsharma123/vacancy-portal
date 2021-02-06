<?php

// Register blocks
add_action( 'init', 'lsvr_people_register_blocks', 20 );
if ( ! function_exists( 'lsvr_people_register_blocks' ) ) {
	function lsvr_people_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Person List Widget
			if ( class_exists( 'Lsvr_Shortcode_Person_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-people/person-list-widget', array(
					'attributes' => Lsvr_Shortcode_Person_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Person_List_Widget', 'shortcode' ),
				));
			}

    		// Featured Person Widget
			if ( class_exists( 'Lsvr_Shortcode_Person_Featured_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-people/person-featured-widget', array(
					'attributes' => Lsvr_Shortcode_Person_Featured_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Person_Featured_Widget', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_people_register_blocks_json' );
if ( ! function_exists( 'lsvr_people_register_blocks_json' ) ) {
	function lsvr_people_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Person List Widget
			if ( class_exists( 'Lsvr_Shortcode_Person_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-people/person-list-widget',
					'tag' => 'lsvr_person_list_widget',
					'title' => esc_html__( 'LSVR People Widget', 'lsvr-people' ),
		        	'description' => esc_html__( 'List of person posts', 'lsvr-people' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'groups',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-people' ),
		        	'attributes' => Lsvr_Shortcode_Person_List_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Featured Person Widget
			if ( class_exists( 'Lsvr_Shortcode_Person_Featured_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-people/person-featured-widget',
					'tag' => 'lsvr_person_featured_widget',
					'title' => esc_html__( 'LSVR Featured Person Widget', 'lsvr-people' ),
		        	'description' => esc_html__( 'Single person post', 'lsvr-people' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'groups',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-people' ),
		        	'attributes' => Lsvr_Shortcode_Person_Featured_Widget::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>