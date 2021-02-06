<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_directory_vc_config' );
if ( ! function_exists( 'lsvr_directory_vc_config' ) ) {
	function lsvr_directory_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_directory_vc_init' );
			if ( ! function_exists( 'lsvr_directory_vc_init' ) && function_exists( 'vc_set_as_theme' ) ) {
				function lsvr_directory_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_directory_register_vc_elements' );
			if ( ! function_exists( 'lsvr_directory_register_vc_elements' ) ) {
				function lsvr_directory_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Listing List Widget
						if ( class_exists( 'Lsvr_Shortcode_Listing_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_listing_list_widget',
				                'name' => esc_html__( 'LSVR Directory Widget', 'lsvr-directory' ),
				                'description' => esc_html__( 'List of listing posts', 'lsvr-directory' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-directory' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Listing_List_Widget::lsvr_shortcode_atts(),
							));
						}

						// Featured Listing Widget
						if ( class_exists( 'Lsvr_Shortcode_Listing_Featured_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_listing_featured_widget',
				                'name' => esc_html__( 'LSVR Featured Listing Widget', 'lsvr-directory' ),
				                'description' => esc_html__( 'Single listing post', 'lsvr-directory' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-directory' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Listing_Featured_Widget::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}

	}
}
?>