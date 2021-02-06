<?php

// Register custom category
add_filter( 'block_categories', 'lsvr_elements_register_blocks_category' );
if ( ! function_exists( 'lsvr_elements_register_blocks_category' ) ) {
	function lsvr_elements_register_blocks_category( $categories ) {

	    return array_merge( $categories, array(
	        array(
	            'slug' => 'lsvr-elements',
	            'title' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
	        ),
	    ));

	}
}

// Register blocks
add_action( 'init', 'lsvr_elements_register_blocks', 20 );
if ( ! function_exists( 'lsvr_elements_register_blocks' ) ) {
	function lsvr_elements_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Alert message
			if ( class_exists( 'Lsvr_Shortcode_Alert_Message' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/alert-message', array(
					'attributes' => Lsvr_Shortcode_Alert_Message::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Alert_Message', 'shortcode' ),
				));
			}

    		// Button
			if ( class_exists( 'Lsvr_Shortcode_Button' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/button', array(
					'attributes' => Lsvr_Shortcode_Button::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Button', 'shortcode' ),
				));
			}

    		// Counter
			if ( class_exists( 'Lsvr_Shortcode_Counter' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/counter', array(
					'attributes' => Lsvr_Shortcode_Counter::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Counter', 'shortcode' ),
				));
			}

    		// CTA
			if ( class_exists( 'Lsvr_Shortcode_CTA' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/cta', array(
					'attributes' => Lsvr_Shortcode_CTA::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_CTA', 'shortcode' ),
				));
			}

   			// Definition list widget
			if ( class_exists( 'Lsvr_Shortcode_Definition_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/definition-list-widget', array(
					'attributes' => Lsvr_Shortcode_Definition_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Definition_List_Widget', 'shortcode' ),
				));
			}

    		// Counter
			if ( class_exists( 'Lsvr_Shortcode_Feature' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/feature', array(
					'attributes' => Lsvr_Shortcode_Feature::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Feature', 'shortcode' ),
				));
			}

   			// Featured post widget
			if ( class_exists( 'Lsvr_Shortcode_Post_Featured_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/post-featured-widget', array(
					'attributes' => Lsvr_Shortcode_Post_Featured_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Post_Featured_Widget', 'shortcode' ),
				));
			}

   			// Post list widget
			if ( class_exists( 'Lsvr_Shortcode_Post_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/post-list-widget', array(
					'attributes' => Lsvr_Shortcode_Post_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Post_List_Widget', 'shortcode' ),
				));
			}

    		// Pricing table
			if ( class_exists( 'Lsvr_Shortcode_Pricing_table' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/pricing-table', array(
					'attributes' => Lsvr_Shortcode_Pricing_table::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Pricing_table', 'shortcode' ),
				));
			}

    		// Progress bar
			if ( class_exists( 'Lsvr_Shortcode_Progress_Bar' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-elements/progress-bar', array(
					'attributes' => Lsvr_Shortcode_Progress_Bar::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Progress_Bar', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_elements_register_blocks_json' );
if ( ! function_exists( 'lsvr_elements_register_blocks_json' ) ) {
	function lsvr_elements_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Alert message
			if ( class_exists( 'Lsvr_Shortcode_Alert_Message' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/alert-message',
					'tag' => 'lsvr_alert_message',
					'title' => __( 'LSVR Alert Message', 'lsvr-elements' ),
		        	'description' => __( 'Basic notification message', 'lsvr-elements' ),
		        	'category' => 'lsvr-elements',
		        	'icon' => 'info',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Alert_Message::lsvr_shortcode_atts(),
				)));
			}

			// Button
			if ( class_exists( 'Lsvr_Shortcode_Button' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/button',
					'tag' => 'lsvr_button',
					'title' => __( 'LSVR Button', 'lsvr-elements' ),
		        	'description' => __( 'Basic button with link', 'lsvr-elements' ),
		        	'category' => 'lsvr-elements',
		        	'icon' => 'admin-links',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Button::lsvr_shortcode_atts(),
				)));
			}

			// Counter
			if ( class_exists( 'Lsvr_Shortcode_Counter' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/counter',
					'tag' => 'lsvr_counter',
					'title' => __( 'LSVR Counter', 'lsvr-elements' ),
		        	'description' => __( 'Block with number and label', 'lsvr-elements' ),
		        	'category' => 'lsvr-elements',
		        	'icon' => 'dashboard',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Counter::lsvr_shortcode_atts(),
				)));
			}

			// CTA
			if ( class_exists( 'Lsvr_Shortcode_CTA' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/cta',
					'tag' => 'lsvr_cta',
					'title' => __( 'LSVR CTA', 'lsvr-elements' ),
		        	'description' => __( 'Block with title, text and button', 'lsvr-elements' ),
		        	'category' => 'lsvr-elements',
		        	'icon' => 'align-center',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_CTA::lsvr_shortcode_atts(),
				)));
			}

			// Definition list widget
			if ( class_exists( 'Lsvr_Shortcode_Definition_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/definition-list-widget',
					'tag' => 'lsvr_definition_list_widget',
					'title' => __( 'LSVR Definition List Widget', 'lsvr-elements' ),
		        	'description' => __( 'List of definitions', 'lsvr-elements' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'editor-ul',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Definition_List_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Feature
			if ( class_exists( 'Lsvr_Shortcode_Feature' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/feature',
					'tag' => 'lsvr_feature',
					'title' => __( 'LSVR Feature', 'lsvr-elements' ),
		        	'description' => __( 'Block with icon, title and text', 'lsvr-elements' ),
		        	'category' => 'lsvr-elements',
		        	'icon' => 'star-filled',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Feature::lsvr_shortcode_atts(),
				)));
			}

			// Featured post widget
			if ( class_exists( 'Lsvr_Shortcode_Post_Featured_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/post-featured-widget',
					'tag' => 'lsvr_post_featured_widget',
					'title' => __( 'LSVR Featured Post Widget', 'lsvr-elements' ),
		        	'description' => __( 'Single post', 'lsvr-elements' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'admin-post',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Post_Featured_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Post list widget
			if ( class_exists( 'Lsvr_Shortcode_Post_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/post-list-widget',
					'tag' => 'lsvr_post_list_widget',
					'title' => __( 'LSVR Posts Widget', 'lsvr-elements' ),
		        	'description' => __( 'List of posts', 'lsvr-elements' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'admin-post',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Post_List_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Pricing table
			if ( class_exists( 'Lsvr_Shortcode_Pricing_Table' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/pricing-table',
					'tag' => 'lsvr_pricing_table',
					'title' => __( 'LSVR Pricing Table', 'lsvr-elements' ),
		        	'description' => __( 'Block with title, price, text and button', 'lsvr-elements' ),
		        	'category' => 'lsvr-elements',
		        	'icon' => 'tag',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Pricing_Table::lsvr_shortcode_atts(),
				)));
			}

			// Progress bar
			if ( class_exists( 'Lsvr_Shortcode_Progress_Bar' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-elements/progress-bar',
					'tag' => 'lsvr_progress_bar',
					'title' => __( 'LSVR Progress Bar', 'lsvr-elements' ),
		        	'description' => __( 'Bar with title and label', 'lsvr-elements' ),
		        	'category' => 'lsvr-elements',
		        	'icon' => 'chart-bar',
		        	'panel_title' => __( 'Settings', 'lsvr-elements' ),
		        	'attributes' => Lsvr_Shortcode_Progress_Bar::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>