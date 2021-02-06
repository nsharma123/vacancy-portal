<?php
/**
 * Directory permalink settings
 */
if ( ! class_exists( 'Lsvr_Permalink_Settings_Directory' ) && class_exists( 'Lsvr_Permalink_Settings' ) ) {
    class Lsvr_Permalink_Settings_Directory extends Lsvr_Permalink_Settings {

    	public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_directory_permalink_settings',
				'title' => esc_html__( 'LSVR Directory', 'lsvr-directory' ),
				'option_id' => 'lsvr_directory_permalinks',
				'fields' => array(
					'lsvr_listing' => array(
						'type' => 'cpt',
						'label' => esc_html__( 'Archive Slug', 'lsvr-directory' ),
						'default' => 'directory',
					),
					'lsvr_listing_cat' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Category Slug', 'lsvr-directory' ),
						'default' => 'directory-category',
					),
					'lsvr_listing_tag' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Tag Slug', 'lsvr-directory' ),
						'default' => 'directory-tag',
					),
				),
			));

    	}

    }
}