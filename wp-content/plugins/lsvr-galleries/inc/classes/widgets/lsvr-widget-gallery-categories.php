<?php
/**
 * LSVR Gallery categories widget
 *
 * Display list of lsvr_gallery_cat tax terms
 */
if ( ! class_exists( 'Lsvr_Widget_Gallery_Categories' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Gallery_Categories extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_galleries_gallery_categories',
			'classname' => 'lsvr_gallery-categories-widget',
			'title' => esc_html__( 'LSVR Gallery Categories', 'lsvr-galleries' ),
			'description' => esc_html__( 'List of Gallery categories', 'lsvr-galleries' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-galleries' ),
					'type' => 'text',
					'default' => esc_html__( 'Gallery Categories', 'lsvr-galleries' ),
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
					'taxonomy' => 'lsvr_gallery_cat',
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