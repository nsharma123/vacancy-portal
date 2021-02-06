<?php

// Register blocks
add_action( 'init', 'lsvr_events_register_blocks', 20 );
if ( ! function_exists( 'lsvr_events_register_blocks' ) ) {
	function lsvr_events_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Event List Widget
			if ( class_exists( 'Lsvr_Shortcode_Event_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-events/event-list-widget', array(
					'attributes' => Lsvr_Shortcode_Event_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Event_List_Widget', 'shortcode' ),
				));
			}

    		// Featured Event Widget
			if ( class_exists( 'Lsvr_Shortcode_Event_Featured_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-events/event-featured-widget', array(
					'attributes' => Lsvr_Shortcode_Event_Featured_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Event_Featured_Widget', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_events_register_blocks_json' );
if ( ! function_exists( 'lsvr_events_register_blocks_json' ) ) {
	function lsvr_events_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Event List Widget
			if ( class_exists( 'Lsvr_Shortcode_Event_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-events/event-list-widget',
					'tag' => 'lsvr_event_list_widget',
					'title' => esc_html__( 'LSVR Events Widget', 'lsvr-events' ),
		        	'description' => esc_html__( 'List of event posts', 'lsvr-events' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'calendar-alt',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-events' ),
		        	'attributes' => Lsvr_Shortcode_Event_List_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Featured Event Widget
			if ( class_exists( 'Lsvr_Shortcode_Event_Featured_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-events/event-featured-widget',
					'tag' => 'lsvr_event_featured_widget',
					'title' => esc_html__( 'LSVR Featured Event Widget', 'lsvr-events' ),
		        	'description' => esc_html__( 'Single event post', 'lsvr-events' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'calendar-alt',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-events' ),
		        	'attributes' => Lsvr_Shortcode_Event_Featured_Widget::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>