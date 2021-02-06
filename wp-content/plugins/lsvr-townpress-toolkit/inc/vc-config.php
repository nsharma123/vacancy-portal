<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_townpress_toolkit_vc_config' );
if ( ! function_exists( 'lsvr_townpress_toolkit_vc_config' ) ) {
	function lsvr_townpress_toolkit_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_townpress_toolkit_vc_init' );
			if ( ! function_exists( 'lsvr_townpress_toolkit_vc_init' ) && function_exists( 'vc_set_as_theme' ) ) {
				function lsvr_townpress_toolkit_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_townpress_toolkit_register_vc_elements' );
			if ( ! function_exists( 'lsvr_townpress_toolkit_register_vc_elements' ) ) {
				function lsvr_townpress_toolkit_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Post slider
						if ( class_exists( 'Lsvr_Shortcode_Townpress_Post_Slider' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_townpress_post_slider',
				                'name' => esc_html__( 'TownPress Post Slider', 'lsvr-townpress-toolkit' ),
				                'description' => esc_html__( 'List of posts in a slider', 'lsvr-townpress-toolkit' ),
				                'category' => esc_html__( 'TownPress', 'lsvr-townpress-toolkit' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Townpress_Post_Slider::lsvr_shortcode_atts(),
							));
						}

						// Posts
						if ( class_exists( 'Lsvr_Shortcode_Townpress_Posts' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_townpress_posts',
				                'name' => esc_html__( 'TownPress Posts', 'lsvr-townpress-toolkit' ),
				                'description' => esc_html__( 'List of posts', 'lsvr-townpress-toolkit' ),
				                'category' => esc_html__( 'TownPress', 'lsvr-townpress-toolkit' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Townpress_Posts::lsvr_shortcode_atts(),
							));
						}

						// Sidebar
						if ( class_exists( 'Lsvr_Shortcode_Townpress_Sidebar' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_townpress_sidebar',
				                'name' => esc_html__( 'TownPress Sidebar', 'lsvr-townpress-toolkit' ),
				                'description' => esc_html__( 'Sidebar with widgets', 'lsvr-townpress-toolkit' ),
				                'category' => esc_html__( 'TownPress', 'lsvr-townpress-toolkit' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Townpress_Sidebar::lsvr_shortcode_atts(),
							));
						}

						// Sitemap
						if ( class_exists( 'Lsvr_Shortcode_Townpress_Sitemap' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_townpress_sitemap',
				                'name' => esc_html__( 'TownPress Sitemap', 'lsvr-townpress-toolkit' ),
				                'description' => esc_html__( 'Custom menu', 'lsvr-townpress-toolkit' ),
				                'category' => esc_html__( 'TownPress', 'lsvr-townpress-toolkit' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Townpress_Sitemap::lsvr_shortcode_atts(),
							));
						}

						// Weather widget
						if ( class_exists( 'Lsvr_Shortcode_Townpress_Weather_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_townpress_weather_widget',
				                'name' => esc_html__( 'TownPress Weather Widget', 'lsvr-townpress-toolkit' ),
				                'description' => esc_html__( 'Weather forecast', 'lsvr-townpress-toolkit' ),
				                'category' => esc_html__( 'TownPress', 'lsvr-townpress-toolkit' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Townpress_Weather_Widget::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}

	}
}
?>