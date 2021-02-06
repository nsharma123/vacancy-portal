<?php
/**
 * Documents permalink settings
 */
if ( ! class_exists( 'Lsvr_Permalink_Settings_Documents' ) && class_exists( 'Lsvr_Permalink_Settings' ) ) {
    class Lsvr_Permalink_Settings_Documents extends Lsvr_Permalink_Settings {

    	public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_documents_permalink_settings',
				'title' => esc_html__( 'LSVR Documents', 'lsvr-documents' ),
				'option_id' => 'lsvr_documents_permalinks',
				'fields' => array(
					'lsvr_document' => array(
						'type' => 'cpt',
						'label' => esc_html__( 'Archive Slug', 'lsvr-documents' ),
						'default' => 'documents',
					),
					'lsvr_document_cat' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Category Slug', 'lsvr-documents' ),
						'default' => 'document-category',
					),
					'lsvr_document_tag' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Tag Slug', 'lsvr-documents' ),
						'default' => 'document-tag',
					),
				),
			));

    	}

    }
}