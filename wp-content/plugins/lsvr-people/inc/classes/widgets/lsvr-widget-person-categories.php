<?php
/**
 * LSVR Person categories widget
 *
 * Display list of lsvr_person_cat tax terms
 */
if ( ! class_exists( 'Lsvr_Widget_Person_Categories' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Person_Categories extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_people_person_categories',
			'classname' => 'lsvr_person-categories-widget',
			'title' => esc_html__( 'LSVR Person Categories', 'lsvr-people' ),
			'description' => esc_html__( 'List of Person Post categories', 'lsvr-people' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-people' ),
					'type' => 'text',
					'default' => esc_html__( 'Person Categories', 'lsvr-people' ),
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
					'taxonomy' => 'lsvr_person_cat',
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