<?php // Config Visual Composer Page Builder
add_action( 'plugins_loaded', 'lsvr_documents_vc_config' );
if ( ! function_exists( 'lsvr_documents_vc_config' ) ) {
	function lsvr_documents_vc_config() {

		if ( function_exists( 'vc_set_as_theme' ) ) {

			// Set as theme
			add_action( 'vc_before_init', 'lsvr_documents_vc_init' );
			if ( ! function_exists( 'lsvr_documents_vc_init' ) && function_exists( 'vc_set_as_theme' ) ) {
				function lsvr_documents_vc_init() {
					vc_set_as_theme();
				}
			}

			// Register VC elements
			add_action( 'init', 'lsvr_documents_register_vc_elements' );
			if ( ! function_exists( 'lsvr_documents_register_vc_elements' ) ) {
				function lsvr_documents_register_vc_elements() {

					 if ( function_exists( 'lsvr_framework_vc_map' ) ) {

						// Documents widget
						if ( class_exists( 'Lsvr_Shortcode_Document_List_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_document_list_widget',
				                'name' => esc_html__( 'LSVR Documents Widget', 'lsvr-documents' ),
				                'description' => esc_html__( 'List of document posts', 'lsvr-documents' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-documents' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Document_List_Widget::lsvr_shortcode_atts(),
							));
						}

						// Featured Document Widget
						if ( class_exists( 'Lsvr_Shortcode_Document_Featured_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_document_featured_widget',
				                'name' => esc_html__( 'LSVR Featured Document Widget', 'lsvr-documents' ),
				                'description' => esc_html__( 'Single document post', 'lsvr-documents' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-documents' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Document_Featured_Widget::lsvr_shortcode_atts(),
							));
						}

						// Document Attachments Widget
						if ( class_exists( 'Lsvr_Shortcode_Document_Attachments_Widget' ) ) {
							lsvr_framework_vc_map(array(
				                'base' => 'lsvr_document_attachments_widget',
				                'name' => esc_html__( 'LSVR Document Attachments Widget', 'lsvr-documents' ),
				                'description' => esc_html__( 'List of attachments', 'lsvr-documents' ),
				                'category' => esc_html__( 'LSVR Widgets', 'lsvr-documents' ),
				                'content_element' => true,
				                'show_settings_on_create' => true,
				                'params' => Lsvr_Shortcode_Document_Attachments_Widget::lsvr_shortcode_atts(),
							));
						}

					}

				}
			}

		}

	}
}