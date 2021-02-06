<?php
/**
 * Galleries permalink settings
 */
if ( ! class_exists( 'Lsvr_Permalink_Settings_Galleries' ) && class_exists( 'Lsvr_Permalink_Settings' ) ) {
    class Lsvr_Permalink_Settings_Galleries extends Lsvr_Permalink_Settings {

    	public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_galleries_permalink_settings',
				'title' => esc_html__( 'LSVR Galleries', 'lsvr-galleries' ),
				'option_id' => 'lsvr_galleries_permalinks',
				'fields' => array(
					'lsvr_gallery' => array(
						'type' => 'cpt',
						'label' => esc_html__( 'Archive Slug', 'lsvr-galleries' ),
						'default' => 'galleries',
					),
					'lsvr_gallery_cat' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Category Slug', 'lsvr-galleries' ),
						'default' => 'gallery-category',
					),
					'lsvr_gallery_tag' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Tag Slug', 'lsvr-galleries' ),
						'default' => 'gallery-tag',
					),
				),
			));

    	}

    }
}