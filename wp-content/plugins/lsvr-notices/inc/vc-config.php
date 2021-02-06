<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_notices_vc_config' );
if ( ! function_exists( 'lsvr_notices_vc_config' ) ) {
	function lsvr_notices_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_notices_vc_init' );
			if ( ! function_exists( 'lsvr_notices_vc_init' ) ) {
				function lsvr_notices_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_notices_register_vc_elements' );
			if ( ! function_exists( 'lsvr_notices_register_vc_elements' ) ) {
				function lsvr_notices_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Listing List Widget
						if ( class_exists( 'Lsvr_Shortcode_Notice_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_notice_list_widget',
				                'name' => esc_html__( 'LSVR Notices Widget', 'lsvr-notices' ),
				                'description' => esc_html__( 'List of notice posts', 'lsvr-notices' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-notices' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Notice_List_Widget::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}

	}
}
?>