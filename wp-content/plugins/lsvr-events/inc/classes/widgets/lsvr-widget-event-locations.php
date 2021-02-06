<?php
/**
 * LSVR Event locations widget
 *
 * Display list of lsvr_event_location tax terms
 */
if ( ! class_exists( 'Lsvr_Widget_Event_Locations' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Event_Locations extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_events_event_locations',
			'classname' => 'lsvr_event-locations-widget',
			'title' => esc_html__( 'LSVR Event Locations', 'lsvr-events' ),
			'description' => esc_html__( 'List of Event Locations', 'lsvr-events' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-events' ),
					'type' => 'text',
					'default' => esc_html__( 'Event Locations', 'lsvr-events' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {
        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

			<ul class="root">
	        	<?php wp_list_categories(array(
					'title_li' => '',
					'taxonomy' => 'lsvr_event_location',
					'show_count' => false,
				)); ?>
			</ul>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php
    }

}}

?>