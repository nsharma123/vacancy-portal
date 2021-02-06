<?php
/**
 * People permalink settings
 */
if ( ! class_exists( 'Lsvr_Permalink_Settings_People' ) && class_exists( 'Lsvr_Permalink_Settings' ) ) {
    class Lsvr_Permalink_Settings_People extends Lsvr_Permalink_Settings {

    	public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_people_permalink_settings',
				'title' => esc_html__( 'LSVR People', 'lsvr-people' ),
				'option_id' => 'lsvr_people_permalinks',
				'fields' => array(
					'lsvr_person' => array(
						'type' => 'cpt',
						'label' => esc_html__( 'Archive Slug', 'lsvr-people' ),
						'default' => 'people',
					),
					'lsvr_person_cat' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Category Slug', 'lsvr-people' ),
						'default' => 'person-category',
					),
				),
			));

    	}

    }
}