<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_elements_toolkit_vc_config' );
if ( ! function_exists( 'lsvr_elements_toolkit_vc_config' ) ) {
	function lsvr_elements_toolkit_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_elements_toolkit_vc_init' );
			if ( ! function_exists( 'lsvr_elements_toolkit_vc_init' ) && function_exists( 'vc_set_as_theme' ) ) {
				function lsvr_elements_toolkit_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_elements_toolkit_register_vc_elements' );
			if ( ! function_exists( 'lsvr_elements_toolkit_register_vc_elements' ) ) {
				function lsvr_elements_toolkit_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Alert Message
						if ( class_exists( 'Lsvr_Shortcode_Alert_Message' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_alert_message',
				                'name' => esc_html__( 'LSVR Alert Message', 'lsvr-elements' ),
				                'description' => esc_html__( 'Block with text', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Alert_Message::lsvr_shortcode_atts(),
							));
						}

						// Button
						if ( class_exists( 'Lsvr_Shortcode_Button' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_button',
				                'name' => esc_html__( 'LSVR Button', 'lsvr-elements' ),
				                'description' => esc_html__( 'Basic button with link', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Button::lsvr_shortcode_atts(),
							));
						}

						// Counter
						if ( class_exists( 'Lsvr_Shortcode_Counter' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_counter',
				                'name' => esc_html__( 'LSVR Counter', 'lsvr-elements' ),
				                'description' => esc_html__( 'Block with number and label', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Counter::lsvr_shortcode_atts(),
							));
						}

						// CTA
						if ( class_exists( 'Lsvr_Shortcode_CTA' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_cta',
				                'name' => esc_html__( 'LSVR CTA', 'lsvr-elements' ),
				                'description' => esc_html__( 'Block with title, text and button', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_CTA::lsvr_shortcode_atts(),
							));
						}

						// Definition list widget
						if ( class_exists( 'Lsvr_Shortcode_Definition_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_definition_list_widget',
				                'name' => esc_html__( 'LSVR Definition List Widget', 'lsvr-elements' ),
				                'description' => esc_html__( 'List of definitions', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Definition_List_Widget::lsvr_shortcode_atts(),
							));
						}

						// Feature
						if ( class_exists( 'Lsvr_Shortcode_Feature' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_feature',
				                'name' => esc_html__( 'LSVR Feature', 'lsvr-elements' ),
				                'description' => esc_html__( 'Block with icon, title and text', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Feature::lsvr_shortcode_atts(),
							));
						}

						// Featured post widget
						if ( class_exists( 'Lsvr_Shortcode_Post_Featured_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_post_featured_widget',
				                'name' => esc_html__( 'LSVR Featured Post Widget', 'lsvr-elements' ),
				                'description' => esc_html__( 'Single post', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Post_Featured_Widget::lsvr_shortcode_atts(),
							));
						}

						// Post list widget
						if ( class_exists( 'Lsvr_Shortcode_Post_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_post_list_widget',
				                'name' => esc_html__( 'LSVR Posts Widget', 'lsvr-elements' ),
				                'description' => esc_html__( 'List of posts', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Post_List_Widget::lsvr_shortcode_atts(),
							));
						}

						// Pricing Table
						if ( class_exists( 'Lsvr_Shortcode_Pricing_Table' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_pricing_table',
				                'name' => esc_html__( 'LSVR Pricing Table', 'lsvr-elements' ),
				                'description' => esc_html__( 'Block with title, price, text and button', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Pricing_Table::lsvr_shortcode_atts(),
							));
						}

						// Progress bar
						if ( class_exists( 'Lsvr_Shortcode_Progress_bar' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_progress_bar',
				                'name' => esc_html__( 'LSVR Progress Bar', 'lsvr-elements' ),
				                'description' => esc_html__( 'Block with title and label', 'lsvr-elements' ),
				                'category' => esc_html__( 'LSVR Elements', 'lsvr-elements' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Progress_bar::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}

	}
}
?>