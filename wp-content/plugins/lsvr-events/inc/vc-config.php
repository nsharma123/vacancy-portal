<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_events_vc_config' );
if ( ! function_exists( 'lsvr_events_vc_config' ) ) {
	function lsvr_events_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_events_vc_init' );
			if ( ! function_exists( 'lsvr_events_vc_init' ) && function_exists( 'vc_set_as_theme' ) ) {
				function lsvr_events_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_events_register_vc_elements' );
			if ( ! function_exists( 'lsvr_events_register_vc_elements' ) ) {
				function lsvr_events_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Event List Widget
						if ( class_exists( 'Lsvr_Shortcode_Event_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_event_list_widget',
				                'name' => esc_html__( 'LSVR Events Widget', 'lsvr-events' ),
				                'description' => esc_html__( 'List of event posts', 'lsvr-events' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-events' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Event_List_Widget::lsvr_shortcode_atts(),
							));
						}

						// Featured Event Widget
						if ( class_exists( 'Lsvr_Shortcode_Event_Featured_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_event_featured_widget',
				                'name' => esc_html__( 'LSVR Featured Event Widget', 'lsvr-events' ),
				                'description' => esc_html__( 'Single event post', 'lsvr-events' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-events' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Event_Featured_Widget::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}


	}
}
?>