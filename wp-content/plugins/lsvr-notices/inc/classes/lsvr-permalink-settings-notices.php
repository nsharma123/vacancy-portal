<?php
/**
 * Notices permalink settings
 */
if ( ! class_exists( 'Lsvr_Permalink_Settings_Notices' ) && class_exists( 'Lsvr_Permalink_Settings' ) ) {
    class Lsvr_Permalink_Settings_Notices extends Lsvr_Permalink_Settings {

    	public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_notices_permalink_settings',
				'title' => esc_html__( 'LSVR Notices', 'lsvr-notices' ),
				'option_id' => 'lsvr_notices_permalinks',
				'fields' => array(
					'lsvr_notice' => array(
						'type' => 'cpt',
						'label' => esc_html__( 'Archive Slug', 'lsvr-notices' ),
						'default' => 'notices',
					),
					'lsvr_notice_cat' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Category Slug', 'lsvr-notices' ),
						'default' => 'notice-category',
					),
					'lsvr_notice_tag' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Tag Slug', 'lsvr-notices' ),
						'default' => 'notice-tag',
					),
				),
			));

    	}

    }
}