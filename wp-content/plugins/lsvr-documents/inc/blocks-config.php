<?php

// Register blocks
add_action( 'init', 'lsvr_documents_register_blocks', 20 );
if ( ! function_exists( 'lsvr_documents_register_blocks' ) ) {
	function lsvr_documents_register_blocks() {

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block' ) ) {

    		// Document List Widget
			if ( class_exists( 'Lsvr_Shortcode_Document_List_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-documents/document-list-widget', array(
					'attributes' => Lsvr_Shortcode_Document_List_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Document_List_Widget', 'shortcode' ),
				));
			}

    		// Featured Document Widget
			if ( class_exists( 'Lsvr_Shortcode_Document_Featured_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-documents/document-featured-widget', array(
					'attributes' => Lsvr_Shortcode_Document_Featured_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Document_Featured_Widget', 'shortcode' ),
				));
			}

    		// Document Attachments Widget
			if ( class_exists( 'Lsvr_Shortcode_Document_Attachments_Widget' ) ) {
				lsvr_framework_register_shortcode_block( 'lsvr-documents/document-attachments-widget', array(
					'attributes' => Lsvr_Shortcode_Document_Attachments_Widget::lsvr_shortcode_atts(),
					'render_callback' => array( 'Lsvr_Shortcode_Document_Attachments_Widget', 'shortcode' ),
				));
			}

		}

	}
}

// Register blocks JSON
add_filter( 'lsvr_framework_register_shortcode_blocks_json', 'lsvr_documents_register_blocks_json' );
if ( ! function_exists( 'lsvr_documents_register_blocks_json' ) ) {
	function lsvr_documents_register_blocks_json( $data = array() ) {

		$data = empty( $data ) ? array() : $data;

		if ( function_exists( 'register_block_type' ) && function_exists( 'lsvr_framework_register_shortcode_block_json' ) ) {

			// Document List Widget
			if ( class_exists( 'Lsvr_Shortcode_Document_List_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-documents/document-list-widget',
					'tag' => 'lsvr_document_list_widget',
					'title' => esc_html__( 'LSVR Documents Widget', 'lsvr-documents' ),
		        	'description' => esc_html__( 'List of document posts', 'lsvr-documents' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'media-document',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-documents' ),
		        	'attributes' => Lsvr_Shortcode_Document_List_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Featured Document Widget
			if ( class_exists( 'Lsvr_Shortcode_Document_Featured_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-documents/document-featured-widget',
					'tag' => 'lsvr_document_featured_widget',
					'title' => esc_html__( 'LSVR Featured Document Widget', 'lsvr-documents' ),
		        	'description' => esc_html__( 'Single document post', 'lsvr-documents' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'media-document',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-documents' ),
		        	'attributes' => Lsvr_Shortcode_Document_Featured_Widget::lsvr_shortcode_atts(),
				)));
			}

			// Document Attachments
			if ( class_exists( 'Lsvr_Shortcode_Document_Attachments_Widget' ) ) {
				array_push( $data, lsvr_framework_register_shortcode_block_json( array(
					'name' => 'lsvr-documents/document-attachments-widget',
					'tag' => 'lsvr_document_attachments_widget',
					'title' => esc_html__( 'LSVR Document Attachments Widget', 'lsvr-documents' ),
		        	'description' => esc_html__( 'List of attachments', 'lsvr-documents' ),
		        	'category' => 'lsvr-widgets',
		        	'icon' => 'media-document',
		        	'panel_title' => esc_html__( 'Settings', 'lsvr-documents' ),
		        	'attributes' => Lsvr_Shortcode_Document_Attachments_Widget::lsvr_shortcode_atts(),
				)));
			}

		}

		return $data;

	}
}

?>