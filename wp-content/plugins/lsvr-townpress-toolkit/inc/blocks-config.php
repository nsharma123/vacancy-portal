<?php

// Register custom category
add_filter( 'block_categories', 'lsvr_townpress_toolkit_register_blocks_category' );
if ( ! function_exists( 'lsvr_townpress_toolkit_register_blocks_category' ) ) {
	function lsvr_townpress_toolkit_register_blocks_category( $categories ) {

	    return array_merge( $categories, array(
	        array(
	            'slug' => 'lsvr-townpress-toolkit',
	            'title' => esc_html__( 'TownPress', 'lsvr-townpress-toolkit' ),
	        ),
	    ));

	}
}

// Register blocks
add_action( 'init', 'lsvr_townpress_toolkit_register_blocks', 20 );
if ( ! function_exists( 'lsvr_townpress_toolkit_register_blocks' ) ) {
	function lsvr_townpress_toolkit_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Post slider
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Post_Slider' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-townpress-toolkit/post-slider', array(
					'attributes' => Lsvr_Shortcode_Townpress_Post_Slider::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Townpress_Post_Slider', 'shortcode' ),
				));
			}

    		// Posts
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Posts' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-townpress-toolkit/posts', array(
					'attributes' => Lsvr_Shortcode_Townpress_Posts::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Townpress_Posts', 'shortcode' ),
				));
			}

    		// Sidebar
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Sidebar' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-townpress-toolkit/sidebar', array(
					'attributes' => Lsvr_Shortcode_Townpress_Sidebar::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Townpress_Sidebar', 'shortcode' ),
				));
			}

    		// Sitemap
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Sitemap' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-townpress-toolkit/sitemap', array(
					'attributes' => Lsvr_Shortcode_Townpress_Sitemap::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Townpress_Sitemap', 'shortcode' ),
				));
			}

    		// Weather widget
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Weather_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-townpress-toolkit/weather', array(
					'attributes' => Lsvr_Shortcode_Townpress_Weather_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Townpress_Weather_Widget', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_townpress_toolkit_register_blocks_json' );
if ( ! function_exists( 'lsvr_townpress_toolkit_register_blocks_json' ) ) {
	function lsvr_townpress_toolkit_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Post slider
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Post_Slider' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-townpress-toolkit/post-slider',
					'tag' => 'lsvr_townpress_post_slider',
					'title' => esc_html__( 'TownPress Post Slider', 'lsvr-townpress-toolkit' ),
		        	'description' => esc_html__( 'List of posts in a slider', 'lsvr-townpress-toolkit' ),
		        	'category' => 'lsvr-townpress-toolkit',
		        	'icon' => 'admin-post',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-townpress-toolkit' ),
		        	'attributes' => Lsvr_Shortcode_Townpress_Post_Slider::lsvr_shortcode_atts(),
				)));
			}

			// Posts
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Posts' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-townpress-toolkit/posts',
					'tag' => 'lsvr_townpress_posts',
					'title' => esc_html__( 'TownPress Posts', 'lsvr-townpress-toolkit' ),
		        	'description' => esc_html__( 'List of posts', 'lsvr-townpress-toolkit' ),
		        	'category' => 'lsvr-townpress-toolkit',
		        	'icon' => 'admin-post',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-townpress-toolkit' ),
		        	'attributes' => Lsvr_Shortcode_Townpress_Posts::lsvr_shortcode_atts(),
				)));
			}

			// Sidebar
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Sidebar' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-townpress-toolkit/sidebar',
					'tag' => 'lsvr_townpress_sidebar',
					'title' => esc_html__( 'TownPress Sidebar', 'lsvr-townpress-toolkit' ),
		        	'description' => esc_html__( 'Sidebar with widgets', 'lsvr-townpress-toolkit' ),
		        	'category' => 'lsvr-townpress-toolkit',
		        	'icon' => 'screenoptions',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-townpress-toolkit' ),
		        	'attributes' => Lsvr_Shortcode_Townpress_Sidebar::lsvr_shortcode_atts(),
				)));
			}

			// Sitemap
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Sitemap' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-townpress-toolkit/sitemap',
					'tag' => 'lsvr_townpress_sitemap',
					'title' => esc_html__( 'TownPress Sitemap', 'lsvr-townpress-toolkit' ),
		        	'description' => esc_html__( 'Custom menu', 'lsvr-townpress-toolkit' ),
		        	'category' => 'lsvr-townpress-toolkit',
		        	'icon' => 'networking',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-townpress-toolkit' ),
		        	'attributes' => Lsvr_Shortcode_Townpress_Sitemap::lsvr_shortcode_atts(),
				)));
			}

			// Weather widget
			if ( class_exists( 'Lsvr_Shortcode_Townpress_Weather_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-townpress-toolkit/weather',
					'tag' => 'lsvr_townpress_weather_widget',
					'title' => esc_html__( 'TownPress Weather Widget', 'lsvr-townpress-toolkit' ),
		        	'description' => esc_html__( 'Weather forecast', 'lsvr-townpress-toolkit' ),
		        	'category' => 'lsvr-townpress-toolkit',
		        	'icon' => 'cloud',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-townpress-toolkit' ),
		        	'attributes' => Lsvr_Shortcode_Townpress_Weather_Widget::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>