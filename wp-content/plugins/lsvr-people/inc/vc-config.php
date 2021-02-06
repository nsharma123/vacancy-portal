<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_people_vc_config' );
if ( ! function_exists( 'lsvr_people_vc_config' ) ) {
	function lsvr_people_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_people_vc_init' );
			if ( ! function_exists( 'lsvr_people_vc_init' ) && function_exists( 'vc_set_as_theme' ) ) {
				function lsvr_people_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_people_register_vc_elements' );
			if ( ! function_exists( 'lsvr_people_register_vc_elements' ) ) {
				function lsvr_people_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Person List Widget
						if ( class_exists( 'Lsvr_Shortcode_Person_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_person_list_widget',
				                'name' => esc_html__( 'LSVR People Widget', 'lsvr-people' ),
				                'description' => esc_html__( 'List of person posts', 'lsvr-people' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-people' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Person_List_Widget::lsvr_shortcode_atts(),
							));
						}

						// Featured Person Widget
						if ( class_exists( 'Lsvr_Shortcode_Person_Featured_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_person_featured_widget',
				                'name' => esc_html__( 'LSVR Featured Person Widget', 'lsvr-people' ),
				                'description' => esc_html__( 'Single person post', 'lsvr-people' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-people' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Person_Featured_Widget::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}

	}
}
?>