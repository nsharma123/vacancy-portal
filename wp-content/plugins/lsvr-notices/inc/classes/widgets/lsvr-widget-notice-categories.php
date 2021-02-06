<?php
/**
 * LSVR Notice categories widget
 *
 * Display list of lsvr_notice_cat tax terms
 */
if ( ! class_exists( 'Lsvr_Widget_Notice_Categories' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Notice_Categories extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_notices_notice_categories',
			'classname' => 'lsvr_notice-categories-widget',
			'title' => esc_html__( 'LSVR Notice Categories', 'lsvr-notices' ),
			'description' => esc_html__( 'List of Notice Post categories', 'lsvr-notices' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-notices' ),
					'type' => 'text',
					'default' => esc_html__( 'Notice Categories', 'lsvr-notices' ),
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
					'taxonomy' => 'lsvr_notice_cat',
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