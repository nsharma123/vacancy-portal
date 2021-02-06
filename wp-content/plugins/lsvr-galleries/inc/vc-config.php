<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_galleries_vc_config' );
if ( ! function_exists( 'lsvr_galleries_vc_config' ) ) {
	function lsvr_galleries_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_galleries_vc_init' );
			if ( ! function_exists( 'lsvr_galleries_vc_init' ) && function_exists( 'vc_set_as_theme' ) ) {
				function lsvr_galleries_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_galleries_register_vc_elements' );
			if ( ! function_exists( 'lsvr_galleries_register_vc_elements' ) ) {
				function lsvr_galleries_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Gallery List Widget
						if ( class_exists( 'Lsvr_Shortcode_Gallery_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_gallery_list_widget',
				                'name' => esc_html__( 'LSVR Galleries Widget', 'lsvr-galleries' ),
				                'description' => esc_html__( 'List of gallery posts', 'lsvr-galleries' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-galleries' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Gallery_List_Widget::lsvr_shortcode_atts(),
							));
						}

						// Featured Gallery Widget
						if ( class_exists( 'Lsvr_Shortcode_Gallery_Featured_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_gallery_featured_widget',
				                'name' => esc_html__( 'LSVR Featured Gallery Widget', 'lsvr-galleries' ),
				                'description' => esc_html__( 'Single gallery post', 'lsvr-galleries' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-galleries' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Gallery_Featured_Widget::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}

	}
}
?>