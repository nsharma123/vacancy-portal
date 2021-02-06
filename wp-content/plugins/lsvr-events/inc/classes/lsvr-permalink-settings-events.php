<?php
/**
 * Events permalink settings
 */
if ( ! class_exists( 'Lsvr_Permalink_Settings_Events' ) && class_exists( 'Lsvr_Permalink_Settings' ) ) {
    class Lsvr_Permalink_Settings_Events extends Lsvr_Permalink_Settings {

    	public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_events_permalink_settings',
				'title' => esc_html__( 'LSVR Events', 'lsvr-events' ),
				'option_id' => 'lsvr_events_permalinks',
				'fields' => array(
					'lsvr_event' => array(
						'type' => 'cpt',
						'label' => esc_html__( 'Archive Slug', 'lsvr-events' ),
						'default' => 'events',
					),
					'lsvr_event_location' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Location Slug', 'lsvr-events' ),
						'default' => 'event-location',
					),
					'lsvr_event_cat' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Category Slug', 'lsvr-events' ),
						'default' => 'event-category',
					),
					'lsvr_event_tag' => array(
						'type' => 'tax',
						'label' => esc_html__( 'Tag Slug', 'lsvr-events' ),
						'default' => 'event-tag',
					),
				),
			));

    	}

    }
}